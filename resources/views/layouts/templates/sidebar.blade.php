<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="#" class="brand-link">
    <img src="{{asset('images/logo.png')}}" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">KangooRouter</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="info">
        <a class="d-block">{{Auth::user()->name}}</a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

        <li class="nav-item">
          <a href="{{route('dashboard.index')}}" class="nav-link">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Dashboard
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{route('definitions.index')}}" class="nav-link">
            <i class="nav-icon fas fa-desktop"></i>
            <p>
              Definitionen
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{route('interfaces.index')}}" class="nav-link">
            <i class="nav-icon fas fa-network-wired"></i>
            <p>
              Schnittstellen
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{route('firewallrules.index')}}" class="nav-link">
            <i class="nav-icon fas fa-fire"></i>
            <p>
              Firewall
            </p>
          </a>
        </li>
        <!--
        <li class="nav-item">
          <a href="{{route('nats.index')}}" class="nav-link">
            <i class="nav-icon fas fa-map-signs"></i>
            <p>
              NAT
            </p>
          </a>
        </li>
      -->
        <li class="nav-item">
          <a href="{{route('routes.index')}}" class="nav-link">
            <i class="nav-icon fas fa-route"></i>
            <p>
              Routing
            </p>
          </a>
        </li>
        <!--
        <li class="nav-item">
          <a href="{{route('dhcp.index')}}" class="nav-link">
            <i class="nav-icon fas fa-list-alt"></i>
            <p>
              DHCP
            </p>
          </a>
        </li>
      -->
        <li class="nav-item">
          <a href="/logout" class="nav-link">
            <i class="nav-icon fas fa-sign-out-alt"></i>
            <p>
              Abmelden
            </p>
          </a>
        </li>

      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>
