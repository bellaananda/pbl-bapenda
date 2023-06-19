<template>
  <div style="width: 100%;" class="main-panel">
    <div class="content-wrapper">
      <div class="row">
        <div class="col-md-12 grid-margin title">
          <div class="row">
            <div class="col-12 align-items-center">
              <h3 class="font-weight-bold">AGENDA BAPENDA SURAKARTA</h3>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <div class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Judul Agenda</th>
                      <th>Tanggal</th>
                      <th>Waktu</th>
                      <th>Lokasi</th>
                      <!-- <th>Disposisi</th> -->
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(agenda, index) in agendas.data" :key="index">
                      <td>{{ index + 1}}</td>
                      <td>{{ agenda.title }}</td>
                      <td>{{ formatTanggal(agenda.date) }}</td>
                      <td>{{ formatWaktu(agenda.start_time) }} - {{ formatWaktu(agenda.end_time) }}</td>
                      <td>{{ agenda.location }}</td>
                      <!-- <td>{{ agenda.disposition }}</td> -->
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <Footer/>
  </div>
  
</template>

<script>
import moment from "moment";
import Footer from "../components/TheFooter.vue";
export default {
	name: "LandingPage",
  components: {
    Footer
  },
	data() {
		return {
			agendas: [],
		}; 
	},

  mounted() {
    this.getAgenda();
  },

	methods: {
    formatTanggal(date) {
      moment.locale("id");
      // console.log("Formatting date:", date);
      return moment(date).format("DD MMMM YYYY");
    },

    formatWaktu(time) {
      return moment(time, "HH:mm").format("HH:mm");
    },

    getAgenda(){
		  this.$axios.get("/agendas-today", {
			  }).then(response => {
				  this.agendas = response.data;
			  });     
		},
	},
};
</script>