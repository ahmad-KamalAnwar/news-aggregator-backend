<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

/**
 * @property string name
 *
 * @method static Category updateOrCreate(array $uniqueFields, array $data)
 * @method static Category|Builder whereIn(string $column, array $data)
 */
class Category extends BaseModel
{
    /**
     * @var string
     */
    protected $table = 'categories';

    /**
     * @var string[]
     */
    protected $fillable = [
        'name'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
