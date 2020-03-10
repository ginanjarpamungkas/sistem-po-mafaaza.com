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
    <li class="active">create</li>
    </ol>
</section>
    <section class="content">
      <div class="row">
        <div class="col-md-12">
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title">Daftar Purchase Order</h3>
                </div>
                <div class="box-body">
                    <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="example1" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                                    <thead>
                                        <tr role="row">
                                            <th>No</th>
                                            <th>Nomor PO</th>
                                            <th>Tanggal Pemesanan</th>
                                            <th>Supplier</th>
                                            <th>Pemesan</th>
                                            <th>Status</th>
                                            <th>Dibuat</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="searchResults">
                                    @php
                                        $no = 0;
                                    @endphp
                                    @foreach ($purchaseOrder as $item)    
                                        <tr role="row" class="{{ ++$no%2 ? "odd" : "even" }}">
                                            <td>{{$no}}</td>
                                            <td>{{$item->po_number}}</td>
                                            <td>{{(new DateTime($item->tgl_pemesanan))->format('d M Y, H:i')}}</td>
                                            <td>{{$item->supplier}}</td>
                                            <td>{{$item->user->name}}</td>
                                            <td><label class="label label-xs {{( $item->status == 0) ? 'label-danger' : 'label-success'}}">{{( $item->status == 0) ? 'Belum Dicek' : 'Sudah Dicek'}}</label></td>
                                            <td>{{$item->created_at}}</td>
                                            <td>
                                                @if ($item->status == 0)
                                                    <div class="btn-group">
                                                        @if (auth()->user()->can('Approval PO'))
                                                            <a href="{{route('po.edit',$item->id)}}" class="btn btn-xs btn-primary" data-toggle="tooltip" title="Edit po"><i class="fa fa-edit"></i></a>
                                                        @endif
                                                        <a href="{{route('po.delete',$item->id)}}" onclick="deleteMe(this)" class="btn btn-xs btn-danger" data-toggle="tooltip" title="Delete po"><i class="fa fa-trash"></i></a>
                                                    </div>    
                                                @else
                                                <div class="btn-group">
                                                    <a href="{{route('po.view',$item->id)}}" class="btn btn-xs btn-success" data-toggle="tooltip" title="View"><i class="fa fa-eye"></i></a>
                                                </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Nomor PO</th>
                                            <th>Tanggal Pemesanan</th>
                                            <th>Supplier</th>
                                            <th>Pemesan</th>
                                            <th>Status</th>
                                            <th>Dibuat</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
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
  function deleteMe(e) {
        event.preventDefault();
        var getLink = $(e).attr('href');
        swal({
            title: "Kamu Yakin?",
            text: "Setelah dihapus, data tidak bisa dikembalikan!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            })
            .then((value) => {
                if (value) {
                    window.location.href = getLink;
                }else{
                    return false;
                }
            });
        return false;
    }
</script>
@endsection