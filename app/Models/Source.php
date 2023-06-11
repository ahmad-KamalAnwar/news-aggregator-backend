<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

/**
 * @property string name
 *
 * @method static Source updateOrCreate(array $uniqueFields, array $data)
 * @method static Source|Builder whereIn(string $column, array $data)
 */
class Source extends BaseModel
{
    const THE_GUARDIAN = 'The Guardian';
    /**
     * @var string
     */
    protected $table = 'sources';

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
