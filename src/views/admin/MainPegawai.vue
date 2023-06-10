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
            <!-- <div class="col-lg-5">
              <input type="text" placeholder="Search..." name="search" id="search" class="form-control">
            </div> -->
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
                        <th>No. Telp</th>
                        <!-- <th>Role</th> -->
                        <th>Status</th>
                        <th>Posisi</th>
                        <th></th>
                      </tr>
                    </thead> 
                    <tbody>
                      <tr v-for="(employe, index) in employees.data" :key="employe.id">
                          <td>{{ index + 1}}</td>
                          <td>{{ employe.nip }}</td>
                          <td>{{ employe.name }}</td>
                          <td>{{ employe.phone_number }}</td>
                          <!-- <td>
                            {{ employe.role }}
                          </td> -->
                          <td>
                            <template v-if="employe.status === 'Aktif'">
                              <span class="badge badge-success">Aktif</span>
                            </template>
                            <template v-else-if="employe.status === 'Nonaktif'">
                              <span class="badge badge-warning">Nonaktif</span>
                            </template>
                          </td>
                          <td>{{ employe.position }}</td>
                          <td>
                            <a href="" class="btn btn-sm btn-inverse-success" @click.prevent="onEdit(employe)">
                              <i class="mdi mdi-pencil btn-icon-prepend"></i>
                            </a>
                            <a @click.prevent="openModal(employe.id)" class="btn btn-sm btn-inverse-warning" data-toggle="modal" :data-target="'#exampleModalDetail' + employees.id">
                              <i class="mdi mdi-file-document-box-outline btn-icon-prepend"></i>
                            </a>
                          </td>
                      </tr>
                    </tbody>
                  </table>
                  <!-- <b-pagination
                        v-model="currentPage"
                        :per-page="perPage"
                        :total-rows="rows"
                        align="center"
                        v-on:input="pagination">
                        </b-pagination> -->
                </div>
            </div>
          </div>
        </div>
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
                  <has-error :form="form" field="nip"></has-error>
                </div>
                <div class="form-group">
                  <label for="name">Nama Pegawai</label>
                  <input type="text" class="form-control" v-model="form.name" :class="{ 'is-invalid': form.errors.has('name') }" id="name" placeholder="Masukkan Nama Pegawai">
                  <has-error :form="form" field="name"></has-error>
                </div>
                <div class="form-group">
                  <label for="email">Email</label>
                  <input type="text" class="form-control" v-model="form.email" :class="{ 'is-invalid': form.errors.has('email') }" id="email" placeholder="Masukkan Email Pegawai">
                  <has-error :form="form" field="email"></has-error>
                </div>
                <div class="form-group">
                  <label for="phone_number">No. Telepon</label>
                  <input type="text" class="form-control" v-model="form.phone_number" :class="{ 'is-invalid': form.errors.has('phone_number') }" id="phone_number" placeholder="Masukkan Nomor Telepon Pegawai">
                  <has-error :form="form" field="phone_number"></has-error>
                </div>
                <div class="form-group">
                  <label for="address">Alamat</label>
                  <input type="text" class="form-control" v-model="form.address" :class="{ 'is-invalid': form.errors.has('address') }" id="address" placeholder="Masukkan Alamat Pegawai">
                  <has-error :form="form" field="address"></has-error>
                </div>
                <div v-show="!isFormCreateEmployeMode" class="form-group">
                  <label for="role">Role</label>
                  <select class="form-control" id="role" v-model="form.role" :class="{ 'is-invalid': form.errors.has('role') }">
                    <option disabled value="">Pilih Role Pegawai</option>
                    <option value="user">User</option>  
                    <option value="operator">Operator</option>
                    <option value="admin">admin</option>
                  </select>
                  <has-error :form="form" field="role"></has-error>
                </div>
                <div v-show="!isFormCreateEmployeMode" class="form-group">
                  <label for="status">Status Pegawai</label>
                  <select class="form-control" id="status" v-model="form.status" :class="{ 'is-invalid': form.errors.has('status') }">
                    <option disabled value="">Pilih Status Pegawai</option>
                    <option value="1" checked>Aktif</option>
                    <option value="2">NonAktif</option>
                  </select>
                  <has-error :form="form" field="status"></has-error>
                </div>
                <div class="form-group">
                  <label for="position">Posisi Pegawai</label>
                  <select class="form-control" id="position" v-model="form.position_id" :class="{ 'is-invalid': form.errors.has('position_id') }">
                    <option disabled value>Pilih Posisi Pegawai</option>
                    <option v-for="position in positions.data" :key="position.id" :value="position.id">{{ position.name }}</option>
                  </select>
                  <has-error :form="form" field="position_id"></has-error>
                </div>
                <div class="form-group">
                  <label for="department">Department Pegawai</label>
                  <select class="form-control" id="department" v-model="form.department_id" :class="{ 'is-invalid': form.errors.has('department_id') }">
                    <option disabled value>Pilih Department Pegawai</option>
                    <option v-for="department in departments.data" :key="department.id" :value="department.id">{{ department.name }}</option>
                  </select>
                  <has-error :form="form" field="department_id"></has-error>
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

      <div v-if="employees && employees.id" class="modal fade" :id="'exampleModalDetail' + employees.id" tabindex="-1" role="dialog" :aria-labelledby="'exampleModalDetail' + employees.id" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLongTitle">Detail Data</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body table-responsive">
                          <table class="table table-bordered no-margin">
                            <tbody>
                              <tr>
                                <th>NIP</th>
                                <td><span :id="'nip' + employees.id">{{ employees.nip }}</span></td>
                              </tr>
                              <tr>
                                <th>Nama Pegawai</th>
                                <td><span :id="'name' + employees.id">{{ employees.name }}</span></td>
                              </tr>
                              <tr>
                                <th>Email</th>
                                <td><span :id="'email' + employees.id">{{ employees.email }}</span></td>
                              </tr>
                              <tr>
                                <th>No. Telp</th>
                                <td><span :id="'phone_number' + employees.id">{{ employees.phone_number }}</span></td>
                              </tr>
                              <tr>
                                <th>Alamat</th>
                                <td><span :id="'address' + employees.id">{{ employees.address }}</span></td>
                              </tr>
                              <tr>
                                <th>Role</th>
                                <td><span :id="'role' + employees.id">{{ employees.role }}</span></td>
                              </tr>
                              <tr>
                                <th>Status</th>
                                <td><span :id="'status' + employees.id">{{ employees.status }}</span></td>
                              </tr>
                              <tr>
                                <th>Posisi</th>
                                <td><span :id="'position' + employees.id">{{ employees.position }}</span></td>
                              </tr>
                              <tr>
                                <th>Department</th>
                                <td><span :id="'department' + employees.id">{{ employees.department }}</span></td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                        <div class="modal-footer">
                          <button type="button" @click="closeModal(employees.id)" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                      </div>
                    </div>
                  </div>
    </div>
  </div>
</template>



<script>
import { Form } from "vform";
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

		getEmployee() {
      // let offset = (this.currentPage - 1) * this.perPage;
			this.$axios.get("https://api.klikagenda.com/api/employees")
      .then(data => {
				this.employees = data.data.data;
			});     
		},

		showModal() {
			this.isFormCreateEmployeMode = true;
			this.form.reset(); // v form reset
			$("#exampleModal").modal("show"); // show modal
		},

		getPosition() {
			this.$axios.get("https://api.klikagenda.com/api/positions")
      .then(data => {
				this.positions = data.data.data;
			});     
		},

		getDepartment() {
			this.$axios.get("https://api.klikagenda.com/api/departments")
      .then(data => {
				this.departments = data.data.data;
			});     
		},

		createEmployee() {
			// request post
			this.form.post("https://api.klikagenda.com/api/employees", {
        headers: {
          Authorization: "Bearer " + localStorage.getItem("access_token"),
        },
			}).then(() => {
				$("#exampleModal").modal("hide");
				swal.fire({
					icon: "success",
					title: "Pegawai berhasil ditambahkan"
              
				});
				this.getEmployee();
			}).catch(() => {
				console.log("transaction fail"); 
			});
		},

    openModal(id) {
      this.$axios.get("https://api.klikagenda.com/api/employees/" + id)
        .then(response => {
          this.employees = response.data;
          $("#exampleModalDetail" + id).modal("show");
        })
        .catch(error => {
          console.error(error);
        });
    },
    closeModal(id) {
      $("#exampleModalDetail" + id).modal("hide");
    },

    onEdit(employe){
			this.isFormCreateEmployeMode = false;
			this.form.reset(); // v form reset inputs
			$("#exampleModal").modal("show"); // show modal
			this.form.fill(employe);
		},

		editEmployee(id){
			// request put
			this.form.put("https://api.klikagenda.com/api/employees/" + id, {
        headers: {
          Authorization: "Bearer " + localStorage.getItem("access_token"),
        },
			}).then(() => {
        this.isFormCreateEmployeMode = false;
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