<?php

use Jialeo\LaravelSchemaExtend\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePublisherTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('book.database.table_prefix') . 'publisher', function (Blueprint $table) {
            $table->increments('id')->comment('唯一标识');
            $table->string('name')->unique()->comment('名称');
            $table->string('cover')->nullable()->comment('logo');
            $table->string('desc')->nullable()->comment('备注');

            $table->timestamp('created_at')->nullable()->comment('创建时间');
            $table->timestamp('updated_at')->nullable()->comment('更新时间');

            $table->comment = '图书出版社表';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(config('book.database.table_prefix') . 'publisher');
    }
}
