<?php

namespace App\Http\Resources\Modules;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'uuid' => $this->uuid,
            'company_uuid' => !is_null($this->company) ? $this->company->uuid : null,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'display_name' => "{$this->first_name} {$this->last_name}",
            'email' => $this->email,
            'phone' => $this->phone,
            'status_uuid' => (!is_null($this->status)) ? $this->status->uuid : null,
            'user_uuid' => (!is_null($this->user)) ? $this->user->uuid : null,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}