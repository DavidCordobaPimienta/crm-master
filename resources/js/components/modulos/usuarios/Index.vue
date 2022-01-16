<template>
  <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"><strong>USUARIOS</strong></h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->

  <div class="content container-fluid"> <!--Creación de botón nuevo usuario-->
    <div class="card">
        <div class="card-header"> 
        <div class="card-tools">
          <router-link class="btn btn-info btn-sm" to="/usuarios/crear">
            <i class="fas fa-plus-square"></i>
            Nuevo Usuario
            </router-link>
        </div>
        </div>
        <div class="card-body"> <!--Creación de formulario criterios de búsqueda-->
        <div class="containter">
          <div class="card card-info">
            <div class="card-header">
              <h3 class="card-title"><strong>CRITERIOS DE B&Uacute;SQUEDA</strong></h3>
            </div>
            <div class="card-body">
              <form role="form">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-md-3 col-form-label">Nombre</label>
                    <div class="col-md-5">
                      <input type="text" class="form-control" v-model="fillBusqUsuario.cNombre" @keyup.enter="getListarUsuarios">
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-md-3 col-form-label">Usuario de Red</label>
                    <div class="col-md-5">
                      <input type="text" class="form-control" v-model="fillBusqUsuario.cUsuario" @keyup.enter="getListarUsuarios">
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-md-3 col-form-label">Correo Electr&oacute;nico</label>
                    <div class="col-md-5">
                      <input type="email" class="form-control" v-model="fillBusqUsuario.cCorreo" @keyup.enter="getListarUsuarios">
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-md-3 col-form-label">Estado</label>
                    <div class="col-md-5">
                       <el-select v-model="fillBusqUsuario.cEstado" placeholder="Seleccione un estado" cleareable>
                          <el-option
                            v-for="item in listEstados"
                            :key="item.value"
                            :label="item.label"
                            :value="item.value">
                          </el-option>
                        </el-select>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>

        <div class="card-footer"> <!--Creación de boton buscar y limpiar-->
          <div class="row">
            <div class="col-md-4 offset-4">
              <button class="btn btn-info btnWidth" @click.prevent="getListarUsuarios" v-loading.fullscreen.lock="fullscreenLoading"><strong>Buscar</strong></button>
              <button class="btn btn-default btnWidth" @click.prevent="limpiarCriteriosBsq"><strong>Limpiar</strong></button>
            </div>
          </div>
        </div>
        <div class="card card-info">
          <div class="card-header"><!--Creación de la bandeja de resultado de la búsqueda-->
            <h3 class="card-title"><strong>RESULTADOS DE LA B&Uacute;SQUEDA</strong></h3>
          </div>
          <div class="card-body table-responsive">
            <template v-if="listarUsuariosPaginated.length">
                          <table class="table table-hover table-head-fixed text-nowrap projects"> <!--Creación de la tabla de resultados-->
              <thead>
                <tr>
                  <th>Nombre Completo</th>
                  <th>Correo Electr&oacute;nico</th>
                  <th>Usuario de Red</th>
                  <th>Estado</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(item,index) in listarUsuariosPaginated" :key="index">
                  <td v-text="item.fullname">
                  </td>
                  <td v-text="item.email">
                  </td>
                  <td v-text="item.username">
                  </td>
                  <td>
                    <template v-if="item.state=='A'">
                      <span class="badge badge-success" v-text="item.state_alias"></span>
                    </template>
                    <template v-else>
                      <span class="badge badge-danger" v-text="item.state_alias"></span>
                    </template>                   
                  </td>
                  <td>
                    <template v-if="item.state=='A'">
                    <router-link class="btn btn-primary btn-sm" :to="'/'">
                      <i class="fas fa-folder"></i>
                      Ver
                    </router-link>
                    <router-link class="btn btn-primary btn-sm" :to="{name:'usuarios.editar', params:{id: item.id}}">
                      <i class="fas fa-pen"></i>
                      Editar
                    </router-link>
                    <router-link class="btn btn-primary btn-sm" :to="'/'">
                      <i class="fas fa-key"></i>
                      Permiso
                    </router-link>
                    <button class="btn btn-primary btn-sm" @click.prevent="setCambiarEstadoUsuario(1, item.id)">
                      <i class="fas fa-trash"></i>
                      Desactivar
                    </button>
                    </template>
                    <template v-if="item.state=='I'">
                    <button class="btn btn-primary btn-sm" @click.prevent="setCambiarEstadoUsuario(2, item.id)">
                      <i class="fas fa-check"></i>
                      Activar
                    </button>
                    </template>
                  </td>
                </tr>
              </tbody>
            </table>

            <div class="card-footer"><!--Paginación-->
            <ul class="pagination pagination-sm m-0 float-right">
              <li class="page-item" v-if="pageNumber > 0">
                <a href="#" class="page-link" @click.prevent="prevPage"><strong>Ant</strong></a>
              </li>
              <li class="page-item" v-for="(page, index) in pagesList" :key="index" :class="[page == pageNumber ? 'active' : '']">
                <a href="#" class="page-link" @click.prevent="selectPage(page)">{{page+1}}</a>
              </li>
              <li class="page-item" v-if="pageNumber < pageCount - 1">
                <a href="#" class="page-link" @click.prevent="nextPage"><strong>Sig</strong></a>
              </li>
            </ul>
            </div>

            </template>
            <template v-else>
              <div class="callout callout-info">
                <h5>Lo sentimos: No se encontraron resultados para los criterios especificados o no ha ejecutado la búsqueda.</h5>
              </div>

            </template>
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
      fillBusqUsuario: {
        cNombre: '',
        cUsuario: '',
        cCorreo: '',
        cEstado: ''
      },
      listUsuarios: [],
      listEstados: [
        {value: 'A', label: 'Activo'},
        {value: 'I', label: 'Inactivo'}
      ],
      fullscreenLoading: false,
      pageNumber: 0,
      perPage: 5
    }
  },
  computed:{
    pageCount(){ //Obtener el número de páginas
      let a = this.listUsuarios.length,
          b = this.perPage;
      return Math.ceil(a/b);
    },
    listarUsuariosPaginated(){
      let inicio = this.pageNumber * this.perPage,
          fin = inicio + this.perPage;
      return this.listUsuarios.slice(inicio, fin);
    },
    pagesList(){
      let a = this.listUsuarios.length,
          b = this.perPage;
      let pageCount = Math.ceil(a/b);
      let count = 0,
          pagesArray = [];
      
      while (count < pageCount) {
        pagesArray.push(count);
        count++;        
      }
      
      return pagesArray;
    }   
  },
  methods:{
    limpiarCriteriosBsq(){
    this.fillBusqUsuario.cNombre = '';
    this.fillBusqUsuario.cUsuario = '';
    this.fillBusqUsuario.cCorreo = '';
    this.fillBusqUsuario.cEstado = '';
    },
    limipiarBandejaUsuarios(){
      this.listUsuarios = [];
    },
    getListarUsuarios(){
      this.fullscreenLoading = true;
      var url = 'administracion/usuarios/getListarUsuarios';
      axios.get(url, {
        params: {
          'cNombre' : this.fillBusqUsuario.cNombre,
          'cUsuario' :  this.fillBusqUsuario.cUsuario,
          'cCorreo' :  this.fillBusqUsuario.cCorreo,
          'cEstado' :  this.fillBusqUsuario.cEstado,
        }
      }).then(response => {
        this.inicializarPaginacion();
        this.listUsuarios = response.data;
      })
    },
    nextPage(){
      this.pageNumber++;
    },
    prevPage(){
      this.pageNumber--;
    },
    selectPage(page){
      this.pageNumber = page;
    },
    inicializarPaginacion(){
      this.fullscreenLoading = false;
      this.pageNumber = 0;
    },
    setCambiarEstadoUsuario(op, id){
      Swal.fire({
        title: '¿Está completamente seguro de' + ((op == 1) ? ' desactivar' : ' activar') + ' el usuario?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: ((op == 1) ? 'Sí, desactivar' : 'Sí, activar')
      }).then((result) => {
          if (result.isConfirmed) {
            this.fullscreenLoading = true;
            var url = '/setCambiarEstadoUsuario';
            axios.post(url, {
              'nIdUsuario' : id,
              'cEstado'    : (op == 1) ? 'I' : 'A'
            }).then(response =>{
              Swal.fire({
              icon: 'success',
              title: '¡Se' + ((op == 1) ? ' desactivó ' : ' activó ') + 'el usuario correctamente!',
              showConfirmButton: false,
              timer: 1700
            })
            this.getListarUsuarios;
            this.fullscreenLoading = false;
            })
          }
      })
    }
  }
}
</script>

<style>

</style>