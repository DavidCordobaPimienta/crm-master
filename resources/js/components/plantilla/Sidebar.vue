<template>
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="../../index3.html" class="brand-link">
      <img :src="ruta + './img/konecta.png'" alt="Logo Konecta" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light"><strong>CRM</strong></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img :src="ruta + './img/david.jpg'" class="img-circle elevation-2" alt="Imagen Usuario">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{usuario.fullname}}</a>
        </div>
      </div>

      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
          <a href="#" class="d-block" @click.prevent="logout" v-loading.fullscreen.lock="fullscreenLoading">
            <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
          </a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Buscar" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item has-treeview menu-open">
            <router-link :to="'/'" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
              </router-link>
          </li>
          <li class="nav-header"><strong>OPERACIONES</strong></li>
          <li class="nav-item">
            <router-link :to="'/casos'" class="nav-link">
              <i class="nav-icon fas fa-folder-open"></i>
              <p>
                Casos
              </p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link :to="'/cuentas'" class="nav-link">
              <i class="nav-icon fas fa-user-friends"></i>
              <p>
                Cuentas
              </p>
            </router-link>
          </li>
          <li class="nav-header"><strong>CONFIGURACIÓN</strong></li>
          <li class="nav-item">
            <router-link :to="'/tipologias'" class="nav-link">
              <i class="nav-icon fas fa-sitemap"></i>
              <p>Tipologías</p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link :to="'/productos'" class="nav-link">
              <i class="nav-icon fas fa-boxes"></i>
              <p>Productos</p>
            </router-link>
          </li>
          <li class="nav-header"><strong>ADMINISTRACIÓN</strong></li>
          <li class="nav-item">
            <router-link :to="'/usuarios'" class="nav-link">
              <i class="nav-icon fas fa-users-cog"></i>
              <p>Usuarios</p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link :to="'/roles'" class="nav-link">
              <i class="nav-icon fas fa-user-tag"></i>
              <p>
                Roles
              </p>
            </router-link>
              <li class="nav-item">
                <router-link :to="'/permisos'" class="nav-link">
                  <i class="nav-icon fas fa-user-lock"></i>
                  <p>Permisos</p>
                </router-link>
              </li>
          <li class="nav-header"><strong>REPORTES</strong></li>
            <li class="nav-item">
              <router-link :to="'/reportes'" class="nav-link">
              <i class="nav-icon fas fa-file-export"></i>
              <p>Indicadores</p>
              </router-link>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
</template>

<script>
  export default {
    props: ['ruta', 'usuario'],
    data() {
      return {
        fullscreenLoading: false
      }
    },
    methods: {
      logout(){
        this.fullscreenLoading = true;
        var url = '/authenticate/logout';
        axios.post(url).then(response => {
          this.$router.push({name: 'login'});
          location.reload();
          this.fullscreenLoading = false;
        })
      }
    },
}  
</script>

<style>

</style>