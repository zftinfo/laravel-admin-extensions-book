<?php

use Jialeo\LaravelSchemaExtend\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuthorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('book.database.table_prefix') . 'author', function (Blueprint $table) {
            $table->increments('id')->comment('唯一标识');
            $table->string('name')->unique()->comment('中文名称');
            $table->string('name_en')->nullable()->comment('英文名称');
            $table->string('country')->nullable()->comment('国籍');
            $table->timestamp('created_at')->nullable()->comment('创建时间');
            $table->timestamp('updated_at')->nullable()->comment('更新时间');

            $table->comment = '图书作者表';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(config('book.database.table_prefix') . 'author');
    }
}
