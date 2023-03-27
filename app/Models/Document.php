<?php

namespace App\Models;

use App\Models\Usecase;
use App\Models\DocumentRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nicolaslopezj\Searchable\SearchableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Document extends Model
{
    use HasFactory;
    use SoftDeletes;
    use SearchableTrait;


    /**
     * The columns that are fillable
     *
     * @var array
     */
    protected $fillable = ['id', 'user_id', 'name'];

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
            'documents.name' => 5,
            'document_requests.result' => 5,
        ],
        'joins' => [
            'document_requests' => ['documents.id', 'document_requests.document_id'],
        ],
        'groupBy' => [
            'documents.id'
        ]
    ];



    public function usecase()
    {
        return $this->belongsTo(Usecase::class, 'usecase_id');
    }

    public function requests()
    {
        return $this->hasMany(DocumentRequest::class, 'document_id');
    }
}
