<template>
    <div>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark"><strong>EDITAR CUENTA</strong></h1>
                    </div>
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        <div class="content container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="card-tools">
                        <router-link class="btn btn-info btn-sm" :to="'/cuentas'">
                            <i class="fas fa-arrow-left"></i> Regresar
                        </router-link>
                    </div>
                </div>
                <div class="card-body">
                    <div class="container-fluid">
                                <div class="card card-info">
                                    <div class="card-header">
                                        <h3 class="card-title"><strong>EDITAR CLIENTE</strong></h3>
                                    </div>
                                    <div class="card-body">
                                        <form role="form">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="col-md-12 col-form-label">Documento de Identificación</label>
                                                        <div class="col-md-12">
                                                                <input type="text" class="form-control" v-model="fillEditarCliente.cDocumento" @keyup.enter="setEditarCliente">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="col-md-12 col-form-label">Nombre</label>
                                                        <div class="col-md-12">
                                                            <input type="text" class="form-control" v-model="fillEditarCliente.cNombre" @keyup.enter="setEditarCliente">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="col-md-12 col-form-label">Apellidos</label>
                                                        <div class="col-md-12">
                                                            <input type="text" class="form-control" v-model="fillEditarCliente.cApellido" @keyup.enter="setEditarCliente">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="col-md-12 col-form-label">Correo Electronico</label>
                                                        <div class="col-md-12">
                                                            <vs-input v-model="fillEditarCliente.cCorreo" placeholder="correo@mail.com">
                                                                <template v-if="validEmail" #message-success>Correo Electronico válido</template>
                                                                <template v-if="!validEmail && fillEditarCliente.cCorreo !== ''" #message-danger>Correo Electronico invalido</template>
                                                            </vs-input>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="col-md-12 col-form-label">Teléfono</label>
                                                        <div class="col-md-12">
                                                            <input type="number" class="form-control" v-model="fillEditarCliente.cTelefono" @keyup.enter="setEditarCliente">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer" >
                                        <div class="row">
                                            <div class="col-md-4 offset-4">
                                                <button
                                                    class="btn btn-info btnWidth"
                                                    @click.prevent="setEditarCliente"
                                                >
                                                    <strong>Editar</strong>
                                                </button>
                                                <button
                                                    class="btn btn-default btnWidth"
                                                    @click.prevent="limpiarCriterios"
                                                >
                                                    <strong>Limpiar</strong>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                </div>
            </div>
        </div>

        <div class="modal fade" :class="{ show: modalShow }" :style=" modalShow ? mostrarModal : ocultarModal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">ERROR</h5>
                        <button class="close" @click="abrirModal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="callout callout-danger" style="padding: 5px" v-for="(item, index) in mensajeError" :key="index" v-text="item"></div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" @click="abrirModal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                fillEditarCliente: {
                    nIdCliente: this.$attrs.id,
                    cDocumento: '',
                    cNombre: '',
                    cApellido: '',
                    cCorreo: '',
                    cTelefono: ''
                },
                fullscreenLoading: false,
                loading: '',
                modalShow: false,
                mostrarModal: {
                    display: 'block',
                    background: '#0000006b',
                },
                ocultarModal: {
                    display: 'none',
                },
                error: 0,
                mensajeError: []
            }
        },
        computed: {
            validEmail() {
                return /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(this.fillEditarCliente.cCorreo)
            },
        },
        mounted() {
            this.getListarClientes();
        },
        methods: {
            limpiarCriterios(){
                this.fillEditarCliente.cDocumento    = '';
                this.fillEditarCliente.cNombre       = '';
                this.fillEditarCliente.cApellido     = '';
                this.fillEditarCliente.cCorreo        = '';
                this.fillEditarCliente.cTelefono     = '';
            },
            abrirModal(){
                this.modalShow = !this.modalShow;
            },
            setEditarCliente(){
                if (this.validarEditarCliente()) {
                    this.modalShow = true;
                    return;
                }

                this.fullscreenLoading = false;
                var url = '/setEditarCliente'
                axios.post(url, {
                    'nIdCliente'    :   this.fillEditarCliente.nIdCliente,
                    'cDocumento'    :   this.fillEditarCliente.cDocumento,
                    'cNombre'       :   this.fillEditarCliente.cNombre,
                    'cApellido'     :   this.fillEditarCliente.cApellido,
                    'cCorreo'        :   this.fillEditarCliente.cCorreo,
                    'cTelefono'     :   this.fillEditarCliente.cTelefono
                }).then(response => {
                    this.$router.push({name: 'cuentas.index'})
                }).catch(error => {
                    if (error.response.status == 401) {
                        location.reload();
                        sessionStorage.clear();
                        this.fullscreenLoading = false;
                    }
                })
            },
            getListarClientes() {
            this.fullscreenLoading = true;
            var url = "/getListarClientes";
            axios
                .get(url, {
                    params: {
                        'nIdCliente': this.fillEditarCliente.nIdCliente,
                    },
                })
                .then((response) => {
                    this.fullscreenLoading = false;
                    this.fillEditarCliente.cDocumento = response.data[0].document,
                    this.fillEditarCliente.cNombre = response.data[0].name,
                    this.fillEditarCliente.cApellido = response.data[0].lastname,
                    this.fillEditarCliente.cCorreo = response.data[0].email,
                    this.fillEditarCliente.cTelefono = response.data[0].phone
                });
            },
            validarEditarCliente(){
                this.error = 0;
                this.mensajeError = [];

                    if (!this.fillEditarCliente.cDocumento) {
                        this.mensajeError.push("El Documento es un campo obligatorio")
                    }
                    if (!this.fillEditarCliente.cNombre) {
                        this.mensajeError.push("El Nombre es un campo obligatorio")
                    }
                    if (!this.fillEditarCliente.cApellido) {
                        this.mensajeError.push("Los Apellidos son un campo obligatorio")
                    }
                    if (this.fillEditarCliente.cCorreo) {
                        if (!this.validEmail) {
                            this.mensajeError.push("El correo electronico, tiene un formato invalido")
                        }
                    }

                if (this.mensajeError.length) {
                    this.error = 1;
                }
                return this.error;
            },
        }
    }
</script>

<style>
    .el-row {
        margin-bottom: 20px;
    }
    .el-col {
        border-radius: 4px;
    }
    .bg-purple-dark {
        background: #99a9bf;
    }
    .bg-purple {
        background: #d3dce6;
    }
    .bg-purple-light {
        background: #e5e9f2;
    }
    .grid-content {
        border-radius: 4px;
        min-height: 36px;
    }
    .row-bg {
        padding: 10px 0;
        background-color: #f9fafc;
    }
</style>
