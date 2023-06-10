<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int id
 * @property string title
 * @property string description
 * @property string content
 * @property string web_url
 * @property Carbon published_at
 * @property int source_id
 * @property int category_id
 * @property int author_id
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 * @property Category category
 * @property Author author
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
        'description',
        'web_url',
        'title',
        'content',
        'published_at',
        'source_id',
        'category_id',
        'author_id'
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

    /**
     * @return BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(Author::class, 'author_id');
    }
}
