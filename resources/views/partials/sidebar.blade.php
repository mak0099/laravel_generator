<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <!-- <img src="{{asset('public/asset/img/logo.png')}}" class="img-circle img-responsive" alt="User Image"> -->
        </div>
        
        <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <li class="{!! Request::is('dashboard') ? 'active' : '' !!}">
                <a href="{{route('index')}}">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>
            <li class="{!! Request::is('crud-generator/*') ? 'active' : '' !!}">
                <a href="{{route('crud_index')}}">
                    <i class="fa fa-circle-o"></i> <span>CRUD Generator</span>
                </a>
            </li>
            <li class="{!! Request::is('moderator/*') ? 'active' : '' !!}">
                <a href="{{route('Moderator.index')}}">
                    <i class="fa fa-circle-o"></i> <span>Moderator</span>
                </a>
            </li>

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>