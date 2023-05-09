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
                      <th>Disposisi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(agenda, index) in agendas.data" :key="agenda.id">
                      <td>{{ index + 1}}</td>
                      <td>{{ agenda.title }}</td>
                      <td>{{ agenda.date }}</td>
                      <td>{{ agenda.start_time }} - {{ agenda.end_time }}</td>
                      <td>{{ agenda.room }}</td>
                      <td>{{ agenda.person_in_charge }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>  
</template>

<script>
import axios from "axios";
export default {
	name: "LandingPage",
	data() {
		return {
			agendas: {},
		}; 
	},

	methods: {
		getAgenda(page) {
			if (typeof page === "undefined") {
				page = 1;
			}
  
			axios.get("https://v3421024.mhs.d3tiuns.com/api/agendas", {
				params: {
					page: page
				}
			}).then(data => {
				this.agendas = data.data.data;
			});     
		},
	},

	created() {
		this.getAgenda();
	},
	mounted() {
		console.log("Component mounted.");
	}
};
</script>