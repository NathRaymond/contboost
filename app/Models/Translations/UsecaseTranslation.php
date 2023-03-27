<?php

namespace App\Models\Translations;


use Illuminate\Database\Eloquent\Model;

class UsecaseTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = ['name', 'usecase_id', 'description'];
}
