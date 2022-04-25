<?php

namespace App\Models;

use App\Models\Employee;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        if (empty($this->uuid)){
            $this->uuid = Str::uuid()->toString();
        }
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'uuid',
        'name',
        'email',
        'logo',
        'website',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'id',
    ];

    protected $visible = [
        'uuid',
        'name',
        'email'
    ];

    protected $dispatchesEvents = [
        "created"   => \App\Events\Models\Company\CompanyCreatedEvent::class,
        "updated"   => \App\Events\Models\Company\CompanyUpdatedEvent::class,
        "deleting"  => \App\Events\Models\Company\CompanyDeleteEvent::class,
    ];

    /**
     * Get Employees
     * 
     */
    public function employees()
    {
        return $this->hasMany(Employee::class, 'company_id', 'id');
    }
}
