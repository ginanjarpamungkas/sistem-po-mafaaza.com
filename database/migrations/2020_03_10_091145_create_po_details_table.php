<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePoDetailsTable extends Migration{
    public function up(){
        Schema::create('po_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('po_id');
            $table->string('nama_barang');
            $table->string('jumlah_barang');
            $table->string('satuan_barang');
            $table->integer('harga_barang');
            $table->integer('total_harga_barang');
            $table->boolean('status');
            $table->timestamps();
        });
    }

    public function down(){
        Schema::dropIfExists('po_details');
    }
}
