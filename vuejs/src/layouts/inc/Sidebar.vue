<template>
  <aside id="left-panel" class="left-panel">
    <nav class="navbar navbar-expand-sm navbar-default">
      <div id="main-menu" class="main-menu collapse navbar-collapse">
        <ul class="nav navbar-nav">
          <li>
            <router-link to="/admin">
              <i class="menu-icon fa fa-laptop"></i>Dashboard
            </router-link>
          </li>
          <li class="menu-title">UI elements</li>
          <!-- /.menu-title -->

          <li class="menu-item-has-children active dropdown">
            <a
              href="#"
              class="dropdown-toggle"
              data-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false"
            >
              <i class="menu-icon fa fa-table"></i>Tables</a
            >
            <ul class="sub-menu children dropdown-menu">
              <li>
                <i class="fa fa-table"></i>
                <router-link to="/admin/category"> Danh mục </router-link>
              </li>
              <li>
                <i class="fa fa-table"></i>
                <router-link to="/admin/genre"> Thể loại </router-link>
              </li>
              <li>
                <i class="fa fa-table"></i>
                <router-link to="/admin/product"> Kho Sách </router-link>
              </li>
            </ul>
          </li>
          <li class="menu-item-has-children dropdown">
            <a
              href="#"
              class="dropdown-toggle"
              data-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false"
            >
              <i class="menu-icon fa fa-tasks"></i>Manage</a
            >
            <ul class="sub-menu children dropdown-menu">
              <li>
                <i class="fa fa-table"></i>
                <router-link to="/admin/borrow"> Quản lý mượn trả </router-link>
              </li>
              <li>
                <i class="fa fa-table"></i>
                <router-link to="/admin/student"> Sinh viên </router-link>
              </li>
              <li>
                <i class="fa fa-table"></i>
                <router-link to="/admin/staff"> Nhân viên </router-link>
              </li>
            </ul>
          </li>
        </ul>
      </div>
      <!-- /.navbar-collapse -->
    </nav>
  </aside>
  <!-- /#left-panel -->
</template>

<script>
export default {
  name: "SideBar",
};
</script>

<style>
</style>