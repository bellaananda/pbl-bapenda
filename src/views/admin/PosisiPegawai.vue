<template>
	<div class="content-wrapper">
		<div class="row">
			<div class="col-md-12 grid-margin title">
				<div class="row">
					<div class="col-12 align-items-center">            			
						<h3 class="font-weight-bold">KELOLA POSISI BAPENDA SURAKARTA</h3>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-6 grid-margin stretch-card">
				<div class="card">
					<div class="card-body">
						<h4 class="card-title">Data Posisi</h4>
						<div class="table-responsive">
							<table class="table table-hover">
								<thead>
									<tr>
										<th>No</th>
										<th>Posisi</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
									<tr v-for="(position, index) in positions.data" v-bind:key="position.id">
										<template v-if="editId == position.id">
											<td>{{ index + 1}}</td>
											<td><input v-model="form.name" type="text"></td>
											<td>
												<a href="" class="btn btn-sm btn-inverse-success" @click.prevent="editPosition(position.id)">
													<i class="mdi mdi-check btn-icon-prepend"></i>
												</a>
												<a href="" class="btn btn-sm btn-inverse-danger" @click.prevent="onCancel()">
													<i class="mdi mdi-close btn-icon-prepend"></i>
												</a>
											</td>
										</template>
										<template v-else>
											<td>{{ index + 1}}</td>
											<td>{{ position.name }}</td>
											<td>
												<a href="" class="btn btn-sm btn-inverse-warning" @click.prevent="onEdit(position)">
													<i class="mdi mdi-pencil btn-icon-prepend"></i>
												</a>
												<a href="" class="btn btn-sm btn-inverse-danger" @click.prevent="deletePosition(position.id)">
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
						<h4 class="card-title">Form Tambah Posisi Pegawai</h4>
						<div class="table-responsive">
							<form class="forms-sample" v-on:submit.prevent="createPosition()">
								<div class="form-group">
									<label for="inputPositions">Posisi Pegawai</label>
									<input type="text" class="form-control" v-model="form.name" :class="{ 'is-invalid': form.errors.has('name') }" id="inputPositions" placeholder="Masukkan Posisi Pegawai">
									<has-error :form="form" field="name"></has-error>
								</div>
								<button type="submit" class="btn btn-primary mr-2">Simpan</button>
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

export default{
	name: "PosisiPegawai",
	data() {
		return {
			editId: "",
			positions: {},
			form: new Form({
				id: "",
				name: ""
			}),
			editPositionData: {
				id:"",
				name: ""
			},
		};
	},

	methods: {

		getPosition() { 
			this.$axios.get("/positions")
			.then((response) => {
				this.positions = response.data;
			})
			.catch((error) => {
				console.log(error);
			});    
		},


		createPosition() {
			// request post
			this.form.post("https://api.klikagenda.com/api/positions", {
				headers: {
					Authorization: "Bearer " + localStorage.getItem("access_token"),
				},
			}).then(() => {
				swal.fire({
					icon: "success",
					title: "Posisi berhasil ditambahkan"
				});
				this.getPosition();
			}).catch((error) => {
				console.log(error);
			});
		},

		onEdit(position){
			this.editId = position.id;
			this.form.name = position.name;
		},

		onCancel(){
			this.editId = "";
			this.form.name = "";
		},

		editPosition(id){
			let name        = this.form.name;
			this.editId = "";
			// this.editPositionData.name = ''
			this.form.put("https://api.klikagenda.com/api/positions/" + id, {
				headers: {
					Authorization: "Bearer " + localStorage.getItem("access_token"),
				},
				name: name
			}).then(() => {
				swal.fire({
					icon: "success",
					title: "Posisi berhasih diubah"
				});
				this.getPosition();

			}).catch((error) => {
				console.log(error);
			});
		}, 

		deletePosition(id) {
			// sweet alert confirmation
			swal.fire({
				title: "Ingin menghapus data?",
				// text: "You won't be able to revert this!",
				icon: "warning",
				showCancelButton: true,
				confirmButtonColor: "#4747A1",
				cancelButtonColor: "#fffff",
				confirmButtonText: "Ya hapus data"
			}).then((result) => {
				// confirm delete?
				if (result.value) {
					// request delete
					this.form.delete("https://api.klikagenda.com/api/positions/" + id, {
						headers: {
							Authorization: "Bearer " + localStorage.getItem("access_token"),
						},
					}).then(() => {
						// sweet alert success
						swal.fire(
							"Terhapus",
							"Posisi berhasil dihapus",
							"success"
						);   
						this.getPosition(); 
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
		this.getPosition();
	},
	mounted() {
		console.log("Component mounted.");
	}
};
</script>