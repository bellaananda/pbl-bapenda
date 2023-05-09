<template>
        <div class="content-wrapper">
          <div class="row">
            <div class="col-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Form Ajukan Agenda</h4>
                  <form class="form-sample" @submit.prevent="createSuggestion">
                  <!-- <p class="card-description" style="margin-bottom: 60px">
                  </p> -->
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group row">
                        <label for="date" class="col-sm-3 col-form-label">Tanggal</label>
                        <div class="col-sm-9">
                          <input type="date" class="form-control" v-model="form.date" :class="{ 'is-invalid': form.errors.has('date') }" id="date" placeholder="Pilih Tanggal"/>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label" for="start_time">Waktu Mulai</label>
                        <div class="col-sm-9">
                          <input type="time" class="form-control" v-model="form.start_time" :class="{ 'is-invalid': form.errors.has('start_time') }" id="start_time" placeholder="Waktu mulai"/>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label" for="room">Lokasi</label>
                        <div class="col-sm-9">
                          <select class="form-control" id="room" v-model="form.room_id">
                            <option disabled value>Pilih Ruangan</option>
                            <option v-for="room in rooms.data" :key="room.id" :value="room.id">{{ room.name }}</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label" for="end_time">Waktu Selesai</label>
                        <div class="col-sm-9">
                          <input type="time" class="form-control"  v-model="form.end_time" :class="{ 'is-invalid': form.errors.has('end_time') }" id="end_time" placeholder="Waktu Selesai"/>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label" for="title">Nama Agenda</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" v-model="form.title" :class="{ 'is-invalid': form.errors.has('title') }" id="title" placeholder="Nama Agenda"/>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label" for="category">Kategori</label>
                        <div class="col-sm-9">
                          <select class="form-control" id="category" v-model="form.category_id">
                            <option disabled value>Pilih Kategori</option>
                            <option v-for="category in categories.data" :key="category.id" :value="category.id">{{ category.name }}</option>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label" for="contents">Isi Agenda</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" v-model="form.contents" :class="{ 'is-invalid': form.errors.has('contents') }" id="contents" placeholder="Isi Agenda" />
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label" for="person_in_charge">Penanggung Jawab</label>
                        <div class="col-sm-9">
                          <select class="form-control" id="person_in_charge" v-model="form.person_in_charge">
                            <option disabled value>Pilih PenanggungJawab</option>
                            <option v-for="employe in employees.data" :key="employe.id" :value="employe.id">{{ employe.name }}</option>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">User Login</label>
                        <div class="col-sm-9">
                          <select class="form-control" id="disposisi" v-model="form.user_id">
                            <option disabled value>pilih user</option>
                            <option v-for="user in employees.data" :key="user.id" :value="user.id">{{ user.name }}</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Disposisi</label>
                        <div class="col-sm-9">
                          <select class="form-control" id="disposisi" v-model="form.department_id">
                            <option disabled value>Pilih Disposisi</option>
                            <option v-for="department in departments.data" :key="department.id" :value="department.id">{{ department.name }}</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">File upload</label>
                        <div class="col-sm-9">
                          <!-- <input type="file"  name="attachment[]" class="form-control" @change="upload"> -->
                          <div class="input-group col-xs-12">
                            <input type="file" class="form-control file-upload-info"  v-on:change="upload"  placeholder="Upload file">
                            <span class="input-group-append">
                              <button class="file-upload-browse btn btn-primary" type="button"> Upload </button>
                            </span> 
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <button type="submit" class="btn btn-primary mr-2">Ajukan</button>
                    <!-- <button class="btn btn-light">Batalkan</button> -->
                </form> 
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends --> 
</template>

<script>
import { Form } from "vform";
import axios from "axios";
import swal from "sweetalert2";

export default {
  name: "PengajuanAgenda",
  data() {
    return {
      rooms: {},
      employees: {},
      categories: {},
      departments: {},
      form: new Form({
        id: "",
        user_id: "",
        department_id: "",
        category_id: "",
        room_id: "",
        title: "",
        date: "",
        start_time: "",
        end_time: "",
        contents: "",
        person_in_charge: "",
        location: "",
        attachment: "",
        status: "",
      }),
    };
  },

  methods: {

    upload(e){
      this.attachment = e.target.files[0];
    },

    getEmployee() {  
			axios.get("https://v3421024.mhs.d3tiuns.com/api/employees", {
			}).then(data => {
				this.employees = data.data.data;
			});     
		},

    getDepartment() {
			axios.get("https://v3421024.mhs.d3tiuns.com/api/departments", {
			}).then(data => {
				this.departments = data.data.data;
			});     
		},

    getRoom() {
			axios.get("https://v3421024.mhs.d3tiuns.com/api/rooms", {
			}).then(data => {
				this.rooms = data.data.data;
			});     
		},

    getCategories() {
			axios.get("https://v3421024.mhs.d3tiuns.com/api/categories", {
			}).then(data => {
				this.categories = data.data.data;
			});     
		},

    createSuggestion() {
			// request post
			this.form.post("https://v3421024.mhs.d3tiuns.com/api/suggestions", {
			}).then(() => {
				swal.fire({
					icon: "success",
					title: "Agenda berhasil ditambahkan"
              
				});
        this.$router.push("/history-user");
				// router.push({ path: "/history-user" });
			}).catch((error) => {
				console.log(error.response); 
			});
		},
  },

  created() {
		this.getEmployee();
		this.getRoom();
		this.getDepartment();
    this.getCategories();
	},
	mounted() {
		console.log("Component mounted.");
	}

};

</script>