<template>
<div>
  <!-- Navbar -->  
    <Navbar :ruta="ruta"></Navbar>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
    <Sidebar :ruta="ruta" :usuario="authUser"></Sidebar>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
      <transition name="slide-fade" mode="out-in">
        <router-view></router-view>
      </transition>
  </div>
  <!-- /.content-wrapper -->

  <!-- Footer -->
    <Footer></Footer>
  <!-- /.footer -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
    </div>
</template>

<script>
    import Navbar from './plantilla/Navbar'
    import Sidebar from './plantilla/Sidebar.vue'
    import Content from './plantilla/Content.vue'
    import Footer from './plantilla/Footer.vue'
    export default {
        props: ['ruta', 'usuario'],
        components: {Navbar, Sidebar, Content, Footer},
        data() {
          return {
            authUser: this.usuario
          }
        },
        mounted() {
          EventBus.$on('verifyAuthenticatedUser', data =>{
            this.authUser = data;
          })
        },
    }
</script>

<style>

</style>