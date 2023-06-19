<template>
  <div class="content-wrapper">
    <div class="row">
      <div class="col-12 grid-margin">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Form Ajukan Agenda</h4>
              <form class="form-sample" @submit.prevent="createSuggestion">
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

                          <div v-if="form.room_id === 2">
                            <input type="text" class="form-control" v-model="form.location" placeholder="Masukkan Lokasi Agenda" />
                          </div>
                          <div v-else-if="form.room_id === 1">
                            <input type="text" class="form-control" v-model="form.location" placeholder="Masukkan Link" />
                          </div>

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
                          <textarea type="text" class="form-control" v-model="form.contents" :class="{ 'is-invalid': form.errors.has('contents') }" id="contents" placeholder="Isi Agenda"></textarea>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label" for="person_in_charge">Penanggungjawab</label>
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
                        <label class="col-sm-3 col-form-label">Bidang</label>
                        <div class="col-sm-9">
                          <select class="form-control" id="department" v-model="form.department_id">
                            <option disabled value>Pilih Bidang</option>
                            <option v-for="department in departments.data" :key="department.id" :value="department.id">{{ department.name }}</option>
                          </select>
                        </div> 
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Disposisi</label>
                        <div class="col-sm-9">
                          <textarea type="text" class="form-control" v-model="form.disposition_description" placeholder="Masukkan Disposisi"></textarea>
                        </div> 
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">File upload</label>
                        <div class="col-sm-9">
                          <input type="file" class="form-control file-upload-info" id="attachment" @change="onFileSelected">
                          <label class="form-label" style="color: darkgray;">.docs/pdf/jpg</label>
                        </div>
                      </div>
                    </div>
                  </div>
                  <button type="submit" class="btn btn-primary mr-2">Ajukan</button>
                </form> 
                </div>
              </div>
            </div>
          </div>
          <Footer/>
        </div>
        <!-- content-wrapper ends --> 
</template>

<script>
import { Form } from "vform";
import swal from "sweetalert2";
import Footer from "../../components/TheFooter.vue";

export default {
  name: "PengajuanAgenda",
  components: {
    Footer
  },
  data() {
    return {
      rooms: {},
      employees: {},
      categories: {},
      departments: {},
      disposition: null,
      // suggestion_dispositions:"",
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
        // disposition_employee: null,
        // disposition_department: null,
        disposition_description: null,
        // disposition_is_all: null,
        // disposition: null,
      }),
    };
  },

  methods: {

    upload(e){
      this.attachment = e.target.files[0];
    },

    getEmployee() {  
			this.$axios.get("/employees")
      .then(response => {
				this.employees = response.data;
			});     
		},

    getDepartment() {
			this.$axios.get("/departments")
      .then(response => {
				this.departments = response.data;
			});     
		},

    getRoom() {
			this.$axios.get("/rooms")
      .then(response => {
				this.rooms = response.data;
			});     
		},

    getCategories() {
			this.$axios.get("/categories")
      .then(response => {
				this.categories = response.data;
			});     
		},

    onFileSelected(event) {
        this.form.attachment = event.target.files[0];
    },

    createSuggestion() {
			// request post
			this.form.post("https://api.klikagenda.com/api/suggestions", {
        headers: {
          Authorization: "Bearer " + localStorage.getItem("access_token"),
        },
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