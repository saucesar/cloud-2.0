<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImageTemplatesTable extends Migration
{
    public function up()
    {
        Schema::create('image_templates', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('image_id')->foreign('image_id')->references('id')->on('images');
            $table->json('template');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('image_templates');
    }
}
