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
        <div class="col-md-6">
          <div class="form-group">
            <input type="text" class="form-control" v-model="search" placeholder="Cari agenda...">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <button type="button" class="btn btn-primary" @click="searchAgenda">Cari</button>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <div class="template-demo">
                <button type="button" class="btn btn-success btn-icon-text" @click="generateAgendaExcel">
                  Excel
                  <i class="btn-icon-prepend"></i>                                                    
                </button>                
                <button type="button" class="btn btn-warning btn-icon-text" @click="generateAgendaText">
                  Text
                  <i class="btn-icon-prepend"></i>                                                    
                </button>
              </div>
              <div class="table-responsive">
                <table class="table" ref="content">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Judul Agenda</th>
                      <th>Tanggal</th>
                      <th>Waktu</th>
                      <th>Disposisi</th>
                      <th>Ruangan</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(agenda, index) in agendas.data" :key="agenda.id">
                      <td>{{ index + 1}}</td>
                      <td>{{ agenda.title }}</td>
                      <td>{{ formatTanggal(agenda.date) }}</td>
                      <td>{{ formatWaktu(agenda.start_time) }} - {{ formatWaktu(agenda.end_time) }}</td>
                      <td>{{ agenda.person_in_charge }}</td>
                      <td>{{ agenda.location }}</td>
                      <td>
                        <button class="btn btn-sm btn-inverse-warning" @click.prevent="getAgendaDetails(agenda)">
                          <i class="mdi mdi-file-document-box-outline btn-icon-prepend"></i>
                        </button>
                      </td>
                    </tr>
                  </tbody>
                </table> 

                <div class="modal fade" id="exampleModalDetail" tabindex="-1" role="dialog" aria-labelledby="exampleModalDetailLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalDetailLabel">Detail Agenda</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                      </div>
                      <div class="modal-body">
                        <h5>Judul Agenda: {{ form.title }}</h5>
                        <p>Tanggal: {{ formatTanggal(form.date) }}</p>
                        <p>Waktu: {{ formatWaktu(form.start_time) }} - {{ formatWaktu(form.end_time) }}</p>
                        <p>Penanggung Jawab: {{ form.person_in_charge }}</p>
                        <p>Isi Agenda: {{ form.contents }}</p>
                        <p>Lokasi: {{ form.location }}</p>
                        <p>Disposisi: {{ form.disposition_employee }} {{ form.disposition_department }} {{ form.disposition_description }} {{ form.disposition_is_all }} {{ disposition }}</p>
                        <p>Attachment: {{ form.attachment }}</p>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                      </div>
                    </div>
                  </div>
                </div>

              </div>
              <div class="template-demo">
                <button
                  type="button"
                  class="btn btn-primary"
                  :disabled="current_page === 1"
                  @click="getAgenda(current_page - 1)"
                >
                  Previous
                </button>
                <span>Page {{ current_page }} of {{ last_page }}</span>
                <button
                  type="button"
                  class="btn btn-primary"
                  
                  @click="getAgenda(current_page + 1)"
                >
                  Next
                </button>
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
import { Form } from "vform";
import Footer from "../../components/TheFooter.vue";
export default {
	name: "AgendaBapenda",
  components: {
    Footer
  },
	data() {
		return {
      isGenerateAgenda: true,
			agendas: {},
      current_page: 1,
      per_page: 15,
      last_page: 0,
      totalItems: 0,
      search: "",
      form: new Form({
        id: "",
        // user_id: 3,
        department_id: "",
        category_id: "",
        room_id: "",
        title: "",
        date: "",
        start_time: "",
        end_time: "",
        contents: "",
        person_in_charge: "",
        location: null,
        attachment: null,
        status: "",
        disposition_employee: null,
        disposition_department: null,
        disposition_description: null,
        disposition_is_all: null,
        
      }),
		};
	},

	methods: {
    searchAgenda() {
      this.current_page = 1; // Reset halaman saat melakukan pencarian
      this.getAgenda();
    },

    formatTanggal(date) {
      moment.locale("id");
      return moment(date).format("DD MMMM YYYY");
    },

    formatWaktu(time) {
      return moment(time, "HH:mm").format("HH:mm");
    },

    generateAgendaExcel(){
      this.$axios.get("https://api.klikagenda.com/api/download-agenda-excel", { 
        responseType: "blob" 
      })
        .then(response => {
          const blob = new Blob([response.data], { type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" });
          const url = URL.createObjectURL(blob);
          const link = document.createElement("a");
          link.href = url;
          link.download = "export.xlsx";
          link.style.display = "none";
          document.body.appendChild(link);
          link.click();
          document.body.removeChild(link);
          URL.revokeObjectURL(url);
        })
        .catch(error => {
          console.error("Failed to export Excel", error);
        });
    },

    generateAgendaText(){
      this.$axios.get("https://api.klikagenda.com/api/generate-agenda-text")
        .then(response  => {
          const textData = response.data;
          const link = document.createElement("a");
          link.href = "data:text/plain;charset=utf-8," + encodeURIComponent(textData);
          link.download = "export.txt";
          link.style.display = "none";

          // Menambahkan elemen <a> ke DOM dan mengkliknya untuk memulai unduhan
          document.body.appendChild(link);
          link.click();
          document.body.removeChild(link);
        })
        .catch(error => {
          // Tangani kesalahan jika ada
          console.error("Failed to copy agenda", error);
        });
    },

		getAgenda(page = 1) {
			this.$axios.get("https://api.klikagenda.com/api/agendas", {
        params: {
        page: page,
        search: this.search,
      },
      })
      .then(response => {
				this.agendas = response.data.data;
        this.current_page = response.data.data.current_page;
        // console.log(response);
        this.last_page = response.data.data.last_page;
        this.totalItems = response.data.data.total;
			})
      .catch((error) => {
        console.error("Failed to fetch agendas", error);
      });     
		},

    getAgendaDetails(agenda) {
      const agendaId = agenda.id;
      this.$axios.get(`/agendas/${agendaId}`)
        .then(() => {
          // const suggestionDetails = response.data;
          this.form.fill(agenda);
          $("#exampleModalDetail").modal("show");
        })
        .catch(error => {
          console.error(error);
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