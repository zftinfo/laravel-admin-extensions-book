<?php

namespace ZFTInfo\Book\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table = 't_book';

    protected $fillable = [
    	'name', 
    	'cover', 
    	'douban_grade',
    	'recommend_desc',
    	'status',
    	'is_read',
    	'is_buy',
    	'isbn',
    	'link_dangdang',
    	'link_douban',
    ];

    public function authors()
    {
        return $this->belongsToMany(Author::class, 't_book_author')->withPivot('book_id', 'author_id');
    }

    
    public function publishers()
    {
        return $this->belongsToMany(Publisher::class, 't_book_publisher')->withPivot('book_id', 'publisher_id');
    }

}
