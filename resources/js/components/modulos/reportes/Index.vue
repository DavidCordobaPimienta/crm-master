<template>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><strong>REPORTES DE CASOS</strong></h1>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->

        <div class="content container-fluid">
            <!--Creación de botón nuevo usuario-->
            <div class="card">

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
                                                            fillBusqPedido.cNombre
                                                        "
                                                        @keyup.enter="
                                                            getListarPedidosR
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
                                                            fillBusqPedido.cDocumento
                                                        "
                                                        @keyup.enter="
                                                            getListarPedidosR
                                                        "
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label
                                                    class="col-md-4 col-form-label"
                                                    >No. Caso</label
                                                >
                                                <div class="col-md-7">
                                                    <input
                                                        type="number"
                                                        class="form-control"
                                                        v-model="
                                                            fillBusqPedido.cPedido
                                                        "
                                                        @keyup.enter="
                                                            getListarPedidosR
                                                        "
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label
                                                    class="col-md-4 col-form-label"
                                                    >Estado</label
                                                >
                                                <div class="col-md-7">
                                                    <el-select
                                                        v-model="
                                                            fillBusqPedido.nIdEstado
                                                        "
                                                        placeholder="Seleccione un Estado"
                                                        cleareable
                                                    >
                                                        <el-option
                                                            v-for="item in listEstados"
                                                            :key="item.value"
                                                            :label="item.label"
                                                            :value="item.value"
                                                        >
                                                        </el-option>
                                                    </el-select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label
                                                    class="col-md-4 col-form-label"
                                                    >Rango de Fechas</label
                                                >
                                                <div class="col-md-7">
                                                    <el-date-picker
                                                        v-model="fillBusqPedido.dFechaRango"
                                                        type="daterange"
                                                        range-separator="A"
                                                        start-placeholder="Fecha Inicial"
                                                        end-placeholder="Fecha Final"
                                                        value-format="yyyy-MM-dd"
                                                        >
                                                    </el-date-picker>
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
                                        @click.prevent="getListarPedidosR"
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
                                    v-if="listarPedidosPaginated.length"
                                >
                                    <table
                                        class="table table-hover table-head-fixed text-nowrap projects"
                                    >
                                        <!--Creación de la tabla de resultados-->
                                        <thead>
                                            <tr>
                                                <th>No. Caso</th>
                                                <th>No. Documento</th>
                                                <th>Cliente</th>
                                                <th>Asesor</th>
                                                <th>Comentario</th>
                                                <th>Estado</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr
                                                v-for="(
                                                    item, index
                                                ) in listarPedidosPaginated"
                                                :key="index"
                                            >
                                                <td 
                                                    v-text="item.pedido">
                                                </td>
                                                <td
                                                    v-text="item.documento"
                                                ></td>
                                                <td
                                                    v-text="item.cliente"
                                                ></td>
                                                <td
                                                    v-text="item.agente"
                                                ></td>
                                                <td
                                                    v-text="item.comentario"
                                                ></td>
                                                <td>
                                                    <template v-if="item.state=='A'">
                                                        <span class="badge badge-success" v-text="item.estado"></span>
                                                        </template>
                                                        <template v-else>
                                                        <span class="badge badge-danger" v-text="item.estado"></span>
                                                    </template> 
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
            fillBusqPedido: {
                cDocumento: '',
                cNombre: '',
                cPedido: '',
                dFechaRango: '',
                nIdEstado: ''
            },
            listPedidos: [],
            listEstados: [
                {value: 'A', label: 'Activo'},
                {value: 'I', label: 'Cerrado'}
            ],
            fullscreenLoading: false,
            pageNumber: 0,
            perPage: 5,
        };
    },
    computed: {
        pageCount() {
            //Obtener el número de páginas
            let a = this.listPedidos.length,
                b = this.perPage;
            return Math.ceil(a / b);
        },
        listarPedidosPaginated() {
            let inicio = this.pageNumber * this.perPage,
                fin = inicio + this.perPage;
            return this.listPedidos.slice(inicio, fin);
        },
        pagesList() {
            let a = this.listPedidos.length,
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
            this.fillBusqPedido.cNombre = "";
            this.fillBusqPedido.cDocumento = "";
            this.fillBusqPedido.cPedido = "";
            this.fillBusqPedido.nIdEstado = "";
            this.fillBusqPedido.dFechaRango = "";
        },
        getListarPedidosR() {
            this.fullscreenLoading = true;
            var url ="/getListarPedidosR";
            axios
                .get(url, {
                    params: {
                        'cDocumento': this.fillBusqPedido.cDocumento,
                        'cNombre': this.fillBusqPedido.cNombre,
                        'cPedido':this.fillBusqPedido.cPedido,
                        'dFechaInicio': this.fillBusqPedido.dFechaRango[0],
                        'dFechaFin': this.fillBusqPedido.dFechaRango[1],
                        'nIdEstado': this.fillBusqPedido.nIdEstado,
                    },
                })
                .then((response) => {
                    this.fullscreenLoading = false;
                    this.inicializarPaginacion();
                    this.listPedidos = response.data;
                });
        },
        setGenerarDocumento(nIdPedido){
            this.fullscreenLoading = true;

            var url = "/setGenerarDocumento";
             var config = {
                responseType: 'blob'
            };
            
            axios
                .post(url, {
                    'nIdPedido': nIdPedido
                }, config)
                .then((response) => {
                    var oMyBlob = new Blob([response.data], {type : 'application/pdf'});
                    var url = URL.createObjectURL(oMyBlob);
                    window.open(url);
                    this.inicializarPaginacion();
                    this.listPedidos = response.data;
                    this.fullscreenLoading = false;
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
