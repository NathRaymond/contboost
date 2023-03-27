<?php

namespace App\Models;

use App\Models\Category;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nicolaslopezj\Searchable\SearchableTrait;
use CyrildeWit\EloquentViewable\Contracts\Viewable;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

class Post extends Model implements TranslatableContract, Viewable, HasMedia
{
    use HasFactory, Translatable, InteractsWithViews, SearchableTrait, SoftDeletes, InteractsWithMedia;

    /**
     * The columns that are translateable
     *
     * @var array
     */
    public $translatedAttributes = ['title', 'slug', 'contents', 'meta_title', 'meta_description', 'og_title', 'og_description', 'excerpt'];

    /**
     * The columns that are fillable
     *
     * @var array
     */
    protected $fillable = ['author_id', 'status'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['comments_status' => 'boolean'];

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
            'post_translations.title' => 10,
            'posts.status' => 5,
            'users.name' => 5,
        ],
        'joins' => [
            'post_translations' => ['posts.id', 'post_translations.post_id'],
            'users' => ['users.id', 'posts.author_id']
        ],
        'groupBy' => [
            'posts.id'
        ]
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('featured-image')
            ->withResponsiveImages();
    }

    /**
     * posts have many tags
     */
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    /**
     * posts have many categories
     */
    public function categories()
    {
        return $this->morphToMany(Category::class, 'catable');
    }

    /**
     * Post belongs to author
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id', 'id');
    }

    /**
     * Scope to get page by author
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int                                   $author_id
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAuthor($query, $author_id)
    {
        return $query->where("author_id", $author_id);
    }

    /**
     * Scope to Get the page by published status
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublished($query)
    {
        return $query->where("status", 'published');
    }

    /**
     * Scope to Get the page by published status
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFeatured($query, $featured = 1)
    {
        return $query->where("featured", $featured);
    }

    /**
     * Scope to Get the page by slug
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string                                $slug
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSlug($query, $slug)
    {
        return $query->whereTranslation("slug", $slug);
    }
}
