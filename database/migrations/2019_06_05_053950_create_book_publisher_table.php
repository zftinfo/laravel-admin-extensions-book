<?php

use Jialeo\LaravelSchemaExtend\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookPublisherTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('book.database.table_prefix') . 'book_publisher', function (Blueprint $table) {
            $table->increments('id')->comment('唯一标识');

            $table->unsignedInteger('book_id')->comment('图书ID');
            $table->foreign('book_id')->references('id')->on(config('book.database.table_prefix') . 'book');

            $table->unsignedInteger('publisher_id')->comment('出版社ID');
            $table->foreign('publisher_id')->references('id')->on(config('book.database.table_prefix') . 'publisher');

            $table->timestamp('created_at')->nullable()->comment('创建时间');
            $table->timestamp('updated_at')->nullable()->comment('更新时间');

            $table->comment = '图书出版社关系表';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(config('book.database.table_prefix') . 'book_publisher');
    }
}
