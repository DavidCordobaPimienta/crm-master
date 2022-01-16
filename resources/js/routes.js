import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

export default new Router ({
    routes: [
        { path: '/', component: require('./components/modulos/dashboard/Index.vue').default },
        { path: '/casos', component: require('./components/modulos/casos/Index.vue').default },
        { path: '/cuentas', component: require('./components/modulos/cuentas/Index.vue').default },
        { path: '/permisos', component: require('./components/modulos/permisos/Index.vue').default },
        { path: '/productos', component: require('./components/modulos/productos/Index.vue').default },
        { path: '/reportes', component: require('./components/modulos/reportes/Index.vue').default },
        { path: '/roles', component: require('./components/modulos/roles/Index.vue').default },
        { path: '/tipologias', component: require('./components/modulos/tipologias/Index.vue').default },

        { path: '/usuarios', component: require('./components/modulos/usuarios/Index.vue').default },
        { path: '/usuarios/crear', component: require('./components/modulos/usuarios/Create.vue').default },
        { path: '/usuarios/editar/:id', name: 'usuarios.editar', component: require('./components/modulos/usuarios/Edit.vue').default, props: true },

    ],
    mode: 'history',
    linkExactActiveClass: 'active'
})