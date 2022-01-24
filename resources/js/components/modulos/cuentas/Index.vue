<template>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><strong>CUENTAS</strong></h1>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->

        <div class="content container-fluid">
            <!--Creación de botón nuevo usuario-->
            <div class="card">
                <div class="card-header">
                    <div class="card-tools">
                        <router-link
                            class="btn btn-info btn-sm"
                            to="/cuentas/crear"
                        >
                            <i class="fas fa-plus-square"></i>
                            Nueva Cuenta
                        </router-link>
                    </div>
                </div>
                <div class="card-body">
                    <!--Creación de formulario criterios de búsqueda-->
                    <div class="containter">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <strong
                                        >CRITERIOS DE B&Uacute;SQUEDA</strong
                                    >
                                </h3>
                            </div>
                            <div class="card-body">
                                <form role="form">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label
                                                    class="col-md-4 col-form-label"
                                                    >Nombre</label
                                                >
                                                <div class="col-md-7">
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        v-model="
                                                            fillBusqCliente.cNombre
                                                        "
                                                        @keyup.enter="
                                                            getListarClientes
                                                        "
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label
                                                    class="col-md-4 col-form-label"
                                                    >No. Documento</label
                                                >
                                                <div class="col-md-7">
                                                    <input
                                                        type="number"
                                                        class="form-control"
                                                        v-model="
                                                            fillBusqCliente.cDocumento
                                                        "
                                                        @keyup.enter="
                                                            getListarClientes
                                                        "
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="card-footer">
                            <!--Creación de boton buscar y limpiar-->
                            <div class="row">
                                <div class="col-md-4 offset-4">
                                    <button
                                        class="btn btn-info btnWidth"
                                        @click.prevent="getListarClientes"
                                        v-loading.fullscreen.lock="
                                            fullscreenLoading
                                        "
                                    >
                                        <strong>Buscar</strong>
                                    </button>
                                    <button
                                        class="btn btn-default btnWidth"
                                        @click.prevent="limpiarCriteriosBsq"
                                    >
                                        <strong>Limpiar</strong>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card card-info">
                            <div class="card-header">
                                <!--Creación de la bandeja de resultado de la búsqueda-->
                                <h3 class="card-title">
                                    <strong
                                        >RESULTADOS DE LA
                                        B&Uacute;SQUEDA</strong
                                    >
                                </h3>
                            </div>
                            <div class="card-body table-responsive">
                                <template
                                    v-if="listarClientesPaginated.length"
                                >
                                    <table
                                        class="table table-hover table-head-fixed text-nowrap projects"
                                    >
                                        <!--Creación de la tabla de resultados-->
                                        <thead>
                                            <tr>
                                                <th>Nombre</th>
                                                <th>Documento</th>
                                                <th>Correo</th>
                                                <th>Teléfono</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr
                                                v-for="(
                                                    item, index
                                                ) in listarClientesPaginated"
                                                :key="index"
                                            >
                                                <td 
                                                    v-text="item.fullname">
                                                </td>
                                                <td
                                                    v-text="item.document"
                                                ></td>
                                                <td
                                                    v-text="item.email"
                                                ></td>
                                                <td
                                                    v-text="item.phone"
                                                ></td>
                                                <td>
                                                    <router-link class="btn btn-primary btn-sm" :to="{name:'cuentas.editar', params:{id: item.id}}">
                                                        <i class="fas fa-pen"></i>
                                                        Editar
                                                    </router-link>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <div class="card-footer">
                                        <!--Paginación-->
                                        <ul
                                            class="pagination pagination-sm m-0 float-right"
                                        >
                                            <li
                                                class="page-item"
                                                v-if="pageNumber > 0"
                                            >
                                                <a
                                                    href="#"
                                                    class="page-link"
                                                    @click.prevent="prevPage"
                                                    ><strong>Ant</strong></a
                                                >
                                            </li>
                                            <li
                                                class="page-item"
                                                v-for="(
                                                    page, index
                                                ) in pagesList"
                                                :key="index"
                                                :class="[
                                                    page == pageNumber
                                                        ? 'active'
                                                        : '',
                                                ]"
                                            >
                                                <a
                                                    href="#"
                                                    class="page-link"
                                                    @click.prevent="
                                                        selectPage(page)
                                                    "
                                                    >{{ page + 1 }}</a
                                                >
                                            </li>
                                            <li
                                                class="page-item"
                                                v-if="
                                                    pageNumber < pageCount - 1
                                                "
                                            >
                                                <a
                                                    href="#"
                                                    class="page-link"
                                                    @click.prevent="nextPage"
                                                    ><strong>Sig</strong></a
                                                >
                                            </li>
                                        </ul>
                                    </div>
                                </template>
                                <template v-else>
                                    <div class="callout callout-info">
                                        <h5>
                                            Lo sentimos: No se encontraron
                                            resultados para los criterios
                                            especificados o no ha ejecutado la
                                            búsqueda.
                                        </h5>
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
    data() {
        return {
            fillBusqCliente: {
                cNombre: '',
                cDocumento: '',
            },
            listClientes: [],
            fullscreenLoading: false,
            pageNumber: 0,
            perPage: 5,
        };
    },
    computed: {
        pageCount() {
            //Obtener el número de páginas
            let a = this.listClientes.length,
                b = this.perPage;
            return Math.ceil(a / b);
        },
        listarClientesPaginated() {
            let inicio = this.pageNumber * this.perPage,
                fin = inicio + this.perPage;
            return this.listClientes.slice(inicio, fin);
        },
        pagesList() {
            let a = this.listClientes.length,
                b = this.perPage;
            let pageCount = Math.ceil(a / b);
            let count = 0,
                pagesArray = [];

            while (count < pageCount) {
                pagesArray.push(count);
                count++;
            }

            return pagesArray;
        },
    },
    mounted() {
    },
    methods: {
        limpiarCriteriosBsq() {
            this.fillBusqCliente.cNombre = "";
            this.fillBusqCliente.cDocumento = "";
        },
        getListarClientes() {
            this.fullscreenLoading = true;
            var url = "/getListarClientes";
            axios
                .get(url, {
                    params: {
                        'cNombre': this.fillBusqCliente.cNombre,
                        'cDocumento': this.fillBusqCliente.cDocumento,
                    },
                })
                .then((response) => {
                    this.fullscreenLoading = false;
                    this.inicializarPaginacion();
                    this.listClientes = response.data;
                });
        },
        nextPage() {
            this.pageNumber++;
        },
        prevPage() {
            this.pageNumber--;
        },
        selectPage(page) {
            this.pageNumber = page;
        },
        inicializarPaginacion() {
            this.fullscreenLoading = false;
            this.pageNumber = 0;
        },
    },
};
</script>

<style></style>
