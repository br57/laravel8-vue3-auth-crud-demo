<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\modelHelper;
use Spatie\Permission\Traits\HasRoles;
class User extends Authenticatable
{
    use HasRoles, HasApiTokens, HasFactory, Notifiable, SoftDeletes, modelHelper;
    
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        if (empty($this->uuid)){
            $this->uuid = Str::uuid()->toString();
        }
    }

    private function _allValidations(){
        $uuid_val = 'required|uuid|exists:users,uuid';
        return (Object) [
            'post' => [
                'name' => 'required|string|max:24',
                'email' => 'required|email|unique:users,email',
                'phone' => 'nullable|string|max:14',
                'status_uuid' => 'required|uuid|exists:statuses,uuid',
            ],
            'patch' => [
                'uuid' => $uuid_val,
                'name' => 'filled|string|max:24',
                'phone' => 'nullable|string|max:14',
                'status_uuid' => 'filled|uuid|exists:statuses,uuid',
            ],
            'uuid' => [
                'uuid' => $uuid_val,
            ],
        ];
    }
    
    protected $fillable = [
        'uuid',
        'name',
        'email',
        'password',
        'phone',
        'status_id',
    ];

    protected $hidden = [
        'password',
        'id',
    ];

    protected $visible = [
        'uuid',
        'name',
        'email',
        'phone',
        'status_uuid',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $appends = [
        'status_uuid'
    ];

    protected $with = [
        
    ];


    
    public function status()
    {
        return $this->hasOne(\App\Models\Status::class, 'id', 'status_id');
    }

    public function getStatusUuidAttribute(){
        return (!is_null($this->status)) ? $this->status->uuid : null;
    }
}
