<?php

namespace App\Models;

use App\Traits\DailyUsage;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Spatie\MediaLibrary\InteractsWithMedia;
use Nicolaslopezj\Searchable\SearchableTrait;
use CyrildeWit\EloquentViewable\Support\Period;
use CyrildeWit\EloquentViewable\Contracts\Viewable;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

class Usecase extends Model implements TranslatableContract, Viewable , HasMedia
{
    use HasFactory, Translatable, InteractsWithMedia, InteractsWithViews, SearchableTrait , DailyUsage;

    /**
     * Array with the fields translated in the Translation table.
     *
     * @var array
     */
    public $translatedAttributes = ['name', 'description'];

    /**
     * The columns that are fillable
     *
     * @var array
     */
    protected $fillable = ['status', 'color','order','icon_class', 'icon_type','command','fields'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['status' => 'boolean' , 'fields' => 'object'];

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
            'usecase_translations.name' => 10,
            'usecase_translations.description' => 10,
        ],
        'joins' => [
            'usecase_translations' => ['usecases.id', 'usecase_translations.usecase_id'],
        ],
        'groupBy' => [
            'usecases.id'
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

    public function plan()
    {
        return $this->morphedByMany(Plan::class, 'caseable')->withPivot('id');
    }

    /**
     * The post views
     *
     * @return bollval
     */
    public function getHasViews()
    {
        return (bool) \Setting::get('usecase_views', true);
    }

    public function thisWeek()
    {
        $period = Period::create(now()->startOfWeek(), now()->endOfWeek());

        return $this->views()->withinPeriod($period);
    }

    public function lastWeek()
    {
        $period = Period::create(now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek());

        return $this->views()->withinPeriod($period);
    }
}
