<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ asset("/bower_components/AdminLTE/dist/img/user2-160x160.jpg") }}" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p>{{Auth::user()->name}}</p>
                <!-- Status -->
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <!-- Optionally, you can add icons to the links -->
            <li class="{{ Request::is('/') ? 'active' : ''}} ">
                <a href="{{ url('/') }}">
                    <span>
                        <i class="fa fa-home"></i> Home
                    </span>
                </a>
            </li>
            <li class="{{ Request::is('/home') ? 'active' : ''}} ">
                <a href="/smtpfindupload">
                    <span>
                        <i class="fa fa-envelope-o"></i> Upload Emails for FINDSMTP(2)
                    </span>
                </a>
            </li>
            <li class="{{ Request::is('settings/email') ? 'active' : ''}} ">
                <a href="{{ url('/settings/email') }}">
                    <span>
                        <i class="fa fa-cog fa-spin"></i> Email Spam(3) Settings
                    </span>
                </a>
            </li>
            <li class="{{ Request::is('settings/smtp') ? 'active' : ''}} ">
                <a href="{{ url('/settings/smtp') }}">
                    <span>
                        <i class="fa fa-cog fa-spin"></i> SMTP Check(8) Settings
                    </span>
                </a>
            </li>
            <li class="{{ Request::is('settings/find') ? 'active' : ''}} ">
                <a href="{{ url('/settings/find') }}">
                    <span>
                        <i class="fa fa-cog fa-spin"></i> SMTP Find(2) Settings
                    </span>
                </a>
            </li>
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>