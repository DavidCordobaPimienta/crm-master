<template>
    <div>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark"><strong>CREAR CASO</strong></h1>
                    </div>
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        <div class="content container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="card-tools">
                        <router-link class="btn btn-info btn-sm" :to="'/casos'">
                            <i class="fas fa-arrow-left"></i> Regresar
                        </router-link>
                    </div>
                </div>
                <div class="card-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card card-info">
                                    <div class="card-header">
                                        <h3 class="card-title"><strong>{{ (switchCliente) ? 'REGISTRAR' : 'BUSCAR' }} CLIENTE</strong></h3>
                                    </div>
                                    <div class="card-body">
                                        <form role="form">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <vs-switch v-model="switchCliente" @change="limpiarCriterios">
                                                        <template #off>
                                                            <i class="fas fa-plus-square"></i>
                                                        </template>
                                                        <template #on>
                                                            <i class="fas fa-search"></i>
                                                        </template>
                                                    </vs-switch>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group row">
                                                        <label class="col-md-12 col-form-label">Documento</label>
                                                        <div class="col-md-12">
                                                            <template v-if="switchCliente">
                                                                <input type="text" class="form-control" v-model="fillCrearCliente.cDocumento" @keyup.enter="setRegistrarPedido">
                                                            </template>
                                                            <template v-else>
                                                                <el-autocomplete
                                                                    class="inline-input"
                                                                    v-model="cBusqueda"
                                                                    :fetch-suggestions="querySearch"
                                                                    placeholder="Buscar"
                                                                    :trigger-on-focus="true"
                                                                    size="medium"
                                                                    style="width:100%"
                                                                    @select="clientSelect">
                                                                    <i
                                                                        class="el-icon-search el-input__icon"
                                                                        slot="suffix">
                                                                    </i>
                                                                </el-autocomplete>
                                                            </template>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group row">
                                                        <label class="col-md-12 col-form-label">Nombre</label>
                                                        <div class="col-md-12">
                                                            <input type="text" class="form-control" v-model="fillCrearCliente.cNombre" @keyup.enter="setRegistrarPedido" :disabled="(switchCliente) ? false : true">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group row">
                                                        <label class="col-md-12 col-form-label">Apellidos</label>
                                                        <div class="col-md-12">
                                                            <input type="text" class="form-control" v-model="fillCrearCliente.cApellido" @keyup.enter="setRegistrarPedido" :disabled="(switchCliente) ? false : true">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group row">
                                                        <label class="col-md-12 col-form-label">Correo</label>
                                                        <div class="col-md-12">
                                                            <vs-input v-model="fillCrearCliente.cEmail" placeholder="correo@mail.com" :disabled="(switchCliente) ? false : true">
                                                                <template v-if="validEmail" #message-success>Correo Electronico válido</template>
                                                                <template v-if="!validEmail && fillCrearCliente.cEmail !== ''" #message-danger>Correo Electronico invalido</template>
                                                            </vs-input>
                                                            <!-- <input type="email" class="form-control" v-model="fillCrearCliente.cEmail" @keyup.enter="setRegistrarPedido" :disabled="(switchCliente) ? false : true"> -->
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group row">
                                                        <label class="col-md-12 col-form-label">Teléfono</label>
                                                        <div class="col-md-12">
                                                            <input type="number" class="form-control" v-model="fillCrearCliente.cTelefono" @keyup.enter="setRegistrarPedido" :disabled="(switchCliente) ? false : true">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer" >
                                        <div class="row" >
                                            <button v-if="listPedidos.length > 0" class="btn btn-info btnFull" @click.prevent="setRegistrarPedido"><strong>Registrar Caso</strong></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="card card-info">
                                    <div class="card-header">
                                        <h3 class="card-title"><strong>REGISTRAR CASO</strong></h3>
                                    </div>
                                    <div class="card-body table-responsive">
                                        <vs-tooltip not-arrow right>
                                          <vs-button
                                            @click.prevent="agregarProducto"
                                            icon
                                            upload
                                            :active="active == 0"
                                            @click="active = 0">
                                            <i class='fas fa-plus-square'></i>
                                          </vs-button>
                                            <template #tooltip>
                                                Agregar Información
                                            </template>
                                        </vs-tooltip>

                                        <template v-if="listPedidos.length">
                                            <div class="scrollTable">
                                                <table class="table table-hover table-head-fixed text-nowrap projects">
                                                    <thead>
                                                        <tr>
                                                            <th>Producto</th>
                                                            <th>Acción</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="(item, index) in listPedidos" :key="index">
                                                            <td>
                                                                <el-select  v-model="item.nIdProducto"
                                                                            @change="obtenerProducto(item.nIdProducto, index)"
                                                                            placeholder="Seleccione un Producto"
                                                                            >
                                                                    <el-option
                                                                        v-for="item in listProductos"
                                                                        :key="item.id"
                                                                        :label="item.name"
                                                                        :value="item.id">
                                                                    </el-option>
                                                                </el-select>
                                                            </td>
                                                            <td>
                                                                <el-tooltip class="item" effect="dark" content="Remover Información" placement="left">
                                                                    <vs-button
                                                                        @click.prevent="removerProducto(index)"
                                                                        icon
                                                                        :active="active == 0"
                                                                        @click="active = 0">
                                                                        <i class='fas fa-trash'></i>
                                                                    </vs-button>
                                                                </el-tooltip>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <el-row :gutter="20">
                                                <el-col :span="16">
                                                    <vs-input border v-model="cComentario" placeholder="Agregar Comentario" />
                                                </el-col>
                                            </el-row>
                                        </template>
                                        <template v-else>
                                            <div class="callout callout-info">
                                                <h5>Lo sentimos: No se encontraron resultados o no ha agregado información al caso.</h5>
                                            </div>
                                        </template>
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
                fillCrearCliente: {
                    nIdCliente: '',
                    cDocumento: '',
                    cNombre: '',
                    cApellido: '',
                    cEmail: '',
                    cTelefono: ''
                },
                switchCliente: false,
                active:'',

                cBusqueda: '',
                listClientes: [],
                listClientesFilter: [],

                listProductos: [],
                listPedidos: [],
                cComentario: '',

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
                return /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(this.fillCrearCliente.cEmail)
            },
        },
        mounted() {
            this.agregarProducto();
            this.getListarClientes();
            this.getListarProductos();
        },
        methods: {
            querySearch(queryString, cb) {
                var links = this.listClientesFilter;
                var results = queryString ? links.filter(this.createFilter(queryString)) : links;
                // call callback function to return suggestions
                cb(results);
            },
            createFilter(queryString) {
                return (link) => {
                    return (link.value.toLowerCase().indexOf(queryString.toLowerCase()) != -1);
                };
            },
            getListarClientes(){
                var ruta = '/operacion/cuentas/getListarClientes'
                axios.get(ruta).then( response => {
                    this.listClientes = response.data;
                    this.filterListarClientes();
                }).catch(error => {
                    if (error.response.status == 401) {
                        this.$router.push({name: 'login'})
                        location.reload();
                        sessionStorage.clear();
                        this.fullscreenLoading = false;
                    }
                })
            },
            filterListarClientes() {
                let me = this;
                me.listClientesFilter = [];
                me.listClientes.map(function(x, y){
                    me.listClientesFilter.push({
                        'value' : x.document + ' - ' + x.fullname,
                        'link'  : x.id
                    })
                })
            },
            clientSelect(item) {
                let rpta = this.listClientes.filter(cliente => {
                    return ((String(cliente.id)).indexOf(String(item.link)) != -1);
                })
                this.fillCrearCliente.nIdCliente    = rpta[0].id;
                this.fillCrearCliente.cDocumento    = rpta[0].document;
                this.fillCrearCliente.cNombre       = rpta[0].name;
                this.fillCrearCliente.cApellido     = rpta[0].lastname;
                this.fillCrearCliente.cEmail        = rpta[0].email;
                this.fillCrearCliente.cTelefono     = rpta[0].phone;
            },
            getListarProductos(){
                var ruta = '/getListarProductos'
                axios.get(ruta).then( response => {
                    this.listProductos = response.data;
                }).catch(error => {
                    if (error.response.status == 401) {
                        this.$router.push({name: 'login'})
                        location.reload();
                        sessionStorage.clear();
                        this.fullscreenLoading = false;
                    }
                })
            },
            limpiarCriterios(){
                this.fillCrearCliente.nIdCliente    = '';
                this.cBusqueda                      = '';
                this.fillCrearCliente.cDocumento    = '';
                this.fillCrearCliente.cNombre       = '';
                this.fillCrearCliente.cApellido     = '';
                this.fillCrearCliente.cEmail        = '';
                this.fillCrearCliente.cTelefono     = '';
            },
            abrirModal(){
                this.modalShow = !this.modalShow;
            },
            agregarProducto(){
                let me = this;

                if (this.listPedidos.length == 0) {
                    this.listPedidos.push({
                        'nIdProducto':  ''
                    })
                } else {
                    let contador = 0;
                    this.listPedidos.map(function(x, y){
                        if (!x.nIdProducto) {
                            contador++;
                            //Notificacion
                            const noti = me.$vs.notification({
                                square: true,
                                color: 'rgb(0,123,255)',
                                title: '<strong>¡ATENCIÓN!</strong>',
                                text: 'Debe completar la información para el registro ' + (y+1)
                            })
                        }
                    })
                    if (contador == 0) {
                        this.listPedidos.push({
                            'nIdProducto':  ''
                        })
                    }
                }

            },
            removerProducto(index){
                this.$delete(this.listPedidos, index);
            },
            obtenerProducto(nIdProducto, index){
                let me = this;
                let contador = 0;
                this.listPedidos.map(function(x, y){
                    if (x.nIdProducto == nIdProducto && y != index) {
                        contador++;
                        //Notificacion
                        const noti = me.$vs.notification({
                            square: true,
                            color: 'rgb(0,123,255)',
                            title: '<strong>¡ATENCIÓN!</strong>',
                            text: 'El producto seleccionado ya se encuentra en el registro ' + (y+1)
                        })
                    }
                })
                if(contador==0){
                  let rpta = this.listProductos.filter(producto => {
                    return ((String(producto.id)).indexOf(String(nIdProducto)) != -1);
                  })
                }
            },
            setRegistrarPedido(){
                if (this.validarRegistrarPedido()) {
                    this.modalShow = true;
                    return;
                }
                this.loading = this.$vs.loading({
                    type: 'square',
                    color: '#D5397B',
                    background: '#FFFFFF',
                    text: 'Cargando...'
                })

                if (this.switchCliente) {
                    this.setRegistrarCliente();
                } else {
                    this.setGuardarPedido(this.fillCrearCliente.nIdCliente);
                }
            },
            setRegistrarCliente(){
                this.fullscreenLoading = false;
                var url = '/setRegistrarCliente'
                axios.post(url, {
                    'cDocumento'    :   this.fillCrearCliente.cDocumento,
                    'cNombre'       :   this.fillCrearCliente.cNombre,
                    'cApellido'     :   this.fillCrearCliente.cApellido,
                    'cEmail'        :   this.fillCrearCliente.cEmail,
                    'cTelefono'     :   this.fillCrearCliente.cTelefono
                }).then(response => {
                    let nIdCliente = response.data[0].nIdCliente;
                    this.setGuardarPedido(nIdCliente);
                }).catch(error => {
                    if (error.response.status == 401) {
                        this.$router.push({name: 'casos.index'})
                        location.reload();
                        sessionStorage.clear();
                        this.fullscreenLoading = false;
                    }
                })
            },
            setGuardarPedido(nIdCliente){
                var url = '/setRegistrarPedido'
                axios.post(url, {
                    'nIdCliente'    :   nIdCliente,
                    'cComentario'   :   this.cComentario,
                    'listPedido'    :   this.listPedidos
                }).then(response => {
                    this.setGenerarEmail(response.data);
                }).catch(error => {
                    if (error.response.status == 401) {
                        this.$router.push({name: 'login'})
                        location.reload();
                        sessionStorage.clear();
                        this.fullscreenLoading = false;
                    }
                })
            },
            setGenerarEmail(nIdPedido){
                var url = '/setGenerarEmail'
                axios.post(url, {
                    'nIdPedido' :   nIdPedido
                }).then(response => {
                    this.setGenerarDocumento(nIdPedido)
                }).catch(error => {
                    console.log(error)
                    if (error.response.status == 401) {
                        this.$router.push({name: 'login'})
                        location.reload();
                        sessionStorage.clear();
                        this.fullscreenLoading = false;
                    }
                })
            },
            setGenerarDocumento(nIdPedido){
                var config = {
                    responseType: 'blob'
                }
                var url = '/setGenerarDocumento'
                axios.post(url, {
                    'nIdPedido'       :   nIdPedido
                }, config).then(response => {
                    var oMyBlob = new Blob([response.data], {type : 'application/pdf'}); // the blob
                    var url = URL.createObjectURL(oMyBlob);
                    window.open(url)
                    this.loading.close()
                    this.$router.push('/pedido')
                }).catch(error => {
                    console.log(error)
                    if (error.response.status == 401) {
                        this.$router.push({name: 'login'})
                        location.reload();
                        sessionStorage.clear();
                        this.fullscreenLoading = false;
                    }
                })
            },
            validarRegistrarPedido(){
                this.error = 0;
                this.mensajeError = [];

                if (this.switchCliente) {
                    if (!this.fillCrearCliente.cDocumento) {
                        this.mensajeError.push("El Documento es un campo obligatorio")
                    }
                    if (!this.fillCrearCliente.cNombre) {
                        this.mensajeError.push("El Nombre es un campo obligatorio")
                    }
                    if (!this.fillCrearCliente.cApellido) {
                        this.mensajeError.push("Los Apellidos son un campo obligatorio")
                    }
                    if (this.fillCrearCliente.cEmail) {
                        if (!this.validEmail) {
                            this.mensajeError.push("El correo electronico, tiene un formato invalido")
                        }
                    }
                } else {
                    if (!this.fillCrearCliente.nIdCliente) {
                        this.mensajeError.push("Debe de asociar un cliente al caso")
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
