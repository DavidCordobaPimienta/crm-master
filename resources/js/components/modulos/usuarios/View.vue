<template>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"><strong>USUARIOS</strong></h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->

  <div class="content container-fluid"> <!--Creación del perfil-->
    <div class="row">
        <div class="col-md-12">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle" src="/img/user4-128x128.jpg" alt="User profile picture">
                </div>

                <h3 class="profile-username text-center">Nina Mcintire</h3>

                <p class="text-muted text-center">Software Engineer</p>

                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Followers</b> <a class="float-right">1,322</a>
                  </li>
                  <li class="list-group-item">
                    <b>Following</b> <a class="float-right">543</a>
                  </li>
                  <li class="list-group-item">
                    <b>Friends</b> <a class="float-right">13,287</a>
                  </li>
                </ul>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- About Me Box -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">About Me</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <strong><i class="fas fa-book mr-1"></i> Education</strong>

                <p class="text-muted">
                  B.S. in Computer Science from the University of Tennessee at Knoxville
                </p>

                <hr>

                <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>

                <p class="text-muted">Malibu, California</p>

                <hr>

                <strong><i class="fas fa-pencil-alt mr-1"></i> Skills</strong>

                <p class="text-muted">
                  <span class="tag tag-danger">UI Design</span>
                  <span class="tag tag-success">Coding</span>
                  <span class="tag tag-info">Javascript</span>
                  <span class="tag tag-warning">PHP</span>
                  <span class="tag tag-primary">Node.js</span>
                </p>

                <hr>

                <strong><i class="far fa-file-alt mr-1"></i> Notes</strong>

                <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p>
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
        this.getUsuarioById();
    },
    methods:{
      getUsuarioById(){
          this.fullscreenLoading = true;
          var url = '/administracion/usuarios/getListarUsuarios';
            axios.get(url, {
            params: {
                'nIdUsuario' : this.fillEditarUsuario.nIdUsuario
            }
            }).then(response => {
                this.fillEditarUsuario.cPrimerNombre = response.data[0].firstname;
                this.fillEditarUsuario.cSegundoNombre = response.data[0].secondname;
                this.fillEditarUsuario.cApellidos = response.data[0].lastname;
                this.fillEditarUsuario.cUsuario = response.data[0].username;
                this.fillEditarUsuario.cCorreo = response.data[0].email;
                this.fillEditarUsuario.cContrasena = response.data[0].password;
                this.fullscreenLoading = false;     
        })
      },
     abrirModal(){
        this.modalShow = !this.modalShow;
      },
      getUsuarioVer(data){

      }
    }
}
</script>

<style>

</style>