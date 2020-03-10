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
                    <form action="{{ route('user.add_permission') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="">Add New Permission</label>
                            <input type="text" name="name" class="form-control {{ $errors->has('name') ? 'is-invalid':'' }}" required>
                            <p class="text-danger">{{ $errors->first('name') }}</p>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary btn-sm">
                                Add New
                            </button>
                        </div>
                    </form>
                </div>
                <div class="col-md-8">
                    <form action="{{ route('user.roles_permission') }}" method="GET">
                        <div class="form-group">
                            <label for="">Roles</label>
                            <div class="input-group">
                                <select name="role" class="form-control">
                                    @foreach ($roles as $value)
                                        <option value="{{ $value }}" {{ request()->get('role') == $value ? 'selected':'' }}>{{ $value }}</option>
                                    @endforeach
                                </select>
                                <span class="input-group-btn">
                                    <button class="btn btn-danger">Check!</button>
                                </span>
                            </div>
                        </div>
                    </form>
    
                    @if (!empty($permissions))
                        <form action="{{ route('user.setRolePermission', request()->get('role')) }}" method="post">
                            @csrf
                            <input type="hidden" name="_method" value="PUT">
                            <div class="form-group">
                                <div class="nav-tabs-custom">
                                    <ul class="nav nav-tabs">
                                        <li class="active">
                                            <a href="#tab_1" data-toggle="tab">Permissions</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab_1">
                                            @php $no = 1; @endphp
                                            @foreach ($permissions as $key => $row)
                                                <input type="checkbox" 
                                                    name="permission[]" 
                                                    class="minimal-red" 
                                                    value="{{ $row }}"
                                                    {{--  CHECK, JIKA PERMISSION TERSEBUT SUDAH DI SET, MAKA CHECKED --}}
                                                    {{ in_array($row, $hasPermission) ? 'checked':'' }}
                                                    > {{ $row }} <br>
                                                @if ($no++%4 == 0)
                                                <br>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="pull-right">
                                <button class="btn btn-primary btn-sm">
                                    <i class="fa fa-send"></i> Set Permission
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
