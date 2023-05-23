<template>
  <div class="main-panel">
    <div class="content-wrapper">
      <div class="row">
        <div class="col-md-12 grid-margin title">
          <div class="row">
            <div class="col-12 align-items-center">
              <h3 class="font-weight-bold">AGENDA BAPENDA SURAKARTA</h3>
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
                      <!-- <th>Lokasi</th> -->
                      <th>Isi Agenda</th>
                      <!-- <th>Attachment</th> -->
                      <th>Disposisi</th>
                      <th>Department</th>
                      <th>Kategori</th>
                      <th>Ruangan</th>
                      <!-- <th>Suggestion</th> -->
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(agenda, index) in agendas.data" :key="agenda.id">
                      <td>{{ index + 1}}</td>
                      <td>{{ agenda.title }}</td>
                      <td>{{ agenda.date }}</td>
                      <td>{{ agenda.start_time }} - {{ agenda.end_time }}</td>
                      <!-- <td>{{ agenda.location }}</td> -->
                      <td>{{ agenda.contents }}</td>
                      <!-- <td>{{ agenda.attachment }}</td> -->
                      <td>{{ agenda.person_in_charge }}</td>
                      <td>{{ agenda.department }}</td>
                      <td>{{ agenda.category }}</td>
                      <td>{{ agenda.room }}</td>
                      <!-- <td>{{ agenda.suggestion }}</td> -->
                      <!-- <td>
                        <a href="#" class="btn btn-sm" data-toggle="modal" data-target="#modalDetail">
                          <i class="mdi mdi-file-document-box-outline btn-icon-prepend"></i>
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
                <button type="button" class="btn btn-success btn-icon-text">
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
  </div>
</template>

<script>
import axios from "axios";
import jspdf from "jspdf";
export default {
	name: "AgendaBapenda",
	data() {
		return {
      isGenerateAgenda: true,
			editId: "",
			agendas: {},
		};
	},

	methods: {

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

      // doc.save("agenda.pdf");
      
    },

		getAgenda() {
			axios.get("https://v3421024.mhs.d3tiuns.com/api/agendas", {
			}).then(data => {
				this.agendas = data.data.data;
			});     
		},

    showModal() {
			this.isGenerateAgenda = true;
			// this.form.reset(); // v form reset
			$("#exampleModal").modal("show"); // show modal
		},
	},

	created() {
		this.getAgenda();
	},
	mounted() {
		console.log("Component mounted.");
	}
};
</script>