<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model{
    protected $table = 'purchase_orders';
    protected $guarded = ['id'];

    public function details(){
        return $this->hasMany(DetailPo::class,'po_id','id');
    }

    public function user(){
        return $this->belongsTo(User::class,'pemesan','id');
    }
}
