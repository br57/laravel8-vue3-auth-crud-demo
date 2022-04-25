<?php

namespace App\Models;

use App\Models\Employee;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\modelHelper;

class Company extends Model
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
        $uuid_val = 'required|uuid|exists:companies,uuid';
        return (Object) [
            'post' => [
                'name' => 'filled|string|max:24',
                'email' => 'filled|email|unique:companies,email',
                'logo' => 'nullable|string',
                'website' => 'nullable|string',
                'status_uuid' => 'nullable|uuid|exists:statuses,uuid',
            ],
            'patch' => [
                'uuid' => $uuid_val,
                'name' => 'filled|string|max:24',
                'logo' => 'nullable|string',
                'website' => 'nullable|string',
                'status_uuid' => 'nullable|uuid|exists:statuses,uuid',
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
        'logo',
        'website',
        'status_id',
    ];

    protected $hidden = [
        'id',
    ];

    protected $visible = [
        'uuid',
        'name',
        'email',
        'logo',
        'website',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $dispatchesEvents = [
        "created"   => \App\Events\Modules\Company\CompanyCreatedEvent::class,
        "updated"   => \App\Events\Modules\Company\CompanyUpdatedEvent::class,
        "deleting"  => \App\Events\Modules\Company\CompanyDeleteEvent::class,
    ];

    public function employees()
    {
        return $this->hasMany(Employee::class, 'company_id', 'id');
    }
    
    public function status()
    {
        return $this->hasOne(\App\Models\Status::class, 'id', 'status_id');
    }

    
}
