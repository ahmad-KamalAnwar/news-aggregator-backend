<?php

namespace App\Models;

use Closure;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection as SupportCollection;

/**
 * Class MyDocModel
 * @package App\Models
 *
 * @method Model|Collection|null static $this find($id, $columns = ['*']) Find a model by its primary key.
 * @method static Collection findMany($ids, $columns = ['*']) Find a model by its primary key.
 * @method static Model|Collection findOrFail($id, $columns = ['*']) Find a model by its primary key or throw an exception.
 * @method Model|EloquentBuilder firstOrFail($columns = ['*']) Execute the query and get the first result or throw an exception.
 * @method Collection|EloquentBuilder[] get($columns = ['*']) Execute the query as a "select" statement.
 * @method mixed value($column) Get a single column's value from the first result of a query.
 * @method void chunk($count, callable $callback) Chunk the results of the query.
 * @method SupportCollection lists($column, $key = null) Get an array with the values of a given column.
 * @method LengthAwarePaginator paginate($perPage = null, $columns = ['*'], $pageName = 'page', $page = null) Paginate the given query.
 * @method Paginator simplePaginate($perPage = null, $columns = ['*'], $pageName = 'page') Paginate the given query into a simple paginator.
 * @method int increment($column, $amount = 1, array $extra = []) Increment a column's value by a given amount.
 * @method int decrement($column, $amount = 1, array $extra = []) Decrement a column's value by a given amount.
 * @method void onDelete(Closure $callback) Register a replacement for the default delete function.
 * @method Model[] getModels($columns = ['*']) Get the hydrated models without eager loading.
 * @method array eagerLoadRelations(array $models) Eager load the relationships for the models.
 * @method array loadRelation(array $models, $name, Closure $constraints) Eagerly load the relationship on a set of models.
 * @method static $this where($column, $operator = null, $value = null) Add a basic where clause to the query.
 * @method $this orWhere($column, $operator = null, $value = null) Add an "or where" clause to the query.
 * @method $this has($relation, $operator = '>=', $count = 1, $boolean = 'and', Closure $callback = null) Add a relationship count condition to the query.
 *
 * @method static $this whereRaw($sql, array $bindings = [])
 * @method static $this whereBetween($column, array $values)
 * @method static $this whereNotBetween($column, array $values)
 * @method static $this whereNested(Closure $callback)
 * @method static $this addNestedWhereQuery($query)
 * @method static $this whereExists(Closure $callback)
 * @method static $this whereNotExists(Closure $callback)
 * @method static $this whereIn($column, $values)
 * @method static $this whereNotIn($column, $values)
 * @method static $this whereNull($column)
 * @method static $this whereNotNull($column)
 * @method $this orWhereRaw($sql, array $bindings = [])
 * @method $this orWhereBetween($column, array $values)
 * @method $this orWhereNotBetween($column, array $values)
 * @method $this orWhereExists(Closure $callback)
 * @method $this orWhereNotExists(Closure $callback)
 * @method $this orWhereIn($column, $values)
 * @method $this orWhereNotIn($column, $values)
 * @method $this orWhereNull($column)
 * @method $this orWhereNotNull($column)
 * @method $this whereDate($column, $operator, $value)
 * @method $this whereDay($column, $operator, $value)
 * @method $this whereMonth($column, $operator, $value)
 * @method $this whereYear($column, $operator, $value)
 *
 * @method static array pluck($columns)
 * @method static $this distinct($columns)
 * @method static int count($columns=null)
 */
class PhpDocModel extends Model
{
    //
}
