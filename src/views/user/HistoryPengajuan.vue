<template>
  <div class="main-panel">
    <div class="content-wrapper">
      <div class="row">
        <div class="col-md-12 grid-margin title">
          <div class="row">
            <div class="col-12 align-items-center">
              <h3 class="font-weight-bold">HISTORY PENGAJUAN AGENDA</h3>
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
              <div class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Judul Agenda</th>
                      <th>Tanggal</th>
                      <th>Waktu</th>
                      <th>PenanggungJawab</th>
                      <th>Disposisi</th>
                      <th>Status</th> 
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(suggestion, index) in suggestions.data" :key="suggestion.id">
                      <td>{{ index + 1}}</td>
                      <td>{{ suggestion.title }}</td>
                      <td>{{ formatTanggal(suggestion.date) }}</td>
                      <td>{{ formatWaktu(suggestion.start_time) }} - {{ formatWaktu(suggestion.end_time) }}</td>
                      <td>{{ suggestion.person_in_charge }}</td>
                      <td>{{ suggestion.disposition }}</td>
                      <td>
                        <template v-if="suggestion.status === 'Diterima'">
                          <span class="badge badge-success">Diterima</span>
                        </template>
                        <template v-else-if="suggestion.status === 'Diproses'">
                          <span class="badge badge-warning">Diproses</span>
                        </template>
                        <template v-else>
                          <span class="badge badge-danger">Ditolak</span>
                        </template>
                      </td>
                      <td>
                          <button class="btn btn-sm btn-inverse-warning" @click.prevent="getSuggestionDetails(suggestion)">
                            <i class="mdi mdi-file-document-box-outline btn-icon-prepend"></i>
                          </button>
                        </td>
                      <template v-if="suggestion.status === 'Ditolak'">
                        <td>
                          <a href="" class="btn btn-sm btn-inverse-success" @click.prevent="onEdit(suggestion)">
                            <i class="mdi mdi-pencil btn-icon-prepend"></i>
                          </a>
                        </td>
                      </template>
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
                  @click="getHistory(current_page - 1)"
                >
                  Previous
                </button>
                <span>Page {{ current_page }} of {{ last_page }}</span>
                <button
                  type="button"
                  class="btn btn-primary"
                  
                  @click="getHistory(current_page + 1)"
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
import Footer from "../../components/TheFooter.vue";
import moment from "moment";
import { Form } from "vform";
export default {
	name: "HistoryPengajuan",
  components: {
    Footer
  },
	data() {
		return {
			editId: "",
      current_page: 1,
      per_page: 15,
      last_page: 0,
      totalItems: 0,
      search: "",
			suggestions: [],
      rooms: {},
      employees: {},
      categories: {},
      departments: {},
      disposition: null,
      form: new Form({
        id: "",
        user_id: 3,
        department_id: "",
        category_id: "",
        room_id: "",
        title: "",
        date: "",
        start_time: "",
        end_time: "",
        contents: "",
        person_in_charge: 3,
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

  mounted() {
		this.getHistory();
    this.getRoom();
    this.getEmployee();
    this.getCategories();
    this.getDepartment();
	},

	methods: {
    searchAgenda() {
      this.current_page = 1; // Reset halaman saat melakukan pencarian
      this.getHistory();
    },

    formatTanggal(date) {
      moment.locale("id");
      return moment(date).format("DD MMMM YYYY");
    },

    formatWaktu(time) {
      return moment(time, "HH:mm").format("HH:mm");
    },

		getHistory(page = 1) {
			this.$axios.get("/suggestions", {
        params: {
        page: page,
        search: this.search,
      },
      })
      .then(response => {
				this.suggestions = response.data.data;
        this.current_page = response.data.data.current_page;
        this.last_page = response.data.data.last_page;
        this.totalItems = response.data.data.total;
			})
      .catch(error => {
        console.error(error);
      });    
		}, 

    getEmployee() {  
			this.$axios.get("/employees")
      .then(data => {
				this.employees = data.data.data;
			})
      .catch(error => {
        console.error(error);
      });      
		},

    getDepartment() {
			this.$axios.get("/departments")
      .then(data => {
				this.departments = data.data.data;
			})
      .catch(error => {
        console.error(error);
      });      
		},

    getRoom() {
			this.$axios.get("/rooms")
      .then(data => {
				this.rooms = data.data.data;
			})
      .catch(error => {
        console.error(error);
      });      
		},

    getCategories() {
			this.$axios.get("/categories")
      .then(data => {
				this.categories = data.data.data;
			})
      .catch(error => {
        console.error(error);
      });     
		},

    getSuggestionDetails(suggestion) {
      const suggestionId = suggestion.id;
      this.$axios.get(`/suggestions/${suggestionId}`)
        .then(() => {
          // const suggestionDetails = response.data;
          this.form.fill(suggestion);
          $("#exampleModalDetail").modal("show");
        })
        .catch(error => {
          console.error(error);
        });
    },
	},

};
</script>