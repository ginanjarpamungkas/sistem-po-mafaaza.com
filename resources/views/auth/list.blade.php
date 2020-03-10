@extends('layouts.dashboard')
@section('content')
    <section class="content-header">
        <h1>
        User
        <small>{{config('app.name')}}</small>
        </h1>
        <ol class="breadcrumb">
        <li><a href="{{route('user.index')}}"><i class="fa fa-user"></i> User</a></li>
        <li class="active">List</li>
        </ol>
    </section>
    <section class="content container-fluid">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-danger">
                    <div class="box-header with-border">
                        <h3 class="box-title">Daftar User {{config('app.name')}}</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                    <a style="margin-bottom:10px" class="btn btn-primary" data-toggle="modal" href='#modal-id'><i class="fa fa-plus"></i> Tambah User</a>
                        <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table id="example1" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                                    <thead>
                                    <tr role="row">
                                        <th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" style="width: 182px;">Nama</th>
                                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 224px;">Email</th>
                                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" style="width: 112px;">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($user as $user)    
                                    <tr role="row" class="odd">
                                    <td data-id="{{$user->id}}" class="sorting_1">{{$user->name}}</td>
                                    <td data-id="{{$user->id}}">{{$user->email}}</td>
                                    <td data-id="{{$user->id}}">
                                    @if ($user->name != 'Administrator')
                                    <a href="{{ route('user.roles', $user->id) }}" class="btn btn-info btn-xs"><i class="fa fa-user-secret"></i></a>
                                        <button class="delete btn btn-xs btn-danger" data-id="{{$user->id}}"><i class="fa fa-trash"></i></button>
                                    @endif
                                    </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th rowspan="1" colspan="1">Nama</th>
                                        <th rowspan="1" colspan="1">Email</th>
                                        <th rowspan="1" colspan="1">Action</th>
                                    </tr>
                                    </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>
    </section>
</div>

<div class="modal fade" id="modal-id">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="register-logo">
                {{config('app.name')}}
            </div>
            <div class="register-box-body">
                <p class="login-box-msg">Register a new User</p>
            
                <form action="{{ route('user.store') }}" method="post">
                    @csrf
                    <div class="form-group has-feedback">
                    <input placeholder="Full Name" id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required>
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    @if ($errors->has('name'))
                        <span class="invalid-feedback" role="alert" style="color:red">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                    </div>
                    <div class="form-group has-feedback">
                        <select name="role" id="role" class="form-control{{ $errors->has('role') ? ' is-invalid' : '' }}" required>
                            <option value="">Pilih Role</option>
                            @foreach ($role as $item)
                            <option value="{{$item->name}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                        <span class="glyphicon glyphicon-chevron-down form-control-feedback"></span>
                        @if ($errors->has('role'))
                            <span class="invalid-feedback" role="alert" style="color:red">
                                <strong>{{ $errors->first('role') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group has-feedback">
                    <input placeholder="Email" id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert" style="color:red">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                    </div>
                    <div class="form-group has-feedback">
                    <input placeholder="Password (minimum 6 character)" id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    @if ($errors->has('password'))
                        <span class="invalid-feedback" role="alert" style="color:red">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                    </div>
                    <div class="form-group has-feedback">
                    <input placeholder="Retype Password" id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                    <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                    </div>
                    <div class="row">
                        <button type="submit" class="btn btn-primary btn-block btn-flat col-xs-12">Register</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>    
@endsection
@section('footer')
<script>
$(".delete").click(function(){
    var $tr = $(this).closest('tr');
    var id = $(this).data("id");
    swal({
            title: "Are you sure?",
            text: "You will not be able to recover this imaginary file!",
            type: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((isConfirm)=>{
        if (isConfirm) {
            $.ajax(
            {
                url: "/deleteUser/"+id,
                type: 'DELETE',
                data: {
                    "id": id,
                    "_token": "{{ csrf_token() }}",
                },
                success: function (response){
                    $tr.find('td').fadeOut(1000,function(){ 
                    $tr.remove();                    
                    }); 
                }
            });
            swal("Poof! Your imaginary file has been deleted!", {
                icon: "success",
            });
        } 
        }) 
});
</script>

<script type="text/javascript">
    $('.btnEdit').click(function(){
    
      var id = $(this).attr('id-detail');
    
      $.ajax({
        url: "/users/edit/"+id,
        dataType:'json',
        method:'POST',
        data:{id2:id,"_token": "{{ csrf_token() }}"},
      }).success(function(data) {
        
        $('#id').val(data.id);
        $('#judul').val(data.judul);
        $('#periode').val(data.periode);
        $('#topik').val(data.topik);
        $('#status').val(data.status);
        $('#keterangan').val(data.keterangan);
      });
    });
</script>
    
@endsection