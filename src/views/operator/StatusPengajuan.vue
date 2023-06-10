<template>
  <div class="main-panel">
    <div class="content-wrapper">
      <div class="row">
        <div class="col-md-12 grid-margin title">
          <div class="row">
            <div class="col-12 align-items-center">
              <h3 class="font-weight-bold">PENGAJUAN AGENDA BAPENDA SURAKARTA</h3>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <div class="table-responsive">
                <table class="table" ref="content">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Judul Agenda</th>
                      <th>Tanggal</th>
                      <th>Waktu</th>
                      <th>PenanggungJawab</th>
                      <th>Status</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(suggestion, index) in suggestions.data" :key="suggestion.id">
                      <td>{{ index + 1}}</td>
                      <td>{{ suggestion.title }}</td>
                      <td>{{ suggestion.date }}</td>
                      <td>{{ suggestion.start_time }} - {{ suggestion.end_time }}</td>
                      <td>{{ suggestion.person_in_charge }}</td>
                      <td>
                        <template v-if="suggestion.status === 'Diterima'">
                          <span class="badge badge-success">Diterima</span>
                        </template>
                        <template v-else-if="suggestion.status === 'Diproses'">
                          <span class="badge badge-warning">Diproses</span>
                        </template>
                        <template v-else>
                          <span class="badge badge-danger">Ditolak</span>
                        </template>
                      </td>
                      <td>
                        <button class="btn btn-sm btn-inverse-success" @click="approveAgenda(suggestion.id)">
                          <i class="mdi mdi-checkbox-marked-outline btn-icon-prepend"></i>
                        </button>
                        <button href="" class="btn btn-sm btn-inverse-danger" @click="denyAgenda(suggestion.id)">
                          <i class="mdi mdi-close-box-outline btn-icon-prepend"></i>
                        </button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
// import swal from "sweetalert2";
export default {
	name: "HistoryPengajuan",
	data() {
		return {
			editId: "",
			suggestions: {},
		};
	},

	methods: {

		getHistory() {
  
			axios.get("https://api.klikagenda.com/api/suggestions", {
        headers: {
          Authorization: "Bearer " + localStorage.getItem("access_token"),
        },
			}).then(response => {
				this.suggestions = response.data.data;
			});     
		},

    approveAgenda(id) {
			axios.post("https://api.klikagenda.com/api/suggestions-approve/" + id, {}, {
        headers: {
          Authorization: "Bearer " + localStorage.getItem("access_token"),
        },
			}).then(() => {
        alert("Suggestion berhasil ditambahkan ke agenda");
        this.getHistory();
			}).catch((error) => {
				console.log(error.response); 
			});
    },

    denyAgenda(id) {
      // alert("ditolak");
      axios.post("https://api.klikagenda.com/api/suggestions-deny/" + id, {
        headers: {
          Authorization: "Bearer " + localStorage.getItem("access_token"),
        },
			}).then(() => {
        alert("Suggestion telah ditolak"); // ganti alert input 
        this.getHistory();
			}).catch((error) => {
				console.log(error.response); 
			});
    },
	},

	created() {
		this.getHistory();
	},
	mounted() {
		console.log("Component mounted.");
	}
};
</script>