<!-- sidebar: style can be found in sidebar.less -->
<section class="sidebar">
  <!-- Sidebar user panel -->
  <div class="user-panel">
    <div class="pull-left image">
      <img src="{{ asset('backend/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
    </div>
    <div class="pull-left info">
      <p>Sameer Nyaupane</p>
      <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
    </div>
  </div>
  <!-- search form -->
  <form action="#" method="get" class="sidebar-form">
    <div class="input-group">
      <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
            <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
            </button>
          </span>
    </div>
  </form>
  <!-- /.search form -->
  <!-- sidebar menu: : style can be found in sidebar.less -->
  <ul class="sidebar-menu">
    <li class="header">MAIN NAVIGATION</li>
    <li class="active treeview">
      <a href="#">
        <i class="fa fa-dashboard"></i> <span>Setup</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        <li class="active"><a href="{{ route('plans.index') }}"><i class="fa fa-circle-o"></i> Plans</a></li>
        <li ><a href="#"><i class="fa fa-circle-o"></i> Domains</a></li>
      </ul>
    </li>
    <li class="treeview">
      <a href="#">
        <i class="fa fa-users"></i> <span>Users</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        <li class="active"><a href="{{ route('users.index') }}"><i class="fa fa-circle-o"></i> All Users</a></li>
        <li><a href="#"><i class="fa fa-circle-o"></i> Customers</a></li>
        <li ><a href="#"><i class="fa fa-circle-o"></i> Staffs</a></li>
      </ul>
    </li>
    <li class="treeview">
      <a href="#">
        <i class="fa fa-shopping-cart"></i> <span>Orders</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        <li class="active"><a href=#><i class="fa fa-circle-o"></i> All Orders</a></li>
        <li ><a href="#"><i class="fa fa-circle-o"></i> Pending</a></li>
        <li ><a href="#"><i class="fa fa-circle-o"></i> Active</a></li>
        <li ><a href="#"><i class="fa fa-circle-o"></i> Cancelled</a></li>
      </ul>
    </li>
    <li class="treeview">
      <a href="#">
        <i class="fa fa-credit-card"></i> <span>Billing</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        <li class="active"><a href=#><i class="fa fa-circle-o"></i> All Invoices</a></li>
        <li ><a href="#"><i class="fa fa-circle-o"></i> Unpaid</a></li>
        <li ><a href="#"><i class="fa fa-circle-o"></i> Paid</a></li>
        <li ><a href="#"><i class="fa fa-circle-o"></i> Overdue</a></li>
        <li ><a href="#"><i class="fa fa-circle-o"></i> Refunded</a></li>
        <li ><a href="#"><i class="fa fa-circle-o"></i> Cancelled</a></li>
      </ul>
    </li>
  </ul>
</section>
<!-- /.sidebar -->