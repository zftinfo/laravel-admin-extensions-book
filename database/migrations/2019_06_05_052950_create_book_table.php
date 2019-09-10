<?php

use Jialeo\LaravelSchemaExtend\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('book.database.table_prefix') . 'book', function (Blueprint $table) {

            $table->increments('id')->comment('唯一标识');
            
            $table->string('name')->comment('名称');
            $table->string('cover')->nullable()->comment('封面');
            $table->decimal('douban_grade',2,1)->nullable()->comment('豆瓣评分');
            $table->string('recommend_desc')->nullable()->comment('推荐语');
            $table->string('status')->default(0)->comment('状态');
            $table->string('is_read')->comment('是否阅读');
            $table->string('is_buy')->comment('是否购买');
            $table->string('isbn')->nullable()->comment('ISBN');
            $table->string('link_dangdang')->nullable()->comment('当当链接');
            $table->string('link_douban')->nullable()->comment('豆瓣链接');
            
            $table->timestamp('created_at')->nullable()->comment('创建时间');
            $table->timestamp('updated_at')->nullable()->comment('更新时间');

            $table->comment = '图书表';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(config('book.database.table_prefix') . 'book');
    }
}
