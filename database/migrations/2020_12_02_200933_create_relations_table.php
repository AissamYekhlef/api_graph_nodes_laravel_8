<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relations', function (Blueprint $table) {
            
            $table->id();
            $table->integer('node_parent_id');
            $table->integer('node_child_id');

            $table->foreign('node_parent_id')->references('id')->on('nodes')
                                            ->constrained('nodes')->onDelete('cascade');

            $table->foreign('node_child_id')->references('id')->on('nodes')
                                            ->constrained('nodes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('relations');
    }
}
