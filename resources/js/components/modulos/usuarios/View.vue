<template>
    <div class="content-header">
      <div class="container-fluid">
        <div class="card">
        <div class="card-header"> 
        <div class="card-tools">
          <router-link class="btn btn-info btn-sm" to="/usuarios/">
            <i class="fas fa-arrow-left"></i>
            Regresar
            </router-link>
        </div>
        </div>
        </div>
      </div><!-- /.container-fluid -->
      
  <div class="content container-fluid"> <!--Creación del perfil-->
    <div class="row">
        <div class="col-md-12">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle" src="/img/konecta.png" alt="User profile picture">
                </div>

                <h3 class="profile-username text-center"><strong>{{fillVerUsuario.cPrimerNombre + ' ' + fillVerUsuario.cSegundoNombre}}</strong></h3>

                <p class="text-muted text-center">{{fillVerUsuario.cApellidos}}</p>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- About Me Box -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title"><strong>Acerca de {{fillVerUsuario.cPrimerNombre}}</strong></h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <strong><i class="fas fa-book mr-1"></i>Educación</strong>

                <p class="text-muted">
                  Bachiller
                </p>

                <hr>

                <strong><i class="fas fa-map-marker-alt mr-1"></i>Sede</strong>

                <p class="text-muted">Puerto Seco - Medellín</p>

                <hr>

                <strong><i class="far fa-file-alt mr-1"></i> Notas</strong>

                <p class="text-muted">El Asesor actualmente se encuentra en operación.</p>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>

        <div class="modal fade" :class="{show: modalShow}" :style=" modalShow ? mostrarModal : ocultarModal">
            <div class="modal-dialog" role="document" style="max-height: 10px">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><strong>ERROR</strong></h5>
                        <button class="close" @click="abrirModal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="callout callout-danger" style="padding: 5px" v-for="(item, index) in mensajeError" :key="index" v-text="item"></div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secundary" @click="abrirModal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>  
  </div>

  
</div>
</template>

<script>
export default {
    data(){
        return{
        fillEditarUsuario: {
            nIdUsuario: this.$attrs.id,
            cPrimerNombre: '',
            cSegundoNombre: '',
            cApellidos: '',
            cUsuario: '',
            cCorreo: '',
            cContrasena: ''
        },
        fillVerUsuario: {
            nIdUsuario: this.$attrs.id,
            cPrimerNombre: '',
            cSegundoNombre: '',
            cApellidos: '',
            cUsuario: '',
            cCorreo: '',
            cContrasena: '',
            cNombreRol: ''
        },
        fullscreenLoading: false,
        form: new FormData,
        modalShow: false,
        mostrarModal: {
            display: 'block',
            background: '#0000006b'
        },
        ocultarModal: {
            display: 'none'
        },
        error: 0,
        mensajeError: []
        }
    },
    mounted(){
      this.getRolByUsuario();
      this.getUsuarioById();
    },
    methods:{
      getRolByUsuario(){
        var url = '/getRolByUsuario'
        axios.get(url, {
          params: {
            'nIdUsuario'  : this.fillEditarUsuario.nIdUsuario
          }
        }).then(response => {
          this.fillVerUsuario.cNombreRol = (response.data.length == 0) ? '' : response.data[0].name;
          this.fullscreenLoading = false;
        })
      },
      getUsuarioById(){
          this.fullscreenLoading = true;
          var url = '/administracion/usuarios/getListarUsuarios';
            axios.get(url, {
            params: {
                'nIdUsuario' : this.fillEditarUsuario.nIdUsuario
            }
            }).then(response => {
                this.getUsuarioVer(response.data[0]);
                this.fullscreenLoading = false;     
        })
      },
     abrirModal(){
        this.modalShow = !this.modalShow;
      },
      getUsuarioVer(data){
        this.fillVerUsuario.cPrimerNombre = data.firstname;
        this.fillVerUsuario.cSegundoNombre = data.secondname;
        this.fillVerUsuario.cApellidos = data.lastname;
        this.fillVerUsuario.cUsuario = data.username;
        this.fillVerUsuario.cCorreo = data.email;
      },
    }
}
</script>

<style>

</style>