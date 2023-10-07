<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => (int)$this->id,

            'status' => (string)$this->status,

            'prefix' => (string)$this->prefix,
            'first_name' => (string)$this->first_name,
            'last_name' => (string)$this->last_name,
            'email' => (string)$this->email,
            'username' => (string)$this->username,
            'image_url' => (string)$this->image_url,
            
            'job_title' => (string)$this->job_title,
            'role' => (string)$this->role,

            'phone' => (string)$this->phone,
            'mobile' => (string)$this->mobile,

            'address_line_1' => (string)$this->address_line_1,
            'address_line_2' => (string)$this->address_line_2,
            'city' => (string)$this->city,
            'province' => (string)$this->province,
            'zip' => (string)$this->zip,
            'country' => (string)$this->country,

            'token'=>(string)$this->remember_token,

            'company_name'=>(string)$this->company_name,
            'company_email'=>(string)$this->company_email,
            'company_sector'=>(string)$this->company_sector,
            'company_website'=>(string)$this->company_website,

            'created_at' => (string)$this->created_at
        ];
    }
}