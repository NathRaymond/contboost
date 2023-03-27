<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Nicolaslopezj\Searchable\SearchableTrait;
use CyrildeWit\EloquentViewable\Contracts\Viewable;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

class Plan extends Model implements TranslatableContract, Viewable
{
    use HasFactory, Translatable, InteractsWithViews, SearchableTrait;

    /**
     * Array with the fields translated in the Translation table.
     *
     * @var array
     */
    public $translatedAttributes = ['name', 'plan_id', 'description'];

    /**
     * The columns that are fillable
     *
     * @var array
     */
    protected $fillable = ['id', 'status', 'monthly_price', 'yearly_price', 'is_support', 'no_of_words', 'recommended', 'usecase_daily_limit'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'status' => 'boolean',
        'recommended' => 'boolean',
        'is_support' => 'boolean',
    ];

    /**
     * Searchable rules.
     *
     * @var array
     */
    protected $searchable = [
        /**
         * Columns and their priority in search results.
         * Columns with higher values are more important.
         * Columns with equal values have equal importance.
         *
         * @var array
         */
        'columns' => [
            'plan_translations.name' => 10,
            'plan_translations.description' => 10,
        ],
        'joins' => [
            'plan_translations' => ['plans.id', 'plan_translations.plan_id'],
        ],
        'groupBy' => [
            'plans.id'
        ]
    ];

    /**
     * Scope to get active tags
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where("status", true);
    }

    public function usecases()
    {
        return $this->morphToMany(Usecase::class, 'caseable');
    }
}
