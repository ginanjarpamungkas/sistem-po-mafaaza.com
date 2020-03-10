<aside class="main-sidebar">
<section class="sidebar">
    <div class="user-panel">
    <div class="pull-left image">
        <img src="{{asset('dashboard/dist/img/avatar5.png')}}" class="img-circle" alt="User Image">
    </div>
    <div class="pull-left info">
        <p>{{ auth()->user()->name}}</p>
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
    </div>
    </div>

    <ul class="sidebar-menu tree" data-widget="tree">
    <li><a href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
    <li class="header">Manajemen Barang</li>
    <li class="treeview">
        <a href="#"><i class="fa fa-bullhorn"></i> <span>Purchase Order</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            @if (auth()->user()->can('Create PO'))
                <li><a href="{{route('po.create')}}"><i class="fa fa-edit"></i> Buat Baru</a></li>
            @endif
            <li><a href="{{route('po.show')}}"><i class="fa fa-navicon"></i> Daftar PO</a></li>
        </ul>
    </li>
    @role('Administrator')
    <li class="header">Management User</li>
    <li class="treeview">
        <a href="#"><i class="fa fa-user"></i> <span>User</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
        <li><a href="{{route('user.index')}}"><i class="fa fa-navicon"></i> List</a></li>
        <li><a href="{{route('role.index')}}"><i class="fa fa-black-tie"></i>Role</a></li>
        <li><a href="{{route('user.roles_permission')}}"><i class="fa fa-circle-o"></i>Role Permission</a></li>
        </ul>
    </li>
    @endrole
    </ul>
</section>
</aside>