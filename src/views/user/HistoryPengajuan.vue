<template>
  <div class="main-panel">
    <div class="content-wrapper">
      <div class="row">
        <div class="col-md-12 grid-margin title">
          <div class="row">
            <div class="col-12 align-items-center">
              <h3 class="font-weight-bold">HISTORY PENGAJUAN AGENDA</h3>
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
                      <!-- <th>Disposisi</th> -->
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
                      <!-- <td>{{ suggestion.suggestion_dispositions }}</td> -->
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
                        <a href="" class="btn btn-sm btn-inverse-success" @click.prevent="onEdit(employe)">
                          <i class="mdi mdi-pencil btn-icon-prepend"></i>
                        </a>
                        <!-- <a href="#" class="btn btn-sm btn-inverse-warning" data-toggle="modal" data-target="#modalDetail">
                          <i class="mdi mdi-file-document-box-outline btn-icon-prepend"></i>
                        </a> -->
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
			}).then(data => {
				this.suggestions = data.data.data;
			});     
		},

    showModal() {
			this.isGenerateAgenda = true;
			// this.form.reset(); // v form reset
			$("#exampleModal").modal("show"); // show modal
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