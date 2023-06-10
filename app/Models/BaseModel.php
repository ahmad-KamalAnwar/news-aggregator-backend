<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class BaseModel
 *
 * @property int anonymous
 * @property int $id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @method static $this latest()
 * @method static $this orderBy(string $column, string $order='asc')
 * @method static Builder|BaseModel firstOrCreate(array $data)
 * @method static Builder|$this updateOrCreate(array $uniqueFields, array $data)
 * @method static Builder|$this first()
 */
class BaseModel extends PhpDocModel
{
    /**
     * @var string custom Carbon date/time format applied only for serialization (get not set)
     */
    protected $serializeDateFormat = null;

    /**
     * scope to apply date range in result set.
     * @param $query
     * @param $startDate
     * @param $endDate
     * @return mixed
     */
    public function scopeInDateRange($query, $startDate, $endDate)
    {
        if (!empty($startDate)) {
            $query->where($this->table . '.created_at', '>=', $startDate);
        }

        if (!empty($endDate)) {
            $query->where($this->table . '.created_at', '<=', $endDate);
        }

        return $query;
    }

    public function getAllAttributes()
    {
        $columns = $this->getFillable();
        $attributes = $this->getAttributes();

        foreach ($columns as $column)
        {
            if (!array_key_exists($column, $attributes)) {
                $attributes[$column] = null;
            }
        }

        return $attributes;
    }

    /**
     * Prepare a date for array JSON serialization.
     * @param  \DateTime  $date
     * @return string
     */
    protected function serializeDate(\DateTimeInterface $date)
    {
        $format = $this->serializeDateFormat ?? $this->getDateFormat();

        return $date->format($format);
    }

    /**
     * Sets date serialization format per instance
     * @param $format
     */
    public function setSerializeDateFormat($format)
    {
        $this->serializeDateFormat = $format;
    }
}
