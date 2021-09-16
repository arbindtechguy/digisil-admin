<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppsGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('apps_group', function (Blueprint $table) {
            $table->id();
            $table->integer('rank')->nullable();
            $table->text('group')->nullable();
            $table->unsignedBigInteger('category_id');
            $table->index('category_id');
            $table->foreign('category_id')->references('id')->on('apps_category')->onUpdate('cascade') ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('apps_group');
    }
}
