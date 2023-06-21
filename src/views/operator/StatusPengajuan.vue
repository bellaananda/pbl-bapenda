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
        <div class="col-md-6">
          <div class="form-group">
            <input
              type="text"
              class="form-control"
              v-model="search"
              placeholder="Cari agenda..."
            />
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <button type="button" class="btn btn-primary" @click="searchAgenda">
              Cari
            </button>
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
                    <tr v-for="(suggestion, index) in suggestions" :key="suggestion.id">
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
                <div class="template-demo">
                <button
                  type="button"
                  class="btn btn-primary"
                  :disabled="current_page === 1"
                  @click="previousPage()"
                >
                  Previous
                </button>
                <span>Page {{ current_page }} of {{ totalPages }}</span>
                <button
                  type="button"
                  class="btn btn-primary"
                  :class="{ disabled: current_page === totalPages }"
                  @click="nextPage()"
                >
                  Next
                </button>
              </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
// import axios from "axios";
// import swal from "sweetalert2";
export default {
	name: "HistoryPengajuan",
	data() {
		return {
			editId: "",
			suggestions: {},
      current_page: 1,
      per_page: 15,
      totalItems: 0,
      totalPages: 0,
      search: "",
		};
	},

	methods: {

    previousPage() {
      if (this.current_page > 1) {
        this.current_page--;
        this.getHistory();
      }
    },
    nextPage() {
      if (this.current_page < this.totalPages) {
        this.current_page++;
        this.getHistory();
      }
    },

    searchAgenda() {
      this.current_page = 1; // Reset halaman saat melakukan pencarian
      this.getHistory();
    },

		getHistory(page = 1) {
      // if (suggestion.user_id === this.loggedInUser.id) {
      this.$axios
        .get("/suggestions", {
          params: {
            page: page,
            per_page: this.per_page,
            search: this.search,
          },
        })
        .then((response) => {
          this.suggestions = this.getItemsOnCurrentPage(response.data.data);
          this.totalItems = response.data.data.length;
          this.totalPages = Math.ceil(this.totalItems / this.per_page);
        })
        .catch((error) => {
          console.error(error);
        });
      // }
    },

    getItemsOnCurrentPage(items) {
      const startIndex = (this.current_page - 1) * this.per_page;
      const endIndex = startIndex + this.per_page;
      return items.slice(startIndex, endIndex);
    },

    changePage(pageNumber) {
      this.current_page = pageNumber;
      this.getHistory(pageNumber);
    },
    changePerPage() {
      this.current_page = 1; // Reset halaman saat per_page berubah
      this.per_page = parseInt(this.per_page);
      this.getHistory();
    },

    approveAgenda(id) {
			this.$axios.post("/suggestions-approve/" + id, {})
      .then(() => {
        alert("Suggestion berhasil ditambahkan ke agenda");
        this.getHistory();
			}).catch((error) => {
				console.log(error.response); 
			});
    },

    denyAgenda(id) {
      // alert("ditolak");
      this.$axios.post("/suggestions-deny/" + id, {})
      .then(() => {
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