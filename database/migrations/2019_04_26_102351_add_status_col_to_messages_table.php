<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Message;



class AddStatusColToMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->enum('status', [Message::MESSAGE_STATUS_READED ,
                                    Message::MESSAGE_STATUS_UNREADED])->after('message')->default(Message::MESSAGE_STATUS_UNREADED)->nullable()->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('messages', function (Blueprint $table) {
            Schema::dropIfExists('status');
        });
    }
}
