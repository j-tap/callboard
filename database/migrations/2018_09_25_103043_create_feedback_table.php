<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeedbackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feedback', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('owner_id')->nullable()->unsigned()->index();
            $table->integer('moder_id')->nullable()->unsigned()->index();
            $table->boolean('report')->default(0)->index();
            $table->integer('news_id')->nullable()->index();
            $table->integer('deal_id')->nullable()->index();
            $table->integer('org_id')->nullable()->index();
            $table->integer('message_id')->nullable()->index();
            $table->string('theme');
            $table->text('description');
            $table->enum('status', ['opened', 'progress', 'closed'])->default('opened')->index();
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
        Schema::dropIfExists('feedback');
    }
}
