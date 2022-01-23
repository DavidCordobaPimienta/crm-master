<template>
    <div class="login-box">
        <div class="login-logo">
            <a href="/resources/vendor/img/konecta.png"><b>CRM</b></a>
        </div>

        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Ingresa tus credenciales</p>

                <form method="post">
                    <div class="input-group mb-3">
                        <vs-input icon-after v-model="fillLogin.email" placeholder="Correo Electronico" :state="(error)?'danger':'primary'"> 
                            <template #icon>
                                <i class='fas fa-envelope'></i>
                            </template>
                        </vs-input>
                    </div>
                    <div class="input-group mb-3">
                        <vs-input type="password" icon-after v-model="fillLogin.password" placeholder="Contraseña" :state="(error)?'danger':'primary'">
                            <template #icon>
                                <i class='fas fa-lock'></i>
                            </template>
                        </vs-input>
                    </div>
                </form>
                <div class="row">
                    <div class="col-md-12">
                        <span v-if="error">
                            <div
                                v-for="(e, index) in mensajeError"
                                :key="index"
                                v-text="e"
                                class="callout callout-danger"
                            ></div>
                        </span>
                    </div>
                </div>

                <div class="social-auth-links text-center mb-3">
                    <button
                        @click.prevent="login"
                        class="btn btn-block btn-primary"
                    >
                        <strong>Iniciar Sesión</strong>
                    </button>
                </div>
                <!-- /.social-auth-links -->
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            fillLogin: {
                email: "",
                password: "",
            },
            fullscreenLoading: false,
            error: 0,
            mensajeError: [],
            listRolPermisosByUsuario: [],
            fillPermiso: []
        };
    },
    methods: {
        login() {
            if (this.validarLogin()) {
                return;
            }
            const loading = this.$vs.loading({
                type: 'waves'
            })
            var url = "/authenticate/login";
            axios
                .post(url, {
                    email: this.fillLogin.email,
                    password: this.fillLogin.password,
                })
                .then((response) => {
                    if (response.data.code == 401) {
                        this.loginFailed();
                    } else if (response.data.code == 200) {
                        this.loginSuccess();
                        this.getListarRolPermisosByUsuario(response.data.authUser.id)
                        console.log(response.data);
                    }
                    setTimeout(() => {
                        loading.close()
                    }, 3000)
                });
        },
        validarLogin() {
            this.error = 0;
            this.mensajeError = [];

            if (!this.fillLogin.email) {
                this.mensajeError.push(
                    "El correo electronico es un campo obligatorio"
                );
            }
            if (!this.fillLogin.password) {
                this.mensajeError.push("La contraseña es un campo obligatorio");
            }
            if (this.mensajeError.length) {
                this.error = 1;
            }
            return this.error;
        },
        loginFailed() {
            this.error = 0;
            this.mensajeError = [];
            this.mensajeError.push(
                "ERROR: ¡Las credenciales ingresadas son incorrectas o no existen!"
            );
            this.fillLogin.password = "";
            if (this.mensajeError.length) {
                this.error = 1;
            }
            return this.error;
        },
        loginSuccess() {
            this.$router.push({ name: "dashboard.index" });
            location.reload();
        },
        getListarRolPermisosByUsuario(id){
          var ruta = '/getListarRolPermisosByUsuario'
                axios.get(ruta,{
                  params:{
                    'nIdUsuario': id
                  }
                }).then( response => {
                    this.listRolPermisosByUsuario = response.data;
                 })
    },
    }
};
</script>

<style></style>
