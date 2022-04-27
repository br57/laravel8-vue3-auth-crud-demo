<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\modelHelper;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory, modelHelper, SoftDeletes;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        if (empty($this->uuid)){
            $this->uuid = Str::uuid()->toString();
        }
    }

    private function _allValidations(){
        $uuid_val = 'required|uuid|exists:employees,uuid';
        return (Object) [
            'post' => [
                'first_name' => 'required|string|max:24',
                'last_name' => 'required|string|max:24',
                'email' => 'required|email|unique:employees,email',
                'phone' => 'nullable|string|max:14',
                'status_uuid' => 'required|uuid|exists:statuses,uuid',
                'user_uuid' => 'nullable|uuid|exists:users,uuid',
            ],
            'patch' => [
                'uuid' => $uuid_val,
                'first_name' => 'filled|string|max:24',
                'last_name' => 'filled|string|max:24',
                'phone' => 'nullable|string|max:14',
                'status_uuid' => 'filled|uuid|exists:statuses,uuid',
                'user_uuid' => 'nullable|uuid|exists:users,uuid',
            ],
            'uuid' => [
                'uuid' => $uuid_val,
            ],
        ];
    }

    protected $fillable = [
        'uuid',
        'company_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'status_id',
        'user_id',
    ];

    protected $hidden = [
        'id',
    ];

    protected $visible = [
        'uuid',
        'first_name',
        'last_name',
        'email',
        'phone',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    
    public function company()
    {
        return $this->hasOne(\App\Models\Company::class, 'id', 'company_id');
    }

    public function status()
    {
        return $this->hasOne(\App\Models\Status::class, 'id', 'status_id');
    }

    public function user()
    {
        return $this->hasOne(\App\Models\User::class, 'id', 'user_id');
    }
}
