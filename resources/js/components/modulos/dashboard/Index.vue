<template>
  <div>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark"><strong>TABLERO DE MANDO</strong></h1>
                    </div>
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        <div class="content container-fluid">
            <div class="card">
                <div class="card-body">
                  <div class="container-fluid">
                  <div class="row">
                    <div class="col-md-6">
                      <canvas id="myChart" width="400" height="400"></canvas>
                    </div>
                    <div class="col-md-6">
                      <canvas id="myChart2" width="400" height="400"></canvas>
                    </div>
                  </div>
                </div>
            </div>
        </div>
      </div>
  </div>
</template>

<script>
    import Chart from 'chart.js/auto'
    export default {
      data() {
        return {
          listCasosMasUsados: {
            all: [],
            name: [],
            cantidad: [],
            colores: []
          },
          listCasosDiarios: {
            all: [],
            name: [],
            cantidad: []
          },
        }
      },
      mounted() {
        this.getCasosMasUsados(); 
        this.getCasosPorDia();      
      },
      methods: {
        getCasosMasUsados(){
                var ruta = '/getCasosMasUsados'
                axios.get(ruta).then( response => {
                    this.listCasosMasUsados.all = response.data;
                    this.getCasosMasUsadosFiltrar();
                }).catch(error => {
                    if (error.response.status == 401) {
                        this.$router.push({name: 'login'})
                        location.reload();
                        sessionStorage.clear();
                        this.fullscreenLoading = false;
                    }
                })
        },
        getCasosMasUsadosFiltrar(){
          let me = this;
          this.listCasosMasUsados.all.map(function(x,y){
            me.listCasosMasUsados.name.push(x.name);
            me.listCasosMasUsados.cantidad.push(x.cantidad);
            let parametro1 = Math.floor(Math.random() * 256);
            let parametro2 = Math.floor(Math.random() * 256);
            let parametro3 = Math.floor(Math.random() * 256);
            let color = 'rgba('+parametro1+', '+parametro2+', '+parametro3+', 0.2)';
            me.listCasosMasUsados.colores.push(color);
          })
          this.getGraficoBar();
        },
        getGraficoBar(){
          let me = this;
          const ctx = document.getElementById('myChart').getContext('2d');
          const myChart = new Chart(ctx, {
              type: 'bar',
              data: {
                  labels:  me.listCasosMasUsados.name,
                  datasets: [{
                      label: 'TIPOLOGÍAS DE CASOS FRECUENTES',
                      data: me.listCasosMasUsados.cantidad,
                      backgroundColor: me.listCasosMasUsados.colores,
                      borderColor: me.listCasosMasUsados.colores,
                      borderWidth: 2
                  }]
              },
              options: {
                  scales: {
                      y: {
                          beginAtZero: true
                      }
                  }
              }
          });
        },
        getCasosPorDia(){
                var ruta = '/getCasosPorDia'
                axios.get(ruta).then( response => {
                    this.listCasosDiarios.all = response.data;
                    this.getCasosPorDiaFiltrar();
                }).catch(error => {
                    if (error.response.status == 401) {
                        this.$router.push({name: 'login'})
                        location.reload();
                        sessionStorage.clear();
                        this.fullscreenLoading = false;
                    }
                })
        },
        getCasosPorDiaFiltrar(){
          let me = this;
          this.listCasosDiarios.all.map(function(x,y){
            me.listCasosDiarios.name.push(x.dia);
            me.listCasosDiarios.cantidad.push(x.total);
          })
          this.getGraficoLine();
        },
        getGraficoLine(){
          let me = this;
          const ctx = document.getElementById('myChart2').getContext('2d');
          const myChart = new Chart(ctx, {
              type: 'line',
              data: {
                  labels:  (me.listCasosDiarios.name),
                  datasets: [{
                      label: 'CASOS DIARIOS',
                      data: me.listCasosDiarios.cantidad
                  }]
              },
              options: {
                  scales: {
                      y: {
                          beginAtZero: true
                      }
                  }
              }
          });
        }
      }, 
    } 
</script>

<style>

</style>
