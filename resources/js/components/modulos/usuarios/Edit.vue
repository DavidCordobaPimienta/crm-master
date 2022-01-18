<template>
  <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"><strong>EDITAR USUARIO</strong></h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->

  <div class="content container-fluid"> <!--Creación de botón nuevo usuario-->
    <div class="card">
        <div class="card-header"> 
        <div class="card-tools">
          <router-link class="btn btn-info btn-sm" to="/usuarios">
            <i class="fas fa-arrow-left"></i>
            Regresar
            </router-link>
        </div>
        </div>
        <div class="card-body"> <!--Creación de formulario criterios de edición-->
        <div class="containter">
          <div class="card card-info">
            <div class="card-header">
              <h3 class="card-title"><strong>ACTUALIZAR USUARIO</strong></h3>
            </div>
            <div class="card-body">
              <form role="form">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-md-5 col-form-label">Primer Nombre</label>
                    <div class="col-md-5">
                      <input type="text" class="form-control" v-model="fillEditarUsuario.cPrimerNombre">
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-md-5 col-form-label">Segundo Nombre</label>
                    <div class="col-md-5">
                      <input type="text" class="form-control" v-model="fillEditarUsuario.cSegundoNombre">
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-md-5 col-form-label">Apellidos</label>
                    <div class="col-md-5">
                      <input type="text" class="form-control" v-model="fillEditarUsuario.cApellidos">
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-md-5 col-form-label">Usuario de Red</label>
                    <div class="col-md-5">
                      <input type="text" class="form-control" v-model="fillEditarUsuario.cUsuario">
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-md-5 col-form-label">Correo Electrónico</label>
                    <div class="col-md-5">
                      <input type="email" class="form-control" v-model="fillEditarUsuario.cCorreo">
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-md-5 col-form-label">Contraseña</label>
                    <div class="col-md-5">
                    <el-input v-model="fillEditarUsuario.cContrasena" @keyup.enter="setEditarUsuarios" show-password></el-input>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-md-5 col-form-label">Rol</label>
                    <div class="col-md-5">
                       <el-select v-model="fillEditarUsuario.nIdRol" placeholder="Seleccione un Rol" cleareable>
                          <el-option
                            v-for="item in listRoles"
                            :key="item.id"
                            :label="item.name"
                            :value="item.id">
                          </el-option>
                        </el-select>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>

        <div class="card-footer"> <!--Creación de boton registrar y limpiar-->
          <div class="row">
            <div class="col-md-4 offset-4">
              <button class="btn btn-info btnWidth" @click.prevent="setEditarUsuarios" v-loading.fullscreen.lock="fullscreenLoading"><strong>Actualizar</strong></button>
              <button class="btn btn-default btnWidth" @click.prevent="limpiarCriteriosBsq"><strong>Limpiar</strong></button>
            </div>
          </div>
        </div>

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
        cContrasena: '',
        nIdRol: ''
      },
      listRoles: [],
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
      this.getListarRoles();
  },
  methods:{
      getListarRoles(){
      this.fullscreenLoading = true;
      var url = '/getListarRoles';
      axios.get(url).then(response => {
        this.fullscreenLoading = false;
        this.listRoles = response.data;
        this.getRolByUsuario();
      })
      },
      getRolByUsuario(){
        var url = '/getRolByUsuario';
        axios.get(url, {
          params:{
            'nIdUsuario': this.fillEditarUsuario.nIdUsuario
          }
        }).then(response => {
        this.fullscreenLoading = false;
        this.fillEditarUsuario.nIdRol = (response.data.length == 0) ? '' : response.data[0].nIdRol;
        //this.listRoles = response.data;
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
          this.fillEditarUsuario.cPrimerNombre = response.data[0].firstname;
          this.fillEditarUsuario.cSegundoNombre = response.data[0].secondname;
          this.fillEditarUsuario.cApellidos = response.data[0].lastname;
          this.fillEditarUsuario.cUsuario = response.data[0].username;
          this.fillEditarUsuario.cCorreo = response.data[0].email;
          this.fillEditarUsuario.cContrasena = response.data[0].password;
          this.fullscreenLoading = false;     
        })
      },
      setEditarRolByUsuario(){
        var url = '/setEditarRolByUsuario';
        axios.post(url, {
                'nIdUsuario' : this.fillEditarUsuario.nIdUsuario,
                'nIdRol' : this.fillEditarUsuario.nIdRol
          }).then(response => {
            this.fullscreenLoading = false;
              Swal.fire({
              icon: 'success',
              title: '¡El usuario ha sido actualizado correctamente!',
              showConfirmButton: false,
              timer: 1700
            });
             this.$router.push('/usuarios');
          })
      },
      limpiarCriteriosBsq(){
        this.fillEditarUsuario.cPrimerNombre = '';
        this.fillEditarUsuario.cSegundoNombre = '';
        this.fillEditarUsuario.cApellidos = '';
        this.fillEditarUsuario.cUsuario = '';
        this.fillEditarUsuario.cCorreo = '';
        this.fillEditarUsuario.cContrasena = '';    
    },
      abrirModal(){
          this.modalShow = !this.modalShow;
      },
      setEditarUsuarios(){
          if (this.validarRegistrarUsuario()) {
              this.modalShow = true;
              return;              
          }
          this.setGuardarUsuario();
          this.fullscreenLoading = true;
      },
      setGuardarUsuario(){
          var url = '/setEditarUsuarios';
          axios.post(url, {
                'nIdUsuario'        : this.fillEditarUsuario.nIdUsuario,
                'cPrimerNombre'     : this.fillEditarUsuario.cPrimerNombre,
                'cSegundoNombre'    : this.fillEditarUsuario.cSegundoNombre,
                'cApellidos'        : this.fillEditarUsuario.cApellidos,
                'cUsuario'          : this.fillEditarUsuario.cUsuario,
                'cCorreo'           : this.fillEditarUsuario.cCorreo,
                'cContrasena'       : this.fillEditarUsuario.cContrasena
          }).then(response => {
            this.setEditarRolByUsuario();
          })
      },
      validarRegistrarUsuario(){
          this.error = 0;
          this.mensajeError = [];

          if(!this.fillEditarUsuario.cPrimerNombre){
              this.mensajeError.push("El Primer Nombre es un campo obligatorio.")
          }
          if(!this.fillEditarUsuario.cApellidos){
              this.mensajeError.push("Los Apellidos son un campo obligatorio.")
          }
          if(!this.fillEditarUsuario.cUsuario){
              this.mensajeError.push("El Usuario de Red es un campo obligatorio.")
          }
          if(!this.fillEditarUsuario.cCorreo){
              this.mensajeError.push("El Correo Electrónico es un campo obligatorio.")
          }
          if(this.mensajeError.length){
              this.error = 1;
          }
          return this.error;
      }
  }
}
</script>

<style>

</style>