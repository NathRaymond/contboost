<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Astrotomic\Translatable\Translatable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

class Tool extends Model implements TranslatableContract
{
    use HasFactory, Translatable;
    /**
     * The columns that are translateable
     *
     * @var array
     */
    public $translatedAttributes = ['name', 'title', 'content',  'description', 'meta_title', 'meta_description', 'og_title', 'og_description', 'og_image'];

    /**
     * The columns that are fillable
     *
     * @var array
     */
    protected $fillable = ['icon', 'slug', 'display', 'status'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['status' => 'boolean'];

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
     * Scope to Get the tool by slug
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string                                $slug
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSlug($query, $slug)
    {
        return $query->where("slug", $slug);
    }
    /**
     * Scope to Get the tool by active
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where("status", true);
    }

}
