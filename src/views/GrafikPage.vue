<template>
  <div class="content-wrapper">
    <div class="row">
      <div class="col-md-12 grid-margin title">
        <div class="row">
          <div class="col-12 align-items-center">
            <h3 class="font-weight-bold">GRAFIK BAPENDA SURAKARTA</h3>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <div class="d-flex justify-content-between">
            <p class="card-title">Agenda Per Bulan</p>
          </div>
          <canvas ref="chart">
            
          </canvas>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Chart from "chart.js";
// import axios from "axios";
export default {
  mounted(){
    this.getGraphAgenda();
  },

  methods: {
    getGraphAgenda() {

      this.$axios.post("/agendas-graph")
      .then(response => {
        this.createChart(response.data.data);
      })
      .catch(error => {
        console.log(error);
      });
    },

    createChart(data) {
      const ctx = this.$refs.chart.getContext("2d");
      const labels = data.map(item => item.date);
      const values = data.map(item => item.agenda_count);

      new Chart(ctx, {
        type: "bar",
        data: {
          labels: labels,
          datasets: [{
            label: "Agenda",
            data: values,
            backgroundColor: "rgba(75, 192, 192, 0.6)",
            borderColor: "rgba(75, 192, 192, 1)",
            borderWidth: 1
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          scales: {
            y: {
              beginAtZero: true
            }
          }
        }
      });
    }
  }
};
</script>