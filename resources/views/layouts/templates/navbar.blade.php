<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="/" class="nav-link">Home</a>
    </li>
    @if(Route::currentRouteName() == 'interfaces.index' || Route::currentRouteName() == 'hardwareinterfaces.index')
    <li class="nav-item d-none d-sm-inline-block">
      <a href="{{route('interfaces.create')}}" class="nav-link">Anlegen</a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="{{route('hardwareinterfaces.index')}}" class="nav-link">Hardware Schnittstellen</a>
    </li>
    @elseif(Route::currentRouteName() == 'definitions.index')
    <li class="nav-item d-none d-sm-inline-block">
      <a href="{{route('definitions.create')}}" class="nav-link">Definition anlegen</a>
    </li>
    @elseif(Route::currentRouteName() == 'firewallrules.index')
    <li class="nav-item d-none d-sm-inline-block">
      <a href="{{route('firewallrules.create')}}" class="nav-link">Regel anlegen</a>
    </li>
    @elseif(Route::currentRouteName() == 'nats.index')
    <li class="nav-item d-none d-sm-inline-block">
      <a href="{{route('nats.create')}}" class="nav-link">NAT anlegen</a>
    </li>
    @elseif(Route::currentRouteName() == 'dhcp.index')
    <li class="nav-item d-none d-sm-inline-block">
     <a href="{{route('dhcp.create')}}" class="nav-link">DHCP anlegen</a>
    </li>
    @elseif(Route::currentRouteName() == 'routes.index')
    <li class="nav-item d-none d-sm-inline-block">
      <a href="{{route('routes.create')}}" class="nav-link">Route anlegen</a>
    </li>
    @elseif(Route::currentRouteName() == 'dashboard.index' || url()->current() == url('/').'/packets' || url()->current() == url('/'))
    <li class="nav-item d-none d-sm-inline-block">
      <a href="{{url('/').'/packets'}}" class="nav-link">Abgelehnte Pakete</a>
    </li>
    @endif
  </ul>
</nav>
<!-- /.navbar -->
