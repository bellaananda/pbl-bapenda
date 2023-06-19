<template>
  <div class="main-panel">
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
          <div class="card position-relative">
            <div class="card-body">
              <div id="detailedReports" class="carousel slide detailed-report-carousel position-static pt-2" data-ride="carousel">
                <div class="carousel-inner">
                  <div class="carousel-item active">
                    <div class="row">
                      <div class="col-md-12 col-xl-3 d-flex flex-column justify-content-start">
                        <div class="ml-xl-4 mt-3">
                          <p class="card-title">HARI INI</p>
                        </div>  
                      </div>
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
                                    <th>Penanggungjawab</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr v-for="(agenda, index) in todayAgendas.data" :key="agenda.id">
                                    <td>{{ index + 1}}</td>
                                    <td>{{ agenda.title }}</td>
                                    <td>{{ formatTanggal(agenda.date) }}</td>
                                    <td>{{ formatWaktu(agenda.start_time) }} - {{ formatWaktu(agenda.end_time) }}</td>
                                    <td>{{ agenda.location }}</td>
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
                  <div class="carousel-item">
                    <div class="row">
                      <div class="col-md-12 col-xl-3 d-flex flex-column justify-content-start">
                        <div class="ml-xl-4 mt-3">
                          <p class="card-title">BESOK</p>
                        </div>  
                      </div>
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
                                    <th>Penanggungjawab</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr v-for="(agenda, index) in tomorrowAgendas.data" :key="agenda.id">
                                    <td>{{ index + 1}}</td>
                                    <td>{{ agenda.title }}</td>
                                    <td>{{ formatTanggal(agenda.date) }}</td>
                                    <td>{{ formatWaktu(agenda.start_time) }} - {{ formatWaktu(agenda.end_time) }}</td>
                                    <td>{{ agenda.location }}</td>
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
                  <div class="carousel-item">
                    <div class="row">
                      <div class="col-md-12 col-xl-3 d-flex flex-column justify-content-start">
                        <div class="ml-xl-4 mt-3">
                          <p class="card-title">KEMARIN</p>
                        </div>  
                      </div>
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
                                    <th>Penanggungjawab</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr v-for="(agenda, index) in yesterdayAgendas.data" :key="agenda.id">
                                    <td>{{ index + 1}}</td>
                                    <td>{{ agenda.title }}</td>
                                    <td>{{ formatTanggal(agenda.date) }}</td>
                                    <td>{{ formatWaktu(agenda.start_time) }} - {{ formatWaktu(agenda.end_time) }}</td>
                                    <td>{{ agenda.location }}</td>
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
                <a class="carousel-control-prev" href="#detailedReports" role="button" data-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="sr-only">Previous</span>
                  </a>
                    <a class="carousel-control-next" href="#detailedReports" role="button" data-slide="next">
                      <span class="carousel-control-next-icon" aria-hidden="true"></span>
                      <span class="sr-only">Next</span>
                    </a>
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
import Footer from "../../components/TheFooter.vue";
export default {
	name: "LandingPage",
  computed: {
    user(){
      return this.$store.state.employees;
    }
  },
  components: {
    Footer
  },
	data() {
		return {
			todayAgendas: [],
      tomorrowAgendas: [],
      yesterdayAgendas: []
		};
	},

  mounted() {
		this.getAgendaToday();
    this.getAgendaTomorrow();
    this.getAgendaYesterday();
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

		getAgendaToday() {
			this.$axios.get("/agendas-today", {
			}).then(response  => {
				this.todayAgendas = response.data;
			})
      .catch(error => {
          console.error(error);
        });     
		},

    getAgendaTomorrow() {
			this.$axios.get("/agendas-tomorrow", {
			}).then(response  => {
				this.tomorrowAgendas  = response.data;
			})
      .catch(error => {
          console.error(error);
        });   
		},

    getAgendaYesterday() {
			this.$axios.get("/agendas-yesterday", {
			}).then(response  => {
				this.yesterdayAgendas = response.data;
			})
      .catch(error => {
          console.error(error);
        });    
		},
	},

	
};
</script>