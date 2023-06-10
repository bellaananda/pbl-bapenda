<template>
    <div class="content-wrapper">
          <div class="row">
            <div class="col-md-12 grid-margin title">
              <div class="row">
                <div class="col-12 align-items-center">
                  <h3 class="font-weight-bold">PEGAWAI BAPENDA SURAKARTA</h3>
                </div>
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
                        <th>NIP</th>
                        <th>Nama</th>
                        <!-- <th>Email</th> -->
                        <th>No. Telp</th>
                        <!-- <th>Alamat</th> -->
                        <!-- <th>Role</th> -->
                        <th>Status</th>
                        <th>Posisi</th>
                        <!-- <th>Department</th> -->
                        <!-- <th></th> -->
                      </tr>
                    </thead> 
                    <tbody>
                      <tr v-for="(employe, index) in employees.data" :key="employe.id">
                          <td>{{ index + 1}}</td>
                          <td>{{ employe.nip }}</td>
                          <td>{{ employe.name }}</td>
                          <!-- <td>{{ employe.email }}</td> -->
                          <td>{{ employe.phone_number }}</td>
                          <!-- <td>{{ employe.address }}</td> -->
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
                          <!-- <td>{{ employe.department }}</td> -->
                          <!-- <td>
                            <a href="" class="btn btn-sm btn-inverse-success" @click.prevent="onEdit(employe)">
                              <i class="mdi mdi-pencil btn-icon-prepend"></i>
                            </a> -->
                            <!-- <a href="#" class="btn btn-sm btn-inverse-warning" data-toggle="modal" data-target="#modalDetail">
                              <i class="mdi mdi-file-document-box-outline btn-icon-prepend"></i>
                            </a> -->
                            <!-- <a href="" class="btn btn-sm btn-inverse-danger" @click.prevent="deleteEmploye(employe.id)">
                              <i class="mdi mdi-delete btn-icon-prepend"></i>
                            </a>
                          </td> -->
                      </tr>
                    </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
</template>

<script>
import axios from "axios";

export default {
	name: "PegawaiBapenda", 
	data() {
		return {
			employees: {},
		};
	},

	methods: {

		getEmployee() {
      // let offset = (this.currentPage - 1) * this.perPage;
			axios.get("https://api.klikagenda.com/api/employees ", {
        headers: {
          Authorization: "Bearer " + localStorage.getItem("access_token"),
        },
			}).then(data => {
				this.employees = data.data.data;
			});     
		},

	},

	created() {
		this.getEmployee();

	},
	mounted() {
		console.log("Component mounted.");
	}
};
</script>