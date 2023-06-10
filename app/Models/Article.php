<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int id
 * @property string abstract
 * @property string web_url
 * @property string snippet
 * @property string headline_main
 * @property Carbon publish_date
 * @property Carbon document_type
 * @property Carbon document_id
 * @property Carbon document_uri
 * @property int source_id
 * @property int category_id
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 * @property Category category
 * @property Source source
 *
 * @method static Article find($id)
 * @method Article first($columns = ['*']) Execute the query and get the first result.
 */
class Article extends BaseModel
{
    use HasFactory;
    /**
     * @var string
     */
    protected $table = 'articles';

    /**
     * @var string[]
     */
    protected $fillable = [
        'abstract',
        'web_url',
        'snippet',
        'headline_main',
        'publish_date',
        'document_type',
        'document_id',
        'document_uri',
        'source_id',
        'category_id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * @return BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * @return BelongsTo
     */
    public function source()
    {
        return $this->belongsTo(Category::class, 'source_id');
    }
}
