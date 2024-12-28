<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Validator;
use DB;

use App\Models\User;

use App\Http\Resources\UserResource;
use App\Http\Resources\UsersResource;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $where = [
            ['deprecated', '=', 0]
        ];

        if ($request->input('status') AND $request->input('status') != null AND $request->input('status')!='') {
            $where[] = [
                'status', '=', $request->input('status')
            ];
        }

        $order = 'asc';
        if ($request->input('order') AND $request->input('order') != null AND $request->input('order') != '') {
            if ($request->input('order')== 'asc' OR $request->input('order')=='desc') {
                $order = $request->input('order');
            }
        }

        $page = 1;
		if ($request->input('page') AND $request->input('page') != null AND $request->input('page') != '') {
			$page = $request->input('page');
		}

        $users = User::where($where)->orderBy('id', $order)->paginate(10);

        return new UsersResource($users);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [];

        $_input = $request->input();

        $validator = Validator::make($_input, $rules);

        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();

            $data = [
                'status' => 'fail',
                'errors' => $errors
            ];
        } else {
            DB::beginTransaction();

            $user = new User($_input);
            $user->status = "Active";
            $user->role = '';

            $user->save();

            DB::commit();

            $user_resource = new UserResource($user);

            $data = [
                'status' => 'Success',
                'data' => [
                    'id' => $user->id,
                    'user' => $user_resource
                ]
            ];
        }

        return response()->json($data);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $where = [
            ['deprecated', '=', 0],
            ['id', '=', $id]
        ];
        $user = User::where($where)->first();

        if ($user) {
            return new UserResource($user);
        } else {
            $errors = [
                'User does not exist!'
            ];

            $data = [
                'status' => 'Fail',
                'errors' => $errors
            ];
        }

        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        
        $rules = [];

        $_input = $request->input();

        $validator = Validator::make($_input, $rules);

        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();

            $data = [
                'status' => 'Fail',
                'errors' => $errors
            ];
        } else {
            DB::beginTransaction();

            $where = [
                ['deprecated', '=', 0],
                ['id', '=', $id],
            ];
            $user = User::where($where)->first();

            if ($user) {
                $user->fill($_input);
                $user->save();

                DB::commit();

                $user_resource = new UserResource($user);

                $data = [
                    'status' => 'Success',
                    'data' => [
                        'id' => $user->id,
                        'user' => $user_resource
                    ]
                ];
            } else {
                DB::rollback();

                $errors = [
                    'User does not exists'
                ];

                $data = [
                    'status' => 'Fail',
                    'errors' => $errors
                ];
            }
        }

        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $where = [
            ['deprecated', '=', 0],
            ['id', '=', $id]
        ];
        $user = User::where($where)->first();

        if ($user) {
            $user->deprecated = 1;
            $user->save();

            $user_resource = new UserResource($user);

            $data = [
                'status' => 'Success',
                'data' => [
                    'id' => $user->id,
                    'user' => $user_resource
                ]
			];
        } else {
            $errors = [
                'User does not exist'
            ];

            $data = [
                'status' => 'Fail',
                'errors' => $errors
            ];
        }

        return response()->json($data);
    }

    public function universal_uploader(Request $request)
	{
		$rules = [
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ];

        $_input = $request->all();

        $validator = Validator::make($_input, $rules);

        if ($validator->fails()) {
			$errors = $validator->errors()->toArray();

			$data = [
				'status' => 'Fail',
				'errors' => $errors
			];
        } else {
			$file = $request->file('file');

            $directory = 'file';
			if (isset($_input['path_name'])) {
                $directory = $_input['path_name'];
            }

			$extension = strtolower($file->getClientOriginalExtension());
			$filename = 'LF-' . rand(1000, 9999) . '-' . time() . '.'.$extension;

			$response = $file->storeAs($directory, $filename, 'public');
            
			if ($response) {
                $url = env('APP_URL')."/storage/{$response}";

				$data = [
					'status' => 'Success',
					'data' => [
						'url' => $url,
					]
				];
			} else {
				$errors = [
					'Error uploading the file!'
				];

				$data = [
					'status' => 'Fail',
					'errors' => $errors
				];				
			}
        }
		
		return response()->json($data);
	}

    public function universal_file_uploader(Request $request)
	{
		$rules = [
            'file' => 'required',
        ];

        $_input = $request->all();

        $validator = Validator::make($_input, $rules);

        if ($validator->fails()) {
			$errors = $validator->errors()->toArray();

			$data = [
				'status' => 'Fail',
				'errors' => $errors
			];
        } else {
			$file = $request->file('file');

            $directory = 'file';
			if (isset($_input['path_name'])) {
                $directory = $_input['path_name'];
            }

			$extension = strtolower($file->getClientOriginalExtension());
			$filename = 'LF-' . rand(1000, 9999) . '-' . time() . '.'.$extension;

			$response = $file->storeAs($directory, $filename, 'public');
            
			if ($response) {
                $url = env('APP_URL')."/storage/{$response}";

				$data = [
					'status' => 'Success',
					'data' => [
						'url' => $url,
                        'extension' => $extension
					]
				];
			} else {
				$errors = [
					'Error uploading the file!'
				];

				$data = [
					'status' => 'Fail',
					'errors' => $errors
				];				
			}
        }
		
		return response()->json($data);
	}
}
