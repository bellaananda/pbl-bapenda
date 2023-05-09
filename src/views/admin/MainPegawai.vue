<template>
  <div class="main-panel">
    <div class="content-wrapper">
      <div class="row">
        <div class="col-md-12 grid-margin title">
          <div class="row">
            <div class="col-12 align-items-center">
              <h3 class="font-weight-bold">KELOLA PEGAWAI BAPENDA SURAKARTA</h3>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12 grid-margin">
          <div class="row">
            <div class="col-lg-5">
              <input type="text" placeholder="Search..." name="search" id="search" class="form-control">
            </div>
          </div>
        </div>
      </div> 
      <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Data Pegawai</h4>
                <div class="card-tools float-right">
                  <div class="input-group input-group-sm">
                    <button type="submit" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" @click.prevent="showModal">
                      <!-- <i class="mdi mdi-plus btn-icon-prepend"></i> -->
                      Tambah
                    </button>
                  </div> 
                </div>
                <div class="table-responsive">
                  <table class="table table-hover">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>NIP</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>No. Telp</th>
                        <th>Alamat</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Posisi</th>
                        <th>Department</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(employe, index) in employees.data" :key="employe.id">
                          <td>{{ index + 1}}</td>
                          <td>{{ employe.nip }}</td>
                          <td>{{ employe.name }}</td>
                          <td>{{ employe.email }}</td>
                          <td>{{ employe.phone_number }}</td>
                          <td>{{ employe.address }}</td>
                          <td>
                            {{ employe.role }}
                          </td>
                          <td>
                            <template v-if="employe.status === 1">
                              <span class="badge badge-success">Aktif</span>
                            </template>
                            <template v-else>
                              <span class="badge badge-danger">NonAktif</span>
                            </template>
                          </td>
                          <td>{{ employe.position }}</td>
                          <td>{{ employe.department }}</td>
                          <td>
                            <a href="" class="btn btn-sm btn-inverse-success" @click.prevent="onEdit(employe)">
                              <i class="mdi mdi-pencil btn-icon-prepend"></i>
                            </a>
                            <!-- <a href="#" class="btn btn-sm btn-inverse-warning" data-toggle="modal" data-target="#modalDetail">
                              <i class="mdi mdi-file-document-box-outline btn-icon-prepend"></i>
                            </a> -->
                            <a href="" class="btn btn-sm btn-inverse-danger" @click.prevent="deleteEmploye(employe.id)">
                              <i class="mdi mdi-delete btn-icon-prepend"></i>
                            </a>
                          </td>
                      </tr>
                    </tbody>
                  </table>
                  <b-pagination
                        v-model="currentPage"
                        :per-page="perPage"
                        :total-rows="rows"
                        align="center"
                        v-on:input="pagination">
                        </b-pagination>
                </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-6" align="center">
          <nav aria-label="Page navigation example" >
            <ul class="pagination" v-on:input="pagination">
              <li class="page-item">
                <a class="page-link" href="#" aria-label="Previous" >
                  <span aria-hidden="true">&laquo;</span>
                  <span class="sr-only">Previous</span>
                </a>
              </li>
              <li class="page-item"><a class="page-link" href="#">1</a></li>
              <li class="page-item"><a class="page-link" href="#">2</a></li>
              <li class="page-item"><a class="page-link" href="#">3</a></li>
              <li class="page-item">
                <a class="page-link" href="#" aria-label="Next">
                  <span aria-hidden="true">&raquo;</span>
                  <span class="sr-only">Next</span>
                </a>
              </li>
            </ul>
          </nav>
        </div>
        <!-- <div class="col-6 col-xl-4">
            <table id="table_filters">
              <tr id="row_special">
                <td class="exp">
                  <label>Records per Page:</label>
                  <select id="records_comboBox">
                    <option id="any" value="any">Any</option>
                    <option id="10" value="10">10</option>
                    <option id="25" value="25">25</option>
                    <option id="50" value="50">50</option>
                  </select>
                </td>
              </tr>
            </table>   
        </div>  -->
      </div>

      <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"> 
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <!-- Show/hide headings dynamically based on /isFormCreateUserMode value (true/false) -->
              <h5 v-show="isFormCreateEmployeMode" class="modal-title" id="exampleModalLabel">Tambah Pegawai</h5>
              <h5 v-show="!isFormCreateEmployeMode" class="modal-title" id="exampleModalLabel">Edit Pegawai</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <!-- Form for adding/updating user details. When submitted call /createUser() function if /isFormCreateUserMode value is true. Otherwise call /updateUser() function. -->
            <form @submit.prevent="isFormCreateEmployeMode ? createEmployee() : editEmployee()">
              <div class="modal-body">
                <div class="form-group">
                  <label for="nip">NIP</label>
                  <input type="text" class="form-control" v-model="form.nip" :class="{ 'is-invalid': form.errors.has('nip') }" id="nip" placeholder="Masukkan NIP Pegawai">
                  <!-- <has-error :form="form" field="nip"></has-error> -->
                </div>
                <div class="form-group">
                  <label for="name">Nama Pegawai</label>
                  <input type="text" class="form-control" v-model="form.name" :class="{ 'is-invalid': form.errors.has('name') }" id="name" placeholder="Masukkan Nama Pegawai">
                  <!-- <has-error :form="form" field="name"></has-error> -->
                </div>
                <div class="form-group">
                  <label for="email">Email</label>
                  <input type="text" class="form-control" v-model="form.email" :class="{ 'is-invalid': form.errors.has('email') }" id="email" placeholder="Masukkan Email Pegawai">
                  <!-- <has-error :form="form" field="email"></has-error> -->
                </div>
                <div class="form-group">
                  <label for="phone_number">No. Telepon</label>
                  <input type="text" class="form-control" v-model="form.phone_number" :class="{ 'is-invalid': form.errors.has('phone_number') }" id="phone_number" placeholder="Masukkan Nomor Telepon Pegawai">
                  <!-- <has-error :form="form" field="phone_number"></has-error> -->
                </div>
                <div class="form-group">
                  <label for="address">Alamat</label>
                  <input type="text" class="form-control" v-model="form.address" :class="{ 'is-invalid': form.errors.has('address') }" id="address" placeholder="Masukkan Alamat Pegawai">
                  <!-- <has-error :form="form" field="address"></has-error> -->
                </div>
                <div v-show="!isFormCreateEmployeMode" class="form-group">
                  <label for="role">Role</label>
                  <select class="form-control" id="role" v-model="form.role">
                    <option disabled value="">Pilih Role Pegawai</option>
                    <option value="1" checked>User</option>  
                    <option value="2">Operator</option>
                  </select>
                  <!-- <has-error :form="form" field="role"></has-error> -->
                </div>
                <div v-show="!isFormCreateEmployeMode" class="form-group">
                  <label for="status">Status Pegawai</label>
                  <select class="form-control" id="status" v-model="form.status">
                    <option disabled value="">Pilih Status Pegawai</option>
                    <option value="1" checked>Aktif</option>
                    <option value="2">NonAktif</option>
                  </select>
                  <!-- <has-error :form="form" field="status"></has-error> -->
                </div>
                <div class="form-group">
                  <label for="position">Posisi Pegawai</label>
                  <select class="form-control" id="position" v-model="form.position_id">
                    <option disabled value>Pilih Posisi Pegawai</option>
                    <option v-for="position in positions.data" :key="position.id" :value="position.id">{{ position.name }}</option>
                  </select>
                  <!-- <has-error :form="form" field="position"></has-error> -->
                </div>
                <div class="form-group">
                  <label for="department">Department Pegawai</label>
                  <select class="form-control" id="department" v-model="form.department_id">
                    <option disabled value>Pilih Department Pegawai</option>
                    <option v-for="department in departments.data" :key="department.id" :value="department.id">{{ department.name }}</option>
                  </select>
                  <!-- <has-error :form="form" field="department"></has-error> -->
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batalkan</button>
                <button type="submit" class="btn btn-primary" v-show="isFormCreateEmployeMode">Simpan</button>
                <button type="submit" class="btn btn-primary" v-show="!isFormCreateEmployeMode">Update</button>
              </div>
            </form>
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

export default {
	name: "PegawaiBapenda", 
	data() {
		return {
			employees: {},
			positions:{},
			departments:{},
      search: "",
      currentPage: 1,
      rows: 0,
      perPage: 15,
			form: new Form({
				id: "",
				nip: "",
				name: "",
				email: "",
        password:"",
				phone_number: "",
				address: "",
				role:"",
				status:"",
				position_id: "",
				department_id:"",
			}),
			isFormCreateEmployeMode: true
		};
	},

	methods: {

		getEmployee(currentPage) {
      // let offset = (this.currentPage - 1) * this.perPage;
			axios.get("https://v3421024.mhs.d3tiuns.com/api/employees/?pages= " + currentPage, {
			}).then(data => {
				this.employees = data.data.data;
			});     
		},

    pagination : function(){
      if(this.search == ""){
        this.getEmployee();
      } else {
        this.searching();
      }
    },

		showModal() {
			this.isFormCreateEmployeMode = true;
			this.form.reset(); // v form reset
			$("#exampleModal").modal("show"); // show modal
		},

		getPosition() {
			axios.get("https://v3421024.mhs.d3tiuns.com/api/positions", {
			}).then(data => {
				this.positions = data.data.data;
			});     
		},

		getDepartment() {
			axios.get("https://v3421024.mhs.d3tiuns.com/api/departments", {
			}).then(data => {
				this.departments = data.data.data;
			});     
		},

		createEmployee() {
			// request post
			this.form.post("https://v3421024.mhs.d3tiuns.com/api/employees", {
			}).then(() => {
				$("#exampleModal").modal("hide");
				swal.fire({
					icon: "success",
					title: "Pegawai berhasil ditambahkan"
              
				});
				this.getEmployee();
				// this.getPosition();
				// this.getDepartment();
			}).catch(() => {
				console.log("transaction fail"); 
			});
		},

		onEdit(employe){
			this.isFormCreateEmployeMode = false;
			this.form.reset(); // v form reset inputs
			this.form.clear(); // v form clear errors
			$("#exampleModal").modal("show"); // show modal
			this.form.fill(employe);
		},

		editEmployee(){
			// request put
			this.form.put("https://v3421024.mhs.d3tiuns.com/api/employees/" + this.form.id, {
			}).then(() => {
				$("#exampleModal").modal("hide"); // hide modal
          
				// sweet alert 2
				swal.fire({
					icon: "success",
					title: "Pegawai berhasil diubah"
				});

				this.getEmployee();

			}).catch(() => {
				console.log("transaction fail");
			});
		},

		deleteEmploye(id) {
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
					this.form.delete("https://v3421024.mhs.d3tiuns.com/api/employees/" + id, {
					}).then(() => {
						// sweet alert success
						swal.fire(
							"Terhapus!",
							"Data Pegawai berhasil dihapus",
							"success"
						);   

						this.getEmployee(); // reload table users
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
		this.getEmployee();
		this.getPosition();
		this.getDepartment();
	},
	mounted() {
		console.log("Component mounted.");
	}
};
</script>