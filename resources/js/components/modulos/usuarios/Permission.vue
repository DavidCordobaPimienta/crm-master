<template>
  <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"><strong>PERMISOS</strong></h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->

  <div class="content container-fluid"> <!--Creación de botón regresar-->
    <div class="card">
        <div class="card-header"> 
        <div class="card-tools">
          <router-link class="btn btn-info btn-sm" to="/roles">
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
              <h3 class="card-title"><strong>PERMISOS DEL USUARIO</strong></h3>
            </div>
            <div class="card-body table-responsive">
            <template v-if="listPermisosByRolAsignado.length">
            <table class="table table-hover table-head-fixed text-nowrap projects"> <!--Creación de la tabla de resultados-->
              <thead>
                <tr>
                  <th>Nombre</th>
                  <th>URL Amigable</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(item,index) in listPermisosByRolAsignado" :key="index">
                  <td v-text="item.name">
                  </td>
                  <td v-text="item.slug">
                  </td>
                </tr>
              </tbody>
            </table>
            </template>
            <template v-else>
              <div class="callout callout-info">
                <h5>Lo sentimos: No se encontraron resultados para los criterios especificados o no ha ejecutado la búsqueda.</h5>
              </div>
            </template>
          </div>
          </div>
        </div>
        <div class="card-footer"> <!--Creación de boton registrar y limpiar-->
          <div class="row">
            <div class="col-md-4 offset-4">
              <button class="btn btn-info btnWidth" @click.prevent="setRegistrarRolPermisos" ><strong>Registrar</strong></button>
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
</template>


<script>
export default {
  data(){
    return{
      fillPermiso: {
        nIdUsuario: this.$attrs.id
      },
      listPermisosByRolAsignado: [],
      fullscreenLoading: false,
      listPermisos: [],
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
  computed:{
  
  },
  mounted(){
    this.getListarPermisosByRolAsignado();
    this.getListarPermisosByRol();
  },
  methods:{
      getListarPermisosByRolAsignado(){
        var ruta = '/getListarPermisosByRolAsignado';
        axios.get(ruta, {
            params: {
                'nIdUsuario' :  this.fillPermiso.nIdUsuario
            }
        }).then( response => {
          this.listPermisosByRolAsignado = response.data;
        }) 
      },
      filterPermisosByRol(){
        let me = this;
        me.listPermisos.map(function(x,y){
          me.listPermisosByRolAsignado.push({
            'id': x.id,
            'name': x.name,
            'slug': x.slug,
            'checked': false
          })
        })
      },
      getListarPermisosByRol(){ 
        var ruta = '/administracion/roles/getListarPermisosByRol';
        axios.get(ruta).then( response => {
          this.listPermisos = response.data;
          this.filterPermisosByRol();
        }) 
      },
      /*limpiarCriteriosBsq(){
        this.fillPermiso.cNombre = '';
        this.fillPermiso.cUrl = '';   
    },*/
      abrirModal(){
          this.modalShow = !this.modalShow;
      },
      setRegistrarRolPermisos(){
          if (this.validarRegistrarRolPermisos()) {
              this.modalShow = true;
              return;              
          }

          this.fullscreenLoading = true;
    
          var url = '/setRegistrarRolPermisos';
          axios.post(url, {
                'cNombre' : this.fillPermiso.cNombre,
                'cUrl' : this.fillPermiso.cUrl,
                'listPermisosByRolAsignado': this.listPermisosByRolAsignado

          }).then(response => {
              this.fullscreenLoading = false;
              Swal.fire({
              icon: 'success',
              title: '¡El rol ha sido creado correctamente!',
              showConfirmButton: false,
              timer: 1700
            })
            this.$router.push('/roles');
          })
      },
      validarRegistrarRolPermisos(){
          this.error = 0;
          this.mensajeError = [];

          if(!this.fillPermiso.cNombre){
              this.mensajeError.push("El Nombre es un campo obligatorio.")
          }
          if(!this.fillPermiso.cUrl){
              this.mensajeError.push("La URL es un campo obligatorio.")
          }

          let contador = 0;
          this.listPermisosByRolAsignado.map(function(x,y){
            if (x.checked == true) {
              contador++;              
            }
          })
          if (contador == 0) {
            this.mensajeError.push("Debe de seleccionar por lo menos un permiso para este rol.")            
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