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
                      <th>Disposisi</th>
                      <th>Ruangan</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(agenda, index) in agendas.data" :key="agenda.id">
                      <td>{{ index + 1}}</td>
                      <td>{{ agenda.title }}</td>
                      <td>{{ agenda.date }}</td>
                      <td>{{ agenda.start_time }} - {{ agenda.end_time }}</td>
                      <td>{{ agenda.person_in_charge }}</td>
                      <td>{{ agenda.location }}</td>
                      <td>
                        <button @click="openModal(agenda.id)" class="btn btn-sm btn-inverse-warning" data-toggle="modal" :data-target="'#exampleModalDetail' + agenda.id">
                          <i class="mdi mdi-file-document-box-outline btn-icon-prepend"></i>
                        </button>
                      </td>
                    </tr>
                  </tbody>
                  <div v-if="agendas && agendas.id" class="modal fade" :id="'exampleModalDetail' + agendas.id" tabindex="-1" role="dialog" :aria-labelledby="'exampleModalDetail' + agendas.id" aria-hidden="true">
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
                                <th>Judul Agenda</th>
                                <td><span :id="'title' + agendas.id">{{ agendas.title }}</span></td>
                              </tr>
                              <tr>
                                <th>Tanggal</th>
                                <td><span :id="'date' + agendas.id">{{ agendas.date }}</span></td>
                              </tr>
                              <tr>
                                <th>Waktu</th>
                                <td><span :id="'time' + agendas.id">{{ agendas.start_time }} - {{ agendas.end_time }}</span></td>
                              </tr>
                              <tr>
                                <th>Isi Agenda</th>
                                <td><span :id="'contents' + agendas.id">{{ agendas.contents }}</span></td>
                              </tr>
                              <tr>
                                <th>Disposisi</th>
                                <td><span :id="'department' + agendas.id">{{ agendas.department }}</span></td>
                              </tr>
                              <tr>
                                <th>PenanggungJawab</th>
                                <td><span :id="'person_in_charge' + agendas.id">{{ agendas.person_in_charge }}</span></td>
                              </tr>
                              <tr>
                                <th>Kategori</th>
                                <td><span :id="'category' + agendas.id">{{ agendas.category }}</span></td>
                              </tr>
                              <tr>
                                <th>Ruangan</th>
                                <td><span :id="'room' + agendas.id">{{ agendas.room }}</span></td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                        <div class="modal-footer">
                          <button type="button" @click="closeModal(agendas.id)" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                      </div>
                    </div>
                  </div>
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
                <button type="button" class="btn btn-success btn-icon-text" @click="generateAgendaExcel">
                  Excel
                  <i class="ti-file btn-icon-prepend"></i>                                                    
                </button>                
                <button type="button" class="btn btn-danger btn-icon-text"  @click="generateAgendaPDF">
                  <i class="ti-file btn-icon-prepend"></i>                                                    
                  PDF
                </button>
                <button type="button" class="btn btn-warning btn-icon-text" @click="generateAgendaText">
                  Text
                  <i class="ti-file btn-icon-prepend"></i>                                                    
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
import jspdf from "jspdf";
export default {
	name: "AgendaBapenda",
	data() {
		return {
      isGenerateAgenda: true,
			agendas: {},
		};
	},

	methods: {

    generateAgendaPDF(){
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

    generateAgendaExcel(){
      this.$axios.get("https://api.klikagenda.com/api/download-agenda-excel", { 
        responseType: "blob" 
      })
        .then(response => {
          const blob = new Blob([response.data], { type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" });
          const url = URL.createObjectURL(blob);
          const link = document.createElement("a");
          link.href = url;
          link.download = "export.xlsx";
          link.style.display = "none";
          document.body.appendChild(link);
          link.click();
          document.body.removeChild(link);
          URL.revokeObjectURL(url);
        })
        .catch(error => {
          console.error("Failed to export Excel", error);
        });
    },

    generateAgendaText(){
      this.$axios.get("https://api.klikagenda.com/api/generate-agenda-text")
        .then(response  => {
          const textData = response.data;
          const link = document.createElement("a");
          link.href = "data:text/plain;charset=utf-8," + encodeURIComponent(textData);
          link.download = "export.txt";
          link.style.display = "none";

          // Menambahkan elemen <a> ke DOM dan mengkliknya untuk memulai unduhan
          document.body.appendChild(link);
          link.click();
          document.body.removeChild(link);
        })
        .catch(error => {
          // Tangani kesalahan jika ada
          console.error("Failed to copy agenda", error);
        });
    },

		getAgenda() {
			this.$axios.get("https://api.klikagenda.com/api/agendas")
      .then(response => {
				this.agendas = response.data.data;
			});     
		},

    openModal(id) {
      this.$axios.get("https://api.klikagenda.com/api/agendas/" + id)
        .then(response => {
          this.agendas = response.data;
          $("#exampleModalDetail" + id).modal("show");
        })
        .catch(error => {
          console.error(error);
        });
    },
    closeModal(id) {
      $("#exampleModalDetail" + id).modal("hide");
    },

    showModal() {
			this.isGenerateAgenda = true;
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