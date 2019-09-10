<?php

namespace ZFTInfo\Book\Models;

use DB;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Publisher extends Model
{
    protected $table = 't_publisher';

    protected $fillable = ['name', 'cover', 'desc'];

    public function getCoverUrlAttribute()
    {
        // 如果 image 字段本身就已经是完整的 url 就直接返回
        if (Str::startsWith($this->attributes['cover'], ['http://', 'https://'])) {
            return $this->attributes['cover'];
        }
        return env('APP_URL') . ($this->attributes['cover']);
    }

    public static function getSelectOptions()
    {
        $options = DB::table('t_publisher')->select('id','name as text')->get();
        $selectOption = [];
        foreach ($options as $option){
            $selectOption[$option->id] = $option->text;
        }
        return $selectOption;
    }

    public function books()
    {
        return $this->belongsToMany(Book::class, 't_book_publish', 'publish_id', 'book_id');
    }
}
