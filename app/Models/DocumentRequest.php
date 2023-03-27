<?php

namespace App\Models;

use App\Models\Usecase;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DocumentRequest extends Model
{
    use HasFactory;


    /**
     * The columns that are fillable
     *
     * @var array
     */
    protected $fillable = ['id', 'document_id', 'result', 'no_of_words', 'tokens'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    public function document()
    {
        return $this->belongsTo(Document::class, 'document_id');
    }
}
