<template>
  <div class="content-wrapper">
        <div class="row">
          <div class="col-md-12 grid-margin title">
            <div class="row">
              <div class="col-12 align-items-center">
                <h3 class="font-weight-bold">KELOLA DEPARTMENT BAPENDA SURAKARTA</h3>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-6 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">Data Bidang</h4>
                <div class="table-responsive">
                  <table class="table table-hover">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Bidang</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(department, index) in departments.data" :key="department.id">                      
                        <template v-if="editId == department.id">
                          <td>{{ index + 1}}</td>
                          <td><input v-model="form.name" type="text"></td>
                          <td>
                            <a href="" class="btn btn-sm btn-inverse-success" @click.prevent="editDepartment(department.id)">
                              <i class="mdi mdi-check btn-icon-prepend"></i>
                            </a>
                            <a href="" class="btn btn-sm btn-inverse-danger" @click.prevent="onCancel()">
                              <i class="mdi mdi-close btn-icon-prepend"></i>
                            </a>
                          </td>
                        </template>
                        <template v-else>
                          <td>{{  index + 1 }}</td>
                          <td>{{ department.name }}</td>
                          <td>
                            <a href="#" class="btn btn-sm btn-inverse-warning" @click.prevent="onEdit(department)">
                              <i class="mdi mdi-pencil btn-icon-prepend"></i>
                            </a>
                            <a href="" class="btn btn-sm btn-inverse-danger" @click.prevent="deleteDepartment(department.id)">
                              <i class="mdi mdi-delete btn-icon-prepend"></i>
                            </a>
                          </td>
                        </template>
                        </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Form Tambah Bidang Bapenda</h4>
                  <div class="table-responsive">
                    <form class="forms-sample" v-on:submit.prevent="createDepartment()">
                      <div class="form-group">
                        <label for="inputDepartments">Bidang</label>
                        <input type="text" class="form-control" v-model="form.name" :class="{ 'is-invalid': form.errors.has('name') }" id="inputDepartments" placeholder="Masukkan Department Bapenda">
                        <has-error :form="form" field="name"></has-error>
                      </div>
                      <button type="submit" class="btn btn-primary mr-2">Simpan</button>
                      <!-- <button class="btn btn-light">Batalkan</button> -->
                    </form>
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
	name: "DepartmentPegawai",
	data() {
		return {
			editId: "",
			departments: {},
			form: new Form({
				id: "",
				name: ""
			}),
		};
	},

	methods: {

		getDepartment() {  
			this.$axios.get("/departments")
      		.then((response) => {
				this.departments = response.data;
			})
			.catch((error) => {
				console.log(error);
			});     
		},

		createDepartment() {
			// request post
			this.form.post("https://api.klikagenda.com/api/departments")
      		.then(() => {
				swal.fire({
					icon: "success",
					title: "Bidang berhasil ditambahkan"
				});
				this.getDepartment();
			}).catch((error) => {
				console.log(error);
			});
		},

		

		onCancel(){
			this.editId = "";
			this.form.name = "";
		},

    onEdit(department){ 
			this.editId = department.id;
			this.form.name = department.name;
		},

		editDepartment(id){
			this.editId = "";
			this.form.put("https://api.klikagenda.com/api/departments/" + id, {
        headers: {
          Authorization: "Bearer " + localStorage.getItem("access_token"),
        },
				// name: name,
			}).then(() => {
				swal.fire({
					icon: "success",
					title: "Bidang berhasil diubah"
				});
				this.getDepartment();

			}).catch((error) => {
				console.log(error);
			});
		}, 

		deleteDepartment(id) {
			// sweet alert confirmation
			swal.fire({
				title: "Ingin menghapus data?",
				// text: "You won't be able to revert this!",
				icon: "warning",
				showCancelButton: true,
				confirmButtonColor: "#3085d6",
				cancelButtonColor: "#d33",
				confirmButtonText: "Ya hapus data"
			}).then((result) => {
				// confirm delete?
				if (result.value) {
					// request delete
					this.form.delete("https://api.klikagenda.com/api/departments/" + id, {
            headers: {
              Authorization: "Bearer " + localStorage.getItem("access_token"),
            },
					}).then(() => {
						// sweet alert success
						swal.fire(
							"Terhapus",
							"Bidang berhasil dihapus",
							"success"
						);   
  
						this.getDepartment(); 
					}).catch(() => {
						// sweet alert fail
						swal.fire({
							icon: "error",
							title: "Oops...",
							text: "Terjadi kesalahan",
							// footer: "<a href>Why do I have this issue?</a>"
						});
					}); 
				}
			});
		}
	},

	created() {
		this.getDepartment();
	},
	mounted() {
		console.log("Component mounted.");
	}
};
</script>