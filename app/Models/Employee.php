<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Company;

class Employee extends Model
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
        'company_id',
        'first_name',
        'last_name',
        'email',
        'phone',
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
        'first_name',
        'last_name',
        'email',
        'phone',
        'status',
    ];

    /**
     * Get Company
     * 
     */
    public function company()
    {
        return $this->hasOne(Company::class, 'id', 'company_id');
    }
}
