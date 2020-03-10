<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PurchaseOrder;
use App\DetailPo;
use Auth;
use Carbon\Carbon;

class PurchaseOrderController extends Controller{
    public function index(){
        $purchaseOrder = PurchaseOrder::orderBy('created_at','desc')->get();
        return view('PurchaseOrder.show',compact('purchaseOrder'));
    }

    public function create(){
        return view('PurchaseOrder.create');
    }

    public function store(Request $request){
        // dd($request->all());
        $this->validate($request,[
            'tgl_pemesanan' =>  'required',
            'supplier'      =>  'required|max:191',
            'gudang'        =>  'required|max:191'
        ],[
            'tgl_pemesanan.required' => 'Tanggal pemesanan harus diisi.',
            'supplier.required' => 'Supplier harus diisi.',
            'supplier.max' => 'Tidak boleh lebih dari 190 karakter.',
            'gudang.required' => 'Kolom harus diisi.',
            'gudang.max' => 'Tidak boleh lebih dari 190 karakter.'
        ]);
        $time = time();
        $purchaseOrder = PurchaseOrder::create([
            'po_number'     =>  "PO".date('Ymd')."-".auth()->user()->id."/".$time,
            'tgl_pemesanan' =>  $request->tgl_pemesanan,
            'supplier'      =>  $request->supplier,
            'pemesan'       =>  auth()->user()->id,
            'gudang'        =>  $request->gudang,
            'keterangan'    =>  $request->keterangan,
            'status'        =>  0,
            'jumlah_total_harga'=>  $request->subtotal,
        ]);

        $no = 0;
        foreach ($request->nama_barang as $key) {
            if ($request->nama_barang[$no] != null) {
                $detail = DetailPo:: create([
                    'po_id'       =>  $purchaseOrder->id,
                    'nama_barang'  =>  $request->nama_barang[$no],
                    'jumlah_barang'  =>  $request->jumlah_barang[$no],
                    'satuan_barang'  =>  $request->satuan_barang[$no],
                    'harga_barang'  =>  $request->harga_barang[$no],
                    'total_harga_barang'  =>  $request->total_harga_barang[$no],
                    'status'        =>  0,
                ]);
                $no++;
            }
        }
        return back()->with('success','PO berhasil ditambah');
    }

    public function show($id){
        $purchaseOrder = PurchaseOrder::where('id',$id)->orderBy('created_at','desc')->first();
        return view('PurchaseOrder.view',compact('purchaseOrder'));
    }

    public function edit($id){
        $purchaseOrder = PurchaseOrder::where('id',$id)->orderBy('created_at','desc')->first();
        return view('PurchaseOrder.edit',compact('purchaseOrder'));
    }

    public function ceked($id){
        $purchaseOrder = PurchaseOrder::find($id);

        $purchaseOrder->update([
            'status' =>  1,
        ]);

        return redirect()->route('po.show')->with('success','Data berhasil disimpan');
    }

    public function update(Request $request, $id){
        $purchaseOrder = PurchaseOrder::where('id',$id)->orderBy('created_at','desc')->first();
        return view('PurchaseOrder.update',compact('purchaseOrder'));
    }

    public function updateDetail(Request $request, $id){
        $detail = DetailPo::find($id);

        $detail->update([
            'status' =>  $request->status,
        ]);

        return 'success';
    }

    public function destroy($id){
        $purchaseOrder = PurchaseOrder::find($id);
        $purchaseOrder->delete();
        $detail = DetailPo::where('po_id',$id)->delete();
        return back()->with('success','Data berhasil dihapus!');
    }
}
