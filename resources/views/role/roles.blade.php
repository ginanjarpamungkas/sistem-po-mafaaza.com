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
                <div class="col-md-6">
                    <form action="{{ route('user.set_role', $user->id) }}" method="post">
                        @csrf
                        <input type="hidden" name="_method" value="PUT">
                        <div class="table-responsive">
                            <table class="table table-responsive">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <td>: {{ $user->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td>: <a href="mailto:{{ $user->email }}">{{ $user->email }}</a></td>
                                    </tr>
                                    <tr style="background-color:#2A3F54; color:white">
                                        <th style="text-align:center">Roles</th>
                                        <td>
                                            @foreach ($roles as $row)
                                            <input type="radio" name="role" 
                                                {{ $user->hasRole($row) ? 'checked':'' }}
                                                value="{{ $row }}"> {{  $row }} <br>
                                            @endforeach
                                        </td>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary btn-sm float-right">
                                    Set Role
                                </button>
                            </div>
                    </form>
                </div>
                <div class="col-md-8">
                    
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
