<!-- Main Header -->
<header class="main-header">

  <!-- Logo -->
  <a href="/" class="logo">New Era</a>

  <!-- Header Navbar -->
  <nav class="navbar navbar-static-top" role="navigation">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
      <span class="sr-only">Toggle navigation</span>
    </a>
    <!-- Navbar Right Menu -->
    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        <!-- User Account Menu -->
        <li class="user user-menu">
          <!-- Menu Toggle Button -->
          <a href="{{url('/logout')}}">
            <!-- The user image in the navbar-->
            <img src="{{ asset("/bower_components/AdminLTE/dist/img/user2-160x160.jpg") }}" class="user-image" alt="User Image"/>
            <!-- hidden-xs hides the username on small devices so only the image appears. -->
            <span class="hidden-xs"> Выход({{Auth::user()->name}})</span>
          </a>
        </li>
      </ul>
    </div>
  </nav>
</header>