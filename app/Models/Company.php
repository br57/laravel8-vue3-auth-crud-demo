<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Employee;

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

    /**
     * Get Employees
     * 
     */
    public function employees()
    {
        return $this->hasMany(Employee::class, 'company_id', 'id');
    }
}
