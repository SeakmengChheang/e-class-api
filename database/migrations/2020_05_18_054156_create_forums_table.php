<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateForumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forums', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_content_id')
                ->constrained()
                ->onDelete('cascade');

            $table->foreignId('class_id')
                ->constrained()
                ->onDelete('cascade');

            $table->string('title');
            $table->text('description');
            $table->unsignedBigInteger('author_id');
            $table->unsignedBigInteger('answer_id')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('forums');
    }
}
