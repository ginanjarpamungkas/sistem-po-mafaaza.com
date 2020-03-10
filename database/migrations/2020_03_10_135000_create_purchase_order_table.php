<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseOrderTable extends Migration{
    public function up(){
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('po_number');
            $table->datetime('tgl_pemesanan');
            $table->string('supplier');
            $table->integer('pemesan');
            $table->string('gudang');
            $table->text('keterangan')->nullable();
            $table->boolean('status');
            $table->integer('jumlah_total_harga');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('purchase_orders');
    }
}
