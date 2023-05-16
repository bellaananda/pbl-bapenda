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
                      <th>Disposisi</th>
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
                        <template v-if="suggestion.status === 0">
                          <span class="badge badge-danger">Ditolak</span>
                        </template>
                        <template v-else>
                          <span class="badge badge-success">Diterima</span>
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
      <div class="row">
        <div class="col-md-12 grid-margin">
          <div class="row">
            <div class="col-3 button-generate">
              <button type="button" class="btn btn-primary btn-lg btn-block" data-toggle="modal" data-target="#exampleModal">
                <i class="ti-printer"></i>                      
                  Report Agenda
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"> 
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 v-show="isGenerateAgenda" class="modal-title" id="exampleModalLabel">Generate Agenda</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="template-demo">
                <button type="button" class="btn btn-primary btn-icon-text">
                  <i class="ti-file btn-icon-prepend"></i>
                    Word
                </button>
                <button type="button" class="btn btn-success btn-icon-text" @click="generateSuggestionsExcel">
                  Excel
                  <i class="ti-file btn-icon-prepend"></i>                                                    
                </button>                
                <button type="button" class="btn btn-danger btn-icon-text"  @click="download()">
                  <i class="ti-file btn-icon-prepend"></i>                                                    
                  PDF
                </button>
              </div>
              <div class="template-demo">
                <button type="button" class="btn btn-warning btn-icon-text">
                  Text
                  <i class="ti-file btn-icon-prepend"></i>                                                    
                </button>
                <button type="button" class="btn btn-info btn-icon-text">
                  Print
                  <i class="ti-printer btn-icon-append"></i>                                                                              
                </button>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Batalkan</button>
            </div>
          </div>
        </div>
      </div>

  </div>
</template>

<script>
import axios from "axios";
import jspdf from "jspdf";
export default {
	name: "HistoryPengajuan",
	data() {
		return {
      isGenerateAgenda: true,
			editId: "",
			suggestions: {},
		};
	},

	methods: {

		getHistory(page) {
			if (typeof page === "undefined") {
				page = 1;
			}
  
			axios.get("https://api.klikagenda.com/api/suggestions", {
				params: {
					page: page
				}
			}).then(data => {
				this.suggestions = data.data.data;
			});     
		},

    download(){
      const doc = new jspdf();

      const html = this.$refs.content.innerHTML;

      doc.html(html, {
        callback: function (doc) {
          doc.save();
        },
        x: 10,
        y: 10
      });
    },
    

    generateSuggestionsExcel(){
      window.location.href = "https://api.klikagenda.com/api/download-suggestions-excel";
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