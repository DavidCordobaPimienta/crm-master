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
                        <input
                            type="email"
                            v-model="fillLogin.email"
                            class="form-control"
                            placeholder="Correo Electrónico"
                        />
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input
                            type="password"
                            @keyup.enter="login"
                            v-model="fillLogin.password"
                            class="form-control"
                            placeholder="Contraseña"
                        />
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
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
                        v-loading.fullscreen.lock="fullscreenLoading"
                        class="btn btn-block btn-primary"
                    >
                        Iniciar Sesión
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
            listRolPermisosByUsuario: []
        };
    },
    methods: {
        login() {
            if (this.validarLogin()) {
                return;
            }
            this.fullscreenLoading = true;
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
                        //this.loginSuccess();
                        this.getListarRolPermisosByUsuario(response.data.authUser.id)
                    }
                    this.fullscreenLoading = false;
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
          var ruta = '/administracion/usuarios/getListarRolPermisosByUsuario'
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
