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
              <div class="card-tools float-right">
                <div class="input-group input-group-sm">
                  <button type="submit" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalAgenda" @click.prevent="showModal">
                      Tambah
                  </button>
                </div> 
              </div>
              <div class="table-responsive">
                <table class="table" ref="content">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Judul Agenda</th>
                      <th>Tanggal</th>
                      <th>Waktu</th>
                      <th>Lokasi</th>
                      <th>Isi Agenda</th> 
                      <th>PenanggungJawab</th>
                      <th>Disposisi</th>
                      <th>Kategori</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(agenda, index) in agendas.data" :key="agenda.id">
                      <td>{{ index + 1}}</td>
                      <td>{{ agenda.title }}</td>
                      <td>{{ formatTanggal(agenda.date) }}</td>
                      <td>{{ formatWaktu(agenda.start_time) }} - {{ formatWaktu(agenda.end_time) }}</td>
                      <td>{{ agenda.location }}</td>
                      <td>{{ agenda.contents }}</td>
                      <td>{{ agenda.person_in_charge }}</td>
                      <td>{{ agenda.disposition }}</td>
                      <td>{{ agenda.category }}</td>
                      <td>
                        <button class="btn btn-sm btn-inverse-warning" @click.prevent="getAgendaDetails(agenda)">
                          <i class="mdi mdi-file-document-box-outline btn-icon-prepend"></i>
                        </button>
                      </td>
                    </tr>
                  </tbody>
                </table>
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

      <div class="modal fade" id="exampleModalAgenda" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelAgenda" aria-hidden="true"> 
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <!-- Show/hide headings dynamically based on /isFormCreateUserMode value (true/false) -->
              <h5 v-show="isFormCreateAgendaMode" class="modal-title" id="exampleModalLabel">Tambah Agenda</h5>
              <h5 v-show="!isFormCreateAgendaMode" class="modal-title" id="exampleModalLabel">Edit Agenda</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form @submit.prevent="createAgenda">
              <div class="modal-body">
                <div class="form-group">
                  <label for="date">Tanggal</label>
                  <input type="date" class="form-control" v-model="form.date" :class="{ 'is-invalid': form.errors.has('date') }" id="date" placeholder="Pilih Tanggal"/>
                </div>
                <div class="form-group">
                  <label for="start_time">Waktu Mulai</label>
                  <input type="time" class="form-control" v-model="form.start_time" :class="{ 'is-invalid': form.errors.has('start_time') }" id="start_time" placeholder="Waktu mulai"/>
                </div>
                <div class="form-group">
                  <label for="end_time">Waktu Selesai</label>
                  <input type="time" class="form-control"  v-model="form.end_time" :class="{ 'is-invalid': form.errors.has('end_time') }" id="end_time" placeholder="Waktu Selesai"/>
                </div>
                <div class="form-group">
                  <label for="title">Nama Agenda</label>
                  <input type="text" class="form-control" v-model="form.title" :class="{ 'is-invalid': form.errors.has('title') }" id="title" placeholder="Nama Agenda"/>
                </div>
                <div class="form-group">
                  <label for="category">Kategori</label>
                  <select class="form-control" id="category" v-model="form.category_id">
                    <option disabled value>Pilih Kategori</option>
                    <option v-for="category in categories.data" :key="category.id" :value="category.id">{{ category.name }}</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="room">Lokasi</label>
                    <select class="form-control" id="room" v-model="form.room_id">
                      <option disabled value>Pilih Ruangan</option>
                      <option v-for="room in rooms.data" :key="room.id" :value="room.id">{{ room.name }}</option>
                    </select>
                </div>
                <div class="form-group">
                  <label for="department">Disposisi</label>
                  <select class="form-control" id="disposisi" v-model="disposition">
                    <option disabled value>Pilih Disposisi</option>
                    <option value="1">Semua Pegawai</option>
                    <option value="departments">Department</option>
                    <option value="employees">Pegawai</option>
                    <option value="description">Input Pegawai</option>
                  </select>

                  <div v-if="disposition === '1'">
                    <select class="form-control" v-model="form.disposition_is_all">
                      <option value=1>Semua Pegawai</option>
                    </select>
                  </div>

                  <div v-else-if="disposition === 'departments'">
                    <select class="form-control" v-model="form.disposition_department">
                      <option disabled value>Pilih Department</option>
                      <option v-for="department in departments.data" :key="department.id" :value="department.id">{{ department.name }}</option>
                    </select>
                  </div>

                  <div v-else-if="disposition === 'employees'">
                    <select class="form-control" v-model="form.disposition_employee">
                      <option disabled value>Pilih Pegawai</option>
                      <option v-for="user in employees.data" :key="user.id" :value="user.id">{{ user.name }}</option>
                    </select>
                  </div>

                  <div v-else-if="disposition === 'description'">
                    <input type="text" class="form-control" v-model="form.disposition_description" placeholder="Masukkan Disposisi" />
                  </div>
                </div>
                <div class="form-group">
                  <label for="contents">Isi Agenda</label>
                  <input type="text" class="form-control" v-model="form.contents" :class="{ 'is-invalid': form.errors.has('contents') }" id="contents" placeholder="Isi Agenda" />
                </div>
                <div class="form-group">
                  <label for="person_in_charge">Penanggung Jawab</label>
                  <select class="form-control" id="person_in_charge" v-model="form.person_in_charge">
                    <option disabled value>Pilih PenanggungJawab</option>
                    <option v-for="employe in employees.data" :key="employe.id" :value="employe.id">{{ employe.name }}</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="departments">Department</label>
                  <select class="form-control" id="departments" v-model="form.department_id">
                    <option disabled value>Pilih Department</option>
                    <option v-for="department in departments.data" :key="department.id" :value="department.id">{{ department.name }}</option>
                  </select>
                </div>
                <div class="form-group">
                    <label for="attachment">File upload</label>
                    <input type="file" class="form-control file-upload-info" id="attachment" @change="onFileSelected">
                  </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batalkan</button>
                <button type="submit" class="btn btn-primary" v-show="isFormCreateAgendaMode">Simpan</button>
                <button type="submit" class="btn btn-primary" v-show="!isFormCreateAgendaMode">Update</button>
              </div>
            </form>
          </div>
        </div>
      </div>

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
  </div>
</template>

<script>
import { Form } from "vform";
import moment from "moment";
import swal from "sweetalert2";
export default {
	name: "AgendaBapenda",
	data() {
		return {
      isGenerateAgenda: true,
			editId: "",
      current_page: 1,
      per_page: 15,
      last_page: 0,
      totalItems: 0,
      search: "",
			agendas: {},
      rooms: {},
      employees: {},
      categories: {},
      departments: {},
      suggestions: {},
      form: new Form({
        id: "",
        department_id: "",
        category_id: 3,
        room_id: "",
        suggestion_id: "",
        title: "",
        date: "",
        start_time: "",
        end_time: "",
        contents: "",
        person_in_charge: "",
        location: null,
        attachment: null,
        disposition_employee: null,
        disposition_department: null,
        disposition_description: null,
        disposition_is_all: null,
      }),
      isFormCreateAgendaMode: true
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
      this.$axios.get("/download-agenda-excel", { 
        headers: {
          Authorization: "Bearer " + localStorage.getItem("access_token"),
        },
        responseType: "blob" 
      })
        .then(response => {
          const blob = new Blob([response.data], { type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" });
          const url = URL.createObjectURL(blob);
          const link = document.createElement("a");
          link.href = url;
          link.download = "agenda.xlsx";
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
      this.$axios.get("/generate-agenda-text", {
        headers: {
          Authorization: "Bearer " + localStorage.getItem("access_token"),
        },
      })
        .then(response  => {
          const textData = response.data;
          const link = document.createElement("a");
          link.href = "data:text/plain;charset=utf-8," + encodeURIComponent(textData);
          link.download = "agenda.txt";
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

    showModal() {
			this.isFormCreateAgendaMode = true;
			this.form.reset(); // v form reset
			$("#exampleModalAgenda").modal("show"); // show modal
		},

    getEmployee() {  
			this.$axios.get("/employees", {
        headers: {
          Authorization: "Bearer " + localStorage.getItem("access_token"),
        },
			}).then(data => {
				this.employees = data.data.data;
			});     
		},

    getDepartment() {
			this.$axios.get("/departments", {
        headers: {
          Authorization: "Bearer " + localStorage.getItem("access_token"),
        },
			}).then(data => {
				this.departments = data.data.data;
			});     
		},

    getRoom() {
			this.$axios.get("/rooms", {
        headers: {
          Authorization: "Bearer " + localStorage.getItem("access_token"),
        },
			}).then(data => {
				this.rooms = data.data.data;
			});     
		}, 
    getCategories() { 
			this.$axios.get("/categories", {
        headers: {
          Authorization: "Bearer " + localStorage.getItem("access_token"),
        },
			}).then(data => {
				this.categories = data.data.data;
			});     
		},

    getSuggestion() {
			this.$axios.get("/suggestions", {
        headers: {
          Authorization: "Bearer " + localStorage.getItem("access_token"),
        },
			}).then(data => {
				this.suggestions = data.data.data;
			});     
		},

    onFileSelected(event) {
        this.form.attachment = event.target.files[0];
    },

    createAgenda() {
      let formData = new FormData();
      formData.append("attachment", this.form.attachment);
			// request post
			this.form.post("/agendas", {
        headers: {
          Authorization: "Bearer " + localStorage.getItem("access_token"),
        },
			}).then(() => {
        $("#exampleModalAgenda").modal("hide");
				swal.fire({
					icon: "success",
					title: "Agenda berhasil ditambahkan"
              
				});
        this.getAgenda();
			}).catch((error) => {
				console.log(error.response); 
			});
		},

    onEdit(agenda){
			this.isFormCreateAgendaMode = false;
			this.form.reset(); // v form reset inputs
			this.form.clear(); // v form clear errors
			$("#exampleModalAgenda").modal("show"); // show modal
      // agenda.category_id = 3;
			this.form.fill(agenda);
      console.log("form: ", this.form);
      // console.log("categories: ", this.categories);
      console.log("agenda: ", agenda);
		},

		editAgenda(){
			// request put
			this.form.put("/agendas/" + this.form.id, {
        headers: {
          Authorization: "Bearer " + localStorage.getItem("access_token"),
        },
			}).then(() => {
				$("#exampleModalAgenda").modal("hide"); // hide modal
          
				// sweet alert 2
				swal.fire({
					icon: "success",
					title: "Agenda berhasil diubah"
				});

				this.getAgenda();

			}).catch(() => {
				console.log("transaction fail");
			});
		},

		deleteAgenda(id) {
			// sweet alert confirmation
			swal.fire({
				title: "Ingin menghapus data?",
				icon: "warning",
				showCancelButton: true,
				confirmButtonColor: "#3085d6",
				cancelButtonColor: "#d33",
				confirmButtonText: "Ya, hapus data"
			}).then((result) => {
				// confirm delete?
				if (result.value) {
					// request delete
					this.form.delete("/agendas/" + id, {
            headers: {
              Authorization: "Bearer " + localStorage.getItem("access_token"),
            },
					}).then(() => {
						// sweet alert success
						swal.fire(
							"Terhapus!",
							"Data Agenda berhasil dihapus",
							"success"
						);   

						this.getAgenda(); // reload table users
					}).catch(() => {
						// sweet alert fail
						swal.fire({
							icon: "error",
							title: "Oops...",
							text: "Something went wrong!",
							// footer: "<a href>Why do I have this issue?</a>"
						});
					}); 
				}
			});
		}

	},

	created() {
		this.getAgenda();
    this.getEmployee();
		this.getRoom();
		this.getDepartment();
    this.getCategories();
    this.getSuggestion();
	},
	mounted() {
		console.log("Component mounted.");
	}
};
</script>
