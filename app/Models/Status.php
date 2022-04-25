<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\modelHelper;

class status extends Model
{
    use HasFactory, SoftDeletes, modelHelper;
    
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
                'label' => 'required|string|max:24',
            ],
            'patch' => [
                'uuid' => $uuid_val,
                'label' => 'filled|string|max:24',
            ],
            'uuid' => [
                'uuid' => $uuid_val,
            ],
        ];
    }

    protected $fillable = [
        'uuid',
        'label',
        'slug',
    ];

    protected $hidden = [
        'id',
    ];

    protected $visible = [
        'uuid',
        'label',
        'slug',
    ];

}
