<template>
  <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"><strong>TIPOLOGÍAS</strong></h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->

  <div class="content container-fluid"> <!--Creación de botón nuevo usuario-->
    <div class="card">
        <div class="card-header"> 
        <div class="card-tools">
          <router-link class="btn btn-info btn-sm" to="/tipologias/crear">
            <i class="fas fa-plus-square"></i>
            Nueva Tipología
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
                    <label class="col-md-5 col-form-label">Nombre</label>
                    <div class="col-md-6">
                      <input type="text" class="form-control" v-model="fillBusqCategoria.cNombre" @keyup.enter="getListarCategorias">
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-md-4 col-form-label">Tipología</label>
                    <div class="col-md-7">
                      <input type="text" class="form-control" v-model="fillBusqCategoria.cDescripcion" @keyup.enter="getListarCategorias">
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
              <button class="btn btn-info btnWidth" @click.prevent="getListarCategorias" v-loading.fullscreen.lock="fullscreenLoading"><strong>Buscar</strong></button>
              <button class="btn btn-default btnWidth" @click.prevent="limpiarCriteriosBsq"><strong>Limpiar</strong></button>
            </div>
          </div>
        </div>
        <div class="card card-info">
          <div class="card-header"><!--Creación de la bandeja de resultado de la búsqueda-->
            <h3 class="card-title"><strong>RESULTADOS DE LA B&Uacute;SQUEDA</strong></h3>
          </div>
          <div class="card-body table-responsive">
            <template v-if="listarCategoriasPaginated.length">
                          <table class="table table-hover table-head-fixed text-nowrap projects"> <!--Creación de la tabla de resultados-->
              <thead>
                <tr>
                  <th>Nombre</th>
                  <th>Descripción</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(item,index) in listarCategoriasPaginated" :key="index">
                  <td v-text="item.name">
                  </td>
                  <td v-text="item.description">
                  </td>
                  <td v-text="item.username">
                  </td>
                  <td>
                    <router-link class="btn btn-primary btn-sm" :to="{name:'tipologias.editar', params:{id: item.id}}">
                      <i class="fas fa-pen"></i>
                      Editar
                    </router-link>
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
      fillBusqCategoria: {
        cNombre: '',
        cDescripcion: ''
      },
      listCategorias: [],
      fullscreenLoading: false,
      pageNumber: 0,
      perPage: 5
    }
  },
  computed:{
    pageCount(){ //Obtener el número de páginas
      let a = this.listCategorias.length,
          b = this.perPage;
      return Math.ceil(a/b);
    },
    listarCategoriasPaginated(){
      let inicio = this.pageNumber * this.perPage,
          fin = inicio + this.perPage;
      return this.listCategorias.slice(inicio, fin);
    },
    pagesList(){
      let a = this.listCategorias.length,
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
    this.fillBusqCategoria.cNombre = '';
    this.fillBusqCategoria.cDescripcion = '';
    },
    limipiarBandejaCategorias(){
      this.listCategorias = [];
    },
    getListarCategorias(){
      this.fullscreenLoading = true;
      var url = 'configuracion/categorias/getListarCategorias';
      axios.get(url, {
        params: {
          'cNombre' : this.fillBusqCategoria.cNombre,
          'cDescripcion' :  this.fillBusqCategoria.cDescripcion
        }
      }).then(response => {
        this.fullscreenLoading = false;
        this.inicializarPaginacion();
        this.listCategorias = response.data;
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
  }
}
</script>

<style>

</style>