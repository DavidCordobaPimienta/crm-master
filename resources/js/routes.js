import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

export default new Router ({
    routes: [
        { path: '/', name: 'dashboard.index',component: require('./components/modulos/dashboard/Index.vue').default },

        //MODULO AUTENTICACIÓN
        { path: '/login', name: 'login', component: require('./components/modulos/authenticate/Login.vue').default },

        //MODULO CASOS:
        { path: '/casos', name: 'casos.index', component: require('./components/modulos/casos/Index.vue').default },

        //MODULO CUENTAS:
        { path: '/cuentas', name: 'cuentas.index',  component: require('./components/modulos/cuentas/Index.vue').default },

        //MODULO PERMISOS:
        { path: '/permisos',  name: 'permisos.index', component: require('./components/modulos/permisos/Index.vue').default },
        { path: '/permisos/crear', name: 'permisos.crear',  component: require('./components/modulos/permisos/Create.vue').default },
        { path: '/permisos/editar/:id', name:'permisos.editar', component: require('./components/modulos/permisos/Edit.vue').default, props: true },

        //MODULO PRODUCTOS:
        { path: '/productos', name: 'productos.index',  component: require('./components/modulos/productos/Index.vue').default },
        
        //MODULO REPORTES:
        { path: '/reportes', name: 'reportes.index',  component: require('./components/modulos/reportes/Index.vue').default },
        
        //MODULO ROLES:
        { path: '/roles', name: 'roles.index',  component: require('./components/modulos/roles/Index.vue').default },
        { path: '/roles/crear',  name: 'roles.crear', component: require('./components/modulos/roles/Create.vue').default },
        { path: '/roles/editar/:id', name:'roles.editar', component: require('./components/modulos/roles/Edit.vue').default, props: true },

        //MODULO TIPOLOGÍAS:
        { path: '/tipologias', name: 'tipologias.index',  component: require('./components/modulos/tipologias/Index.vue').default },
        { path: '/tipologias/crear', name: 'tipologias.crear',  component: require('./components/modulos/tipologias/Create.vue').default },


        //MODULO USUARIOS:
        { path: '/usuarios', name: 'usuarios.index',  component: require('./components/modulos/usuarios/Index.vue').default },
        { path: '/usuarios/crear', name: 'usuarios.crear',  component: require('./components/modulos/usuarios/Create.vue').default },
        { path: '/usuarios/editar/:id', name: 'usuarios.editar', component: require('./components/modulos/usuarios/Edit.vue').default, props: true },
        { path: '/usuarios/ver', name: 'usuarios.ver', component: require('./components/modulos/usuarios/View.vue').default, props: true },
        { path: '/usuarios/permiso/:id', name: 'usuarios.permiso', component: require('./components/modulos/usuarios/Permission.vue').default, props: true },

    ],
    mode: 'history',
    linkExactActiveClass: 'active'
})