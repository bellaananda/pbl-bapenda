<template>
  <div class="content-wrapper">
        <div class="row">
          <div class="col-md-12 grid-margin title">
            <div class="row">
              <div class="col-12 align-items-center">
                <h3 class="font-weight-bold">KELOLA KATEGORI BAPENDA SURAKARTA</h3>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 grid-margin">
            <div class="row">
              <div class="col-lg-5">
                <input type="text" placeholder="Search..." name="cari" id="cari" class="form-control">
              </div>
            </div>
          </div>
        </div> 
        <div class="row">
          <div class="col-lg-6 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">Data Kategori</h4>
                <div class="table-responsive">
                  <table class="table table-hover">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Kategori Agenda</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(category, index) in categories.data" :key="category.id">
                        <template v-if="editId == category.id">
                          <td>{{ index + 1}}</td>
                          <td><input v-model="form.name" type="text"></td>
                          <td>
                            <a href="" class="btn btn-sm btn-inverse-success" @click.prevent="editCategory(category.id)">
                              <i class="mdi mdi-check btn-icon-prepend"></i>
                            </a>
                            <a href="" class="btn btn-sm btn-inverse-danger" @click.prevent="onCancel()">
                              <i class="mdi mdi-close btn-icon-prepend"></i>
                            </a>
                          </td>
                        </template>
                        <template v-else>
                          <td>{{ index + 1}}</td>
                          <td>{{ category.name }}</td>
                          <td>
                            <a href="" class="btn btn-sm btn-inverse-warning" @click.prevent="onEdit(category)">
                              <i class="mdi mdi-pencil btn-icon-prepend"></i>
                            </a>
                            <a href="" class="btn btn-sm btn-inverse-danger" @click.prevent="deleteCategory(category.id)">
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
                  <h4 class="card-title">Form Tambah Kategori Agenda</h4>
                  <div class="table-responsive">
                    <form class="forms-sample" v-on:submit.prevent="createCategory()">
                      <div class="form-group">
                        <label for="inputCategories">Kategori Agenda</label>
                        <input type="text" class="form-control" v-model="form.name" :class="{ 'is-invalid': form.errors.has('name') }" id="inputCategories" placeholder="Masukkan Kategori Agenda">
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
	name: "KategoriAgenda",
	data() {
		return {
			editId: "",
			categories: {},
			form: new Form({
				id: "",
				name: ""
			}),
			editCategoryData: {
				name: ""
			},
		};
	},

	methods: {

		getCategories() {
			this.$axios.get("/categories")
      .then((response) => {
				this.categories = response.data;
			})
			.catch((error) => {
				console.log(error);
			});     
		},


		createCategory() {
			// request post
			this.form.post("https://api.klikagenda.com/api/categories", {
        headers: {
          Authorization: "Bearer " + localStorage.getItem("access_token"),
        },
			}).then(() => {
				// this.modalKategori = false;
				swal.fire({
					icon: "success",
					title: "Kategori berhasil ditambahkan"
              
				});
				this.getCategories();
            
			}).catch((error) => {
				console.log(error);
			});
		},

		onEdit(category){
			this.editId = category.id;
			this.form.name = category.name;
		},

		onCancel(){
			this.editId = "";
			this.form.name = "";
		},

		editCategory(id){
			let name        = this.form.name;
			this.editId = "";
			this.form.put("https://api.klikagenda.com/api/categories/" + id, {
        headers: {
          Authorization: "Bearer " + localStorage.getItem("access_token"),
        },
				name: name
			}).then(() => {
				swal.fire({
					icon: "success",
					title: "Kategori berhasil diubah"
				});
				this.getCategories();

			}).catch((error) => {
				console.log(error);
			});
		}, 

		deleteCategory(id) {
			// sweet alert confirmation
			swal.fire({
				title: "Ingin menghapus data?",
				icon: "warning",
				showCancelButton: true,
				confirmButtonColor: "#3085d6",
				cancelButtonColor: "#d33",
				confirmButtonText: "Ya hapus data"
			}).then((result) => {
				// confirm delete?
				if (result.value) {
					// request delete
					this.form.delete("https://api.klikagenda.com/api/categories/" + id, {
            headers: {
              Authorization: "Bearer " + localStorage.getItem("access_token"),
            },
					}).then(() => {
						// sweet alert success
						swal.fire(
							"Terhapus",
							"Kategori berhasil dihapus",
							"success"
						);   
  
						this.getCategories(); 
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
		this.getCategories();
	},
	mounted() {
		console.log("Component mounted.");
	}
};
</script>