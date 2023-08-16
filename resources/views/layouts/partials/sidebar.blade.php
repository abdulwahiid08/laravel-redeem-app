 <!-- Main Sidebar Container -->
 <aside class="main-sidebar sidebar-dark-primary elevation-4">
     <!-- Brand Logo -->
     <a href="index3.html" class="brand-link">
         <img src="{{ asset('assets/img/garuda-logo.png') }}" alt="PT. Garuda Cyber"
             class="brand-image img-circle elevation-2" style="opacity: .8">
         <span class="brand-text font-weight-light">Garuda</span>
     </a>

     <!-- Sidebar -->
     <div class="sidebar">
         <!-- SidebarSearch Form -->
         <div class="form-inline mt-2">
             <div class="input-group" data-widget="sidebar-search">
                 <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                     aria-label="Search">
                 <div class="input-group-append">
                     <button class="btn btn-sidebar">
                         <i class="fas fa-search fa-fw"></i>
                     </button>
                 </div>
             </div>
         </div>
         <!-- Sidebar Menu -->
         <nav class="mt-2">
             <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                 data-accordion="false">
                 <li class="nav-item">
                     <a href="{{ route('dashboard') }}"
                         class="nav-link {{ request()->segment(1) == 'dashboard' ? 'active' : '' }}">
                         <i class="fas fa-fire nav-icon"></i>
                         <p>Dashbord</p>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a href="{{ route('transaksi') }}"
                         class="nav-link {{ request()->segment(1) == 'transaksi' ? 'active' : '' }}">
                         <i class="fas fa-file-invoice nav-icon"></i>
                         <p>Transaksi</p>
                     </a>
                 </li>
             </ul>
         </nav>
         <!-- /.sidebar-menu -->
     </div>
     <!-- /.sidebar -->
 </aside>
