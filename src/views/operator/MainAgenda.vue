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
          <div class="card">
            <div class="card-body">
              <div class="card-tools float-right">
                <div class="input-group input-group-sm">
                  <button type="submit" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalAgenda" @click.prevent="showModal">
                      <!-- <i class="mdi mdi-plus btn-icon-prepend"></i> -->
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
                      <!-- <th>Lokasi</th> -->
                      <th>Isi Agenda</th> 
                      <!-- <th>Attachment</th> -->
                      <th>PenanggungJawab</th>
                      <th>Disposisi</th>
                      <th>Kategori</th>
                      <th>Ruangan</th>
                      <!-- <th>Suggestion</th> -->
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(agenda, index) in agendas.data" :key="agenda.id">
                      <td>{{ index + 1}}</td>
                      <td>{{ agenda.title }}</td>
                      <td>{{ agenda.date }}</td>
                      <td>{{ agenda.start_time }} - {{ agenda.end_time }}</td>
                      <!-- <td>{{ agenda.location }}</td> -->
                      <td>{{ agenda.contents }}</td>
                      <!-- <td>{{ agenda.attachment }}</td> -->
                      <td>{{ agenda.person_in_charge }}</td>
                      <td>{{ agenda.department }}</td>
                      <td>{{ agenda.category }}</td>
                      <td>{{ agenda.room }}</td>
                      <!-- <td>{{ agenda.suggestion }}</td> -->
                      <td>
                        <a href="" class="btn btn-sm btn-inverse-success" @click.prevent="onEdit(agenda)">
                          <i class="mdi mdi-pencil btn-icon-prepend"></i>
                        </a>
                        <a href="#" class="btn btn-sm btn-inverse-warning" data-toggle="modal" data-target="#exampleModalDetail">
                          <i class="mdi mdi-file-document-box-outline btn-icon-prepend"></i>
                        </a>
                        <a href="" class="btn btn-sm btn-inverse-danger" @click.prevent="deleteAgenda(agenda.id)">
                          <i class="mdi mdi-delete btn-icon-prepend"></i>
                        </a>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12 grid-margin">
          <div class="row">
            <div class="col-3 button-generate">
              <button type="button" class="btn btn-primary btn-lg btn-block" data-toggle="modal" data-target="#exampleModal">
                <i class="ti-printer"></i>                      
                  Report Agenda
              </button>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"> 
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 v-show="isGenerateAgenda" class="modal-title" id="exampleModalLabel">Generate Agenda</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="template-demo">
                <button type="button" class="btn btn-primary btn-icon-text">
                  <i class="ti-file btn-icon-prepend"></i>
                    Word
                </button>
                <button type="button" class="btn btn-success btn-icon-text">
                  Excel
                  <i class="ti-file btn-icon-prepend"></i>                                                    
                </button>                
                <button type="button" class="btn btn-danger btn-icon-text"  @click="download()">
                  <i class="ti-file btn-icon-prepend"></i>                                                    
                  PDF
                </button>
              </div>
              <div class="template-demo">
                <button type="button" class="btn btn-warning btn-icon-text">
                  Text
                  <i class="ti-file btn-icon-prepend"></i>                                                    
                </button>
                <button type="button" class="btn btn-info btn-icon-text">
                  Print
                  <i class="ti-printer btn-icon-append"></i>                                                                              
                </button>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Batalkan</button>
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
                  <select class="form-control" id="disposisi" v-model="disposition_is_all">
                    <option disabled value>Pilih Disposisi</option>
                    <option value="1">Semua Pegawai</option>
                    <option value="departments">Department</option>
                    <option value="employees">Pegawai</option>
                    <option value="description">Input Pegawai</option>
                  </select>

                  <select class="form-control" v-if="disposition_is_all === 'departments'" v-model="disposition_department">
                    <option disabled value>Pilih Department</option>
                    <option v-for="department in departments.data" :key="department.id" :value="department.id">{{ department.name }}</option>
                  </select>

                  <select class="form-control" v-else-if="disposition_is_all === 'employees'" v-model="disposition_employee">
                    <option disabled value>Pilih Pegawai</option>
                    <option v-for="user in employees.data" :key="user.id" :value="user.id">{{ user.name }}</option>
                  </select>

                  <div v-else-if="disposition_is_all === 'description'">
                    <input type="text" class="form-control" v-model="disposition_description" placeholder="Masukkan Disposisi" />
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

      <div class="modal fade" id="exampleModalDetail" tabindex="-1" role="dialog" aria-labelledby="exampleModalDetail" aria-hidden="true">
        <div class="modal-dialog" role="document">
           <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body table-responsive">
        <table class="table table-bordered no-margin">
          <tbody v-for="agenda in agendas.data" :key="agenda.id">
            <tr>
              <th>Judul Agenda</th>
              <td><span id="title">{{ agenda.title }}</span></td>
            </tr>
            <tr>
              <th>Tanggal</th>
              <td><span id="date">{{ agenda.date }}</span></td>
            </tr>
            <tr>
              <th>Waktu</th>
              <td><span id="time">{{ agenda.start_time }} - {{ agenda.end_time }}</span></td>
            </tr>
            <tr>
              <th>Isi Agenda</th>
              <td><span id="contents">{{ agenda.contents }}</span></td>
            </tr>
            <tr>
              <th>Disposisi</th>
              <td><span id="department">{{ agenda.department }}</span></td>
            </tr>
            <tr>
              <th>PenanggungJawab</th>
              <td><span id="person_in_charge">{{ agenda.person_in_charge }}</span></td>
            </tr>
            <tr>
              <th>Kategori</th>
              <td><span id="category">{{ agenda.category }}</span></td>
            </tr>
            <tr>
              <th>Ruangan</th>
              <td><span id="room">{{ agenda.room }}</span></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
      </div>
      
    </div>
  </div>
</template>

<script>
import { Form } from "vform";
import axios from "axios";
import swal from "sweetalert2";
import jspdf from "jspdf";
export default {
	name: "AgendaBapenda",
	data() {
		return {
      isGenerateAgenda: true,
			editId: "",
      disposition_employee: null,
      disposition_department: null,
      disposition_description: null,
      disposition_is_all: null,
			agendas: {},
      rooms: {},
      employees: {},
      categories: {},
      departments: {},
      suggestions: {},
      form: new Form({
        id: "",
        department_id: "",
        category_id: "",
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
      }),
      isFormCreateAgendaMode: true
		};
	},

	methods: {

    download(){
      const doc = new jspdf();

      const html = this.$refs.content.innerHTML;

      doc.html(html, {
        callback: function (doc) {
          doc.save();
        },
        x: 10,
        y: 10
      });

      // doc.save("agenda.pdf");
      
    },

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

    Detail(id){
      axios.get("https://api.klikagenda.com/api/agendas/" + id ,{
			}).then(data => {
				this.agendas = data.data.data;
			}); 
         
    },

    showModal() {
			this.isFormCreateAgendaMode = true;
			this.form.reset(); // v form reset
			$("#exampleModalAgenda").modal("show"); // show modal
		},

    getEmployee() {  
			axios.get("https://api.klikagenda.com/api/employees", {
			}).then(data => {
				this.employees = data.data.data;
			});     
		},

    getDepartment() {
			axios.get("https://api.klikagenda.com/api/departments", {
			}).then(data => {
				this.departments = data.data.data;
			});     
		},

    getRoom() {
			axios.get("https://api.klikagenda.com/api/rooms", {
			}).then(data => {
				this.rooms = data.data.data;
			});     
		},

    getCategories() {
			axios.get("https://api.klikagenda.com/api/categories", {
			}).then(data => {
				this.categories = data.data.data;
			});     
		},

    getSuggestion() {
			axios.get("https://api.klikagenda.com/api/suggestions", {
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
			this.form.post("https://api.klikagenda.com/api/agendas", {
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
			this.form.fill(agenda);
		},

		editAgenda(){
			// request put
			this.form.put("https://api.klikagenda.com/api/agendas/" + this.form.id, {
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
					this.form.delete("https://api.klikagenda.com/api/agendas/" + id, {
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
