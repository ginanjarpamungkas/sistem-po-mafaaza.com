@extends('layouts.dashboard')
@section('header')
@endsection
@section('content')
    <section class="content-header">
        <h1>
        Purchase Order
        <small>{{config('app.name')}}</small>
        </h1>
        <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-bullhord"></i> Purchase Order</a></li>
        <li class="active">view</li>
        </ol>
    </section>
    <section class="content container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="box box-danger">
                    <div class="box-header with-border">
                        <h3 class="box-title">Purchase Order</h3>
                    </div>
                    <div class="box-body">                                      
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Nomor PO <span class="required">*</span></label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="po_number" value="{{$purchaseOrder->po_number}}" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Tanggal Pemesanan <span class="required">*</span></label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-btn"><a class="btn btn-default" aria-hidden="true" disabled><i class="fa fa-calendar-o"></i></a></span>
                                        <input type="text" class="form-control" id="tgl_pemesanan" name="tgl_pemesanan" value="{{$purchaseOrder->tgl_pemesanan}}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Supplier <span class="required">*</span></label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="supplier" name="supplier" readonly value="{{$purchaseOrder->supplier}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Pemesanan Untuk <span class="required">*</span></label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="gudang" name="gudang" readonly value="{{$purchaseOrder->gudang}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Pemesan <span class="required">*</span></label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="pemesan" name="pemesan" value="{{$purchaseOrder->user->name}}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Keterangan</label>
                                <textarea name="keterangan" id="keterangan" class="form-control" cols="30" rows="8" readonly>{{$purchaseOrder->keterangan}}</textarea>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <table id="example1" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                                <thead>
                                    <tr role="row">
                                        <th>No</th>
                                        <th>Nama Barang</th>
                                        <th>Jumlah Barang</th>
                                        <th>Harga Satuan</th>
                                        <th>Total Harga</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody id="searchResults">
                                @php
                                    $no = 0;
                                @endphp
                                @foreach ($purchaseOrder->details as $item)    
                                    <tr role="row" class="{{ ++$no%2 ? "odd" : "even" }}">
                                        <td>{{$no}}</td>
                                        <td>{{$item->nama_barang}}</td>
                                        <td>{{$item->jumlah_barang}}</td>
                                        <td>{{$item->harga_barang}}</td>
                                        <td>{{$item->total_harga_barang}}</td>
                                        <td id="status{{$item->id}}"><label class="label label-xs {{( $item->status == 0) ? 'label-danger' : 'label-success'}}">{{( $item->status == 0) ? 'Tidak Disetujui' : 'Disetujui'}}</label></td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Barang</th>
                                        <th>Jumlah Barang</th>
                                        <th>Harga Satuan</th>
                                        <th>Total Harga</th>
                                        <th>Status</th>
                                    </tr>
                                </tfoot>
                            </table>
                            <div class="form-group">
                                <label>Sub Total Harga</label>
                                <input type="number" class="form-control" id="subtotal" name="subtotal" value="0" readonly>
                            </div>
                            <a href="{{route('po.show')}}" class="col-xs-12 btn btn-success">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@section('footer')
<script>
    $(document).ready(function() {
        $('body').attr('class','skin-red sidebar-mini sidebar-collapse')
    })
    $(function() {
      $('input[id="tgl_pemesanan"]').daterangepicker({
        singleDatePicker: true,
        timePicker: false,
        timePicker24Hour: true,
        timePickerSeconds: false,
        drops: "down",
        locale: {
          format: 'DD-MM-YYYY'
        }
      });
    });
    function updateDetail(e) {
        var link = $(e).data('href')
        var value = $(e).data('value')
        var id = $(e).data('id')
        $.ajax({
            url: link,
            type: 'POST',
            data: {
                "_token": "{{ csrf_token() }}",
                "status": value,
            },
            success: function (response){
                if ( value == 1 ){
                    $('#status'+id).html('<label class="label label-xs label-success">Setuju</label>')
                }else{
                    $('#status'+id).html('<label class="label label-xs label-danger">Tidak Setuju</label>')
                }
            }
        });
    }

</script>
@endsection