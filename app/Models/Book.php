<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Book extends Model
{

    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'price',
        'category_id',
        'description',
        'pdf_path',
        'user_id',
        'thumbnails',
    ];

    // Relationships with Category model (assumed you have this)
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

}
