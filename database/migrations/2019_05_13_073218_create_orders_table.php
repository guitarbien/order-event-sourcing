<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->string('id', 36)->comment('order uuid');
            $table->string('contact_name')->comment('收件人姓名');
            $table->string('contact_address')->comment('收件人地址');
            $table->string('contact_mobile', 10)->comment('收件人手機');
            $table->integer('price')->comment('訂單金額');
            $table->boolean('picked')->default(false)->comment('已揀貨');
            $table->timestamp('picked_at')->nullable()->comment('揀貨時間');
            $table->boolean('prepared')->default(false)->comment('已理貨');
            $table->timestamp('prepared_at')->nullable()->comment('理貨時間');
            $table->boolean('delivered')->default(false)->comment('已出貨');
            $table->timestamp('delivered_at')->nullable()->comment('出貨時間');
            $table->boolean('arrived')->default(false)->comment('已配達');
            $table->timestamp('arrived_at')->nullable()->comment('配達時間');
            $table->timestamps();

            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
