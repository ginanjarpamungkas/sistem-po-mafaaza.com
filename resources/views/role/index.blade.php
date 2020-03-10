@extends('layouts.dashboard')
@section('content')
    <section class="content-header">
        <h1>
        Role
        <small>{{config('app.name')}}</small>
        </h1>
        <ol class="breadcrumb">
        <li><a href="{{route('user.index')}}"><i class="fa fa-user"></i>User</a></li>
        <li class="active">Role</li>
        </ol>
    </section>
    <section class="content container-fluid">
        <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title">Daftar Periode</h3>

                <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                <div class="col-md-4">
                    <form role="form" action="{{ route('role.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Tambah</label>
                            <input type="text" 
                            name="name"
                            class="form-control {{ $errors->has('name') ? 'is-invalid':'' }}" id="name" required>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
                <div class="col-md-8">
                  <strong>List Role</strong>
                  <div class="table-responsive">
                      <table class="table table-hover">
                          <thead>
                              <tr>
                                  <td>#</td>
                                  <td>Role</td>
                                  <td>Guard</td>
                                  <td>Created At</td>
                                  <td>Action</td>
                              </tr>
                          </thead>
                          <tbody>
                              @php $no = 1; @endphp
                              @forelse ($role as $row)
                              <tr>
                                  <td>{{ $no++ }}</td>
                                  <td>{{ $row->name }}</td>
                                  <td>{{ $row->guard_name }}</td>
                                  <td>{{ $row->created_at }}</td>
                                  <td>
                                    @if ($row->name != 'Administrator')      
                                    <form action="{{ route('role.destroy', $row->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button class="btn btn-danger btn-sm deleteRole"><i class="fa fa-trash"></i></button>
                                    </form>
                                    @endif
                                  </td>
                              </tr>
                              @empty
                              <tr>
                                  <td colspan="5" class="text-center">Tidak ada data</td>
                              </tr>
                              @endforelse
                          </tbody>
                      </table>
                  </div>
                  <div class="pull-right">
                      {!! $role->links() !!}
                  </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@section('footer')
{{-- hapus data artikel --}}
<script>
    jQuery(document).ready(function($){
        $('.deleteRole').on('click',function(){
            var getLink = $(this).attr('href');
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this imaginary file!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                })
                .then((value) => {
                    if (value) {
                        $(this).closest('form').submit();
                    }else{
                        return false;
                    }
                });
            return false;
        });
    });
</script>      
@endsection