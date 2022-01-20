<template>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><strong>CREAR PRODUCTO</strong></h1>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->

        <div class="content container-fluid">
            <!--Creación de botón regresar-->
            <div class="card">
                <div class="card-header">
                    <div class="card-tools">
                        <router-link class="btn btn-info btn-sm" to="/productos">
                            <i class="fas fa-arrow-left"></i>
                            Regresar
                        </router-link>
                    </div>
                </div>
                <div class="card-body">
                    <!--Creación de formulario de registro-->
                    <div class="containter">
                        <div class="row">
                            <div class="col-md-5"></div>
                        </div>
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <strong>REGISTRAR PRODUCTO</strong>
                                </h3>
                            </div>
                            <div class="card-body">
                                <form role="form">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label
                                                    class="col-md-4 col-form-label"
                                                    >Nombre del Producto</label
                                                >
                                                <div class="col-md-7">
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        v-model="
                                                            fillCrearProducto.cNombre
                                                        "
                                                        @:keyup.enter="
                                                            setRegistrarProducto
                                                        "
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label
                                                    class="col-md-3 col-form-label"
                                                    >Descripción</label
                                                >
                                                <div class="col-md-8">
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        v-model="
                                                            fillCrearProducto.cDescripcion
                                                        "
                                                        @:keyup.enter="
                                                            setRegistrarProducto
                                                        "
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label
                                                    class="col-md-4 col-form-label"
                                                    >Categoría</label
                                                >
                                                <div class="col-md-7">
                                                    <el-select
                                                        v-model="
                                                            fillCrearProducto.nIdCategoria
                                                        "
                                                        placeholder="Seleccione una Categoría"
                                                        cleareable
                                                    >
                                                        <el-option
                                                            v-for="item in listCategorias"
                                                            :key="item.id"
                                                            :label="item.name"
                                                            :value="item.id"
                                                        >
                                                        </el-option>
                                                    </el-select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card-footer">
                            <!--Creación de boton registrar y limpiar-->
                            <div class="row">
                                <div class="col-md-4 offset-4">
                                    <button
                                        class="btn btn-info btnWidth"
                                        @click.prevent="setRegistrarProducto"
                                    >
                                        <strong>Registrar</strong>
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
                    </div>

                    <div
                        class="modal fade"
                        :class="{ show: modalShow }"
                        :style="modalShow ? mostrarModal : ocultarModal"
                    >
                        <div
                            class="modal-dialog"
                            role="document"
                            style="max-height: 10px"
                        >
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">
                                        <strong>ERROR</strong>
                                    </h5>
                                    <button
                                        class="close"
                                        @click="abrirModal"
                                    ></button>
                                </div>
                                <div class="modal-body">
                                    <div
                                        class="callout callout-danger"
                                        style="padding: 5px"
                                        v-for="(item, index) in mensajeError"
                                        :key="index"
                                        v-text="item"
                                    ></div>
                                </div>
                                <div class="modal-footer">
                                    <button
                                        class="btn btn-secundary"
                                        @click="abrirModal"
                                    >
                                        Cerrar
                                    </button>
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
    data() {
        return {
            fillBusqProducto: {
                cNombre: '',
                cDescripcion: '',
                nIdCategoria: ''
            },
            fillCrearProducto: {
                cNombre: '',
                cDescripcion: '',
                nIdCategoria: ''
            },
            listCategorias: [],
            fullscreenLoading: false,
            modalShow: false,
            mostrarModal: {
                display: "block",
                background: "#0000006b",
            },
            ocultarModal: {
                display: "none",
            },
            error: 0,
            mensajeError: [],
        };
    },
    mounted() {
        this.getListarCategorias();
    },
    methods: {
        limpiarCriteriosBsq() {
            this.fillCrearProducto.cNombre = "";
            this.fillCrearProducto.cDescripcion = "";
            this.fillCrearProducto.nIdCategoria = "";
        },
        abrirModal() {
            this.modalShow = !this.modalShow;
        },
        getListarCategorias() {
            this.fullscreenLoading = true;
            var url = "/getListarCategorias";
            axios
                .get(url).then((response) => {
                    this.fullscreenLoading = false;
                    this.listCategorias = response.data;
                });
        },
        setRegistrarProducto() {
            if (this.validarRegistrarProductos()) {
                this.modalShow = true;
                return;
            }

            this.fullscreenLoading = true;

            var url = "/setRegistrarProducto";
            axios
                .post(url, {
                    'cNombre': this.fillCrearProducto.cNombre,
                    'cDescripcion': this.fillCrearProducto.cDescripcion,
                    'nIdCategoria': this.fillCrearProducto.nIdCategoria
                })
                .then((response) => {
                    this.fullscreenLoading = false;
                    Swal.fire({
                        icon: "success",
                        title: "¡El producto ha sido creado correctamente!",
                        showConfirmButton: false,
                        timer: 1700,
                    });
                    this.$router.push("/productos");
                });
        },
        validarRegistrarProductos() {
            this.error = 0;
            this.mensajeError = [];

            if (!this.fillCrearProducto.cNombre) {
                this.mensajeError.push("El Nombre es un campo obligatorio.");
            }
        
            if (this.mensajeError.length) {
                this.error = 1;
            }

            return this.error;
        },
    },
};
</script>

<style></style>