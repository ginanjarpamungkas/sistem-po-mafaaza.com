@extends('layouts.dashboard')
@section('header')
<style>
    /* my daterangepicker custom css */
    .calendar.left.single {width: 100%;}
    .ranges{text-align: center;float: none !important;}
    /* table style */
    #dg{width:100%; border: 1px solid #95B8E7}
    #dg .row-number, thead{background:#F4F4F4; text-align:center}
    #dg td, th{border: 1px dotted #ccc;}
    .input-table{border:none;width: 100%; height: 25px;}
    .input-table:focus{outline: none}
    .footer-table, th {background:#F4F4F4; text-align:center; height: 31px}
    .data-table{overflow:scroll; height: 500px}
    .header-table{text-align: center; background:#95B8E7; padding:10px 0}
    .is-invalid{border: 1px solid red !important;}
    .nav-sm ul.nav.chart{width: fit-content;height: fit-content;left: 0;top: 100%;border: 1px solid #fff}
    select{font-family: fontAwesome}
    tbody tr:hover {background-color: #fff !important;}
    tbody tr td label{display: block;cursor: text}
</style>
@endsection
@section('content')
    <section class="content-header">
        <h1>
        Purchase Order
        <small>{{config('app.name')}}</small>
        </h1>
        <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-bullhord"></i> Purchase Order</a></li>
        <li class="active">create</li>
        </ol>
    </section>
    <section class="content container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="box box-danger">
                    <div class="box-header with-border">
                        <h3 class="box-title">Persetujuan Purchase Order</h3>
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
                                        <th>Action</th>
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
                                        <td id="status{{$item->id}}"><label class="label label-xs {{( $item->status == 0) ? 'label-danger' : 'label-success'}}">{{( $item->status == 0) ? 'Tidak Setuju' : 'Setuju'}}</label></td>
                                        <td>
                                            <div class="btn-group">
                                                <a data-href="{{route('po.detail.action',$item->id)}}" data-id="{{$item->id}}" data-value="1" class="btn btn-xs btn-success" data-toggle="tooltip" title="Setuju" onclick="updateDetail(this)"><i class="fa fa-thumbs-o-up"></i></a>
                                                <a data-href="{{route('po.detail.action',$item->id)}}" data-id="{{$item->id}}" data-value="0" class="btn btn-xs btn-danger" data-toggle="tooltip" title="Tidak Setuju" onclick="updateDetail(this)"><i class="fa fa-thumbs-o-down"></i></a>
                                            </div>
                                        </td>
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
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                            <div class="form-group">
                                <label>Sub Total Harga</label>
                                <input type="number" class="form-control" id="subtotal" name="subtotal" value="0" readonly>
                            </div>
                            <a href="{{route('po.ceked',$purchaseOrder->id)}}" class="col-xs-12 btn btn-success">Save</a>
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