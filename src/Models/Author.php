<?php

namespace ZFTInfo\Book\Models;

//use App\Models\Country;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $table = 't_author';


    protected $fillable = [
        'name', # 国家
        'name_en', # 货币单位
        'country', # 企业ID
    ];
    
    // public function country()
    // {
    //     return $this->belongsTo(Country::class);
    // }

    public function books()
    {
        return $this->belongsToMany(Book::class, 't_book_author', 'author_id', 'book_id');
    }
}
