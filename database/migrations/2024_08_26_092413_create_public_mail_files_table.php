<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePublicMailimagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('public_mail_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('public_mail_id')->constrained('public_mail')->onUpdate('cascade')->onDelete('cascade');
            $table->text('image_path');
            $table->bigInteger('image_size');
            $table->string('image_type');
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('public_mail_images');
    }
}
