<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

Schema::defaultStringLength(191);
class CreateClassesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        if (!Schema::hasTable('classes')) {
            Schema::create('classes', function (Blueprint $table) {
                $table->increments('class_id')->comment('id');
                $table->integer('major_id')->nullable()->unsigned()->comment('id ngành');
                $table->integer('major_branch_id')->unsigned()->comment('id chuyên ngành');
                $table->string('class_code', 12)->comment('mã lớp');
                $table->string('class_name')->comment('tên lớp');
                // Lấy từ bên bảng class_user qua. Tham khảo ý kiến của cô Tuyền.
                $table->date('class_begin')->comment('ngày bất đầu của một lớp');
                $table->date('class_end')->comment('ngày kết thúc của một lớp');

                // log time
                $table->timestamp('created_at')
                    ->default(DB::raw('CURRENT_TIMESTAMP'))
                    ->comment('ngày tạo');

                $table->timestamp('updated_at')
                    ->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'))
                    ->comment('ngày cập nhật');

                $table->timestamp('deleted_at')
                    ->nullable()
                    ->comment('ngày xóa tạm');
                // Setting unique
                $table->unique(['class_code', 'class_name']);
            });
            DB::statement("ALTER TABLE `classes` comment 'Thông tin lớp'");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
    }
}