<template>
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item d-none d-sm-inline-block">
        <router-link class="nav-link" :to="{name: 'casos.index'}">Casos</router-link>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <router-link class="nav-link" :to="{name: 'productos.index'}">Productos</router-link>      </li>
    </ul>
    <!-- Right navbar links -->

  </nav>
</template>

<script>
export default {
  props: ['ruta']
}
</script>

<style>

</style>