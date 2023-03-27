<?php

namespace App\Models\Translations;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ToolTranslation extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = ['name', 'title', 'content',  'description', 'meta_title', 'meta_description', 'og_title', 'og_description', 'og_image'];
}
