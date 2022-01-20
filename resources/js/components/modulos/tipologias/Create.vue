<template>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><strong>CREAR TIPOLOGÍA</strong></h1>
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
                        <router-link class="btn btn-info btn-sm" to="/tipologias">
                            <i class="fas fa-arrow-left"></i>
                            Regresar
                        </router-link>
                    </div>
                </div>
                <div class="card-body">
                    <!--Creación de formulario de registro-->
                    <div class="containter">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <strong>REGISTRAR TIPOLOGÍA</strong>
                                </h3>
                            </div>
                            <div class="card-body">
                                <form role="form">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label
                                                    class="col-md-5 col-form-label"
                                                    >Primer Nombre</label
                                                >
                                                <div class="col-md-6">
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        v-model="
                                                            fillCrearUsuario.cPrimerNombre
                                                        "
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label
                                                    class="col-md-5 col-form-label"
                                                    >Segundo Nombre</label
                                                >
                                                <div class="col-md-6">
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        v-model="
                                                            fillCrearUsuario.cSegundoNombre
                                                        "
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label
                                                    class="col-md-5 col-form-label"
                                                    >Apellidos</label
                                                >
                                                <div class="col-md-6">
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        v-model="
                                                            fillCrearUsuario.cApellidos
                                                        "
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label
                                                    class="col-md-5 col-form-label"
                                                    >Usuario de Red</label
                                                >
                                                <div class="col-md-6">
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        v-model="
                                                            fillCrearUsuario.cUsuario
                                                        "
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label
                                                    class="col-md-5 col-form-label"
                                                    >Correo Electrónico</label
                                                >
                                                <div class="col-md-6">
                                                    <input
                                                        type="email"
                                                        class="form-control"
                                                        v-model="
                                                            fillCrearUsuario.cCorreo
                                                        "
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label
                                                    class="col-md-5 col-form-label"
                                                    >Contraseña</label
                                                >
                                                <div class="col-md-6">
                                                    <el-input
                                                        v-model="
                                                            fillCrearUsuario.cContrasena
                                                        "
                                                        @keyup.enter="
                                                            setRegistrarUsuarios
                                                        "
                                                        show-password
                                                    ></el-input>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label
                                                    class="col-md-5 col-form-label"
                                                    >Rol</label
                                                >
                                                <div class="col-md-6">
                                                    <el-select
                                                        v-model="
                                                            fillCrearUsuario.nIdRol
                                                        "
                                                        placeholder="Seleccione un Rol"
                                                        cleareable
                                                    >
                                                        <el-option
                                                            v-for="item in listRoles"
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
                                        @click.prevent="setRegistrarUsuarios"
                                        v-loading.fullscreen.lock="
                                            fullscreenLoading
                                        "
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
            fillCrearUsuario: {
                cPrimerNombre: "",
                cSegundoNombre: "",
                cApellidos: "",
                cUsuario: "",
                cCorreo: "",
                cContrasena: "",
                nIdRol: "",
            },
            listRoles: [],
            fullscreenLoading: false,
            form: new FormData(),
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
        this.getListarRoles();
    },
    methods: {
        getListarRoles() {
            this.fullscreenLoading = true;
            var url = "/getListarRoles";
            axios.get(url).then((response) => {
                this.fullscreenLoading = false;
                this.listRoles = response.data;
            });
        },
        limpiarCriteriosBsq() {
            this.fillCrearUsuario.cPrimerNombre = "";
            this.fillCrearUsuario.cSegundoNombre = "";
            this.fillCrearUsuario.cApellidos = "";
            this.fillCrearUsuario.cUsuario = "";
            this.fillCrearUsuario.cCorreo = "";
            this.fillCrearUsuario.cContrasena = "";
        },
        abrirModal() {
            this.modalShow = !this.modalShow;
        },
        setRegistrarUsuarios() {
            if (this.validarRegistrarUsuario()) {
                this.modalShow = true;
                return;
            }
            this.setGuardarUsuario();
            this.fullscreenLoading = true;
        },
        setGuardarUsuario() {
            var url = "/setRegistrarUsuarios";
            axios
                .post(url, {
                    cPrimerNombre: this.fillCrearUsuario.cPrimerNombre,
                    cSegundoNombre: this.fillCrearUsuario.cSegundoNombre,
                    cApellidos: this.fillCrearUsuario.cApellidos,
                    cUsuario: this.fillCrearUsuario.cUsuario,
                    cCorreo: this.fillCrearUsuario.cCorreo,
                    cContrasena: this.fillCrearUsuario.cContrasena,
                })
                .then((response) => {
                    this.setEditarRolByUsuario(response.data);
                });
        },
        setEditarRolByUsuario(nIdUsuario) {
            var url = "/setEditarRolByUsuario";
            axios
                .post(url, {
                    nIdUsuario: nIdUsuario,
                    nIdRol: this.fillCrearUsuario.nIdRol,
                })
                .then((response) => {
                    this.fullscreenLoading = false;
                    Swal.fire({
                        icon: "success",
                        title: "¡El usuario ha sido creado correctamente!",
                        showConfirmButton: false,
                        timer: 1700,
                    });
                    this.$router.push("/usuarios");
                });
        },
        validarRegistrarUsuario() {
            this.error = 0;
            this.mensajeError = [];

            if (!this.fillCrearUsuario.cPrimerNombre) {
                this.mensajeError.push(
                    "El Primer Nombre es un campo obligatorio."
                );
            }
            if (!this.fillCrearUsuario.cApellidos) {
                this.mensajeError.push(
                    "Los Apellidos son un campo obligatorio."
                );
            }
            if (!this.fillCrearUsuario.cUsuario) {
                this.mensajeError.push(
                    "El Usuario de Red es un campo obligatorio."
                );
            }
            if (!this.fillCrearUsuario.cCorreo) {
                this.mensajeError.push(
                    "El Correo Electrónico es un campo obligatorio."
                );
            }
            if (!this.fillCrearUsuario.cContrasena) {
                this.mensajeError.push(
                    "La Contraseña es un campo obligatorio."
                );
            }
            if (!this.fillCrearUsuario.nIdRol) {
                this.mensajeError.push("El Rol es un campo obligatorio.");
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
