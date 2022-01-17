<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQueuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->getTable(), function (Blueprint $table) {
            $table->id();

            $table->integer('timeout');
            $table->integer('processes');
            $table->integer('tries');
            $table->string('queue')->default('default');
            $table->integer('site_id');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->getTable());
    }


    private function getTable()
    {
        return (new \App\Models\Queue())->getTable();
    }
}
