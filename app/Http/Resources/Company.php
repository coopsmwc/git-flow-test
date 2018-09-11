<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Company extends JsonResource
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
            [
                'name' => 'Email Domains',
                'columns' => [
                    'domain' => 'Email domain',
                    'created_at' => 'Date Added'
                ],
                'data' => $this->companyDomains
            ],
            [
                'name' => 'Administrators',
                'columns' => [
                    'name' => 'Name',
                    'email' => 'Email',
                    'created_at' => 'Date Added'
                ],
                'data' => $this->companyAdmins->user
            ],
            [
                'name' => 'Email Addresses',
                'columns' => [
                    'email' => 'Email',
                    'created_at' => 'Date Added'
                ],
                'data' => $this->companyEmails
            ]
        ];
    }
}
