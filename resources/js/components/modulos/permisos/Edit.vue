<template>
  <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"><strong>EDITAR PERMISO</strong></h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->

  <div class="content container-fluid"> <!--Creación de botón regresar-->
    <div class="card">
        <div class="card-header"> 
        <div class="card-tools">
          <router-link class="btn btn-info btn-sm" to="/permisos">
            <i class="fas fa-arrow-left"></i>
            Regresar
            </router-link>
        </div>
        </div>
        <div class="card-body"> <!--Creación de formulario de registro-->
        <div class="containter">
          <div class="row">
            <div class="col-md-5">
              
            </div>
          </div>
          <div class="card card-info">
            <div class="card-header">
              <h3 class="card-title"><strong>ACTUALIZAR PERMISO</strong></h3>
            </div>
            <div class="card-body">
              <form role="form">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-md-4 col-form-label">Nombre del Permiso</label>
                    <div class="col-md-7">
                      <input type="text" class="form-control" v-model="fillEditarPermiso.cNombre" @:keyup.enter="setEditarPermiso">
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-md-3 col-form-label">URL Amigable</label>
                    <div class="col-md-8">
                      <input type="text" class="form-control" v-model="fillEditarPermiso.cUrl" @:keyup.enter="setEditarPermiso">
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
              <button class="btn btn-info btnWidth" @click.prevent="setEditarPermiso" ><strong>Actualizar</strong></button>
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
      fillEditarPermiso: {
        nIdPermiso: this.$attrs.id,
        cNombre: '',
        cUrl: ''
      },
      fullscreenLoading: false,
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
      this.getListarPermisos();
  },
  methods:{
      limpiarCriteriosBsq(){
        this.fillEditarPermiso.cNombre = '';
        this.fillEditarPermiso.cUrl = '';   
      },
      abrirModal(){
          this.modalShow = !this.modalShow;
      },
      getListarPermisos(){
      this.fullscreenLoading = true;
      var url = '/administracion/permisos/getListarPermisos';
      axios.get(url, {
        params: {
          'nIdPermiso' : this.fillEditarPermiso.nIdPermiso
        }
      }).then(response => {
        this.fillEditarPermiso.cNombre = response.data[0].name;
        this.fillEditarPermiso.cUrl = response.data[0].slug;
        this.fullscreenLoading = false;
      })
      },
      setEditarPermiso(){
          if (this.validarEditarPermisos()) {
              this.modalShow = true;
              return;              
          }

          this.fullscreenLoading = true;
          var url = '/setEditarPermiso';
          
          axios.post(url, {
                'nIdPermiso' :  this.fillEditarPermiso.nIdPermiso,
                'cNombre' :     this.fillEditarPermiso.cNombre,
                'cUrl' :        this.fillEditarPermiso.cUrl
          }).then(response => {
              this.fullscreenLoading = false;
              Swal.fire({
              icon: 'success',
              title: '¡El permiso ha sido actualizado correctamente!',
              showConfirmButton: false,
              timer: 1700
            })
            this.$router.push('/permisos');
          })
      },
      validarEditarPermisos(){
          this.error = 0;
          this.mensajeError = [];

          if(!this.fillEditarPermiso.cNombre){
              this.mensajeError.push("El Nombre es un campo obligatorio.")
          }
          if(!this.fillEditarPermiso.cUrl){
              this.mensajeError.push("La URL es un campo obligatorio.")
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