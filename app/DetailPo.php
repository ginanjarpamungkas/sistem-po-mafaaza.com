<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailPo extends Model{
    protected $table = 'po_details';
    protected $guarded = ['id'];

    public function po(){
        return $this->belongsTo(PurchaseOrder::class,'id','po_id');
    }
}
