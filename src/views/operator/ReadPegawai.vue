<template>
  <div class="main-panel">
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
        <div class="col-lg-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Data Pegawai</h4>
              <div class="table-responsive">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>NIP</th>
                      <th>Nama</th>
                      <th>No. Telp</th>
                      <th>Role</th>
                      <th>Status</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(employe, index) in employees" :key="employe.id">
                      <td>{{ (current_page - 1) * per_page + index + 1 }}</td>
                      <td>{{ employe.nip }}</td>
                      <td>{{ employe.name }}</td>
                      <td>{{ employe.phone_number }}</td>
                      <td>
                        {{ employe.role }}
                      </td>
                      <td>
                        <template v-if="employe.status === '1'">
                          <span class="badge badge-success">Aktif</span>
                        </template>
                        <template v-else-if="employe.status === '0'">
                          <span class="badge badge-warning">Nonaktif</span>
                        </template>
                      </td>
                      <td>
                        <a
                          class="btn btn-sm btn-inverse-warning"
                          @click.prevent="showDetailModal(employe)"
                        >
                          <i
                            class="mdi mdi-file-document-box-outline btn-icon-prepend"
                          ></i>
                        </a>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
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

      <div
        class="modal fade"
        id="detailModal"
        tabindex="-1"
        role="dialog"
        aria-labelledby="detailModalLabel"
        aria-hidden="true"
      >
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="detailModalLabel">Detail Pegawai</h5>
              <button
                type="button"
                class="close"
                data-dismiss="modal"
                aria-label="Close"
              >
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <!-- Tampilkan informasi detail pegawai di sini -->
              <p>NIP: {{ form.nip }}</p>
              <p>Nama: {{ form.name }}</p>
              <p>Email: {{ form.email }}</p>
              <p>No. Telepon: {{ form.phone_number }}</p>
              <p>Alamat: {{ form.address }}</p>
              <p>Role: {{ form.role }}</p>
              <p>Status: {{ form.status }}</p>
              <!-- <p>Posisi Pegawai: {{ getPositionNameById(form.position_id) }}</p>
              <p>Department Pegawai: {{ getDepartmentNameById(form.department_id) }}</p> -->
            </div>
            <div class="modal-footer">
              <button
                type="button"
                class="btn btn-secondary"
                data-dismiss="modal"
              >
                Tutup
              </button>
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
  name: "PegawaiBapenda",
  data() {
    return {
      employees: {},
      positions: {},
      departments: {},
      current_page: 1,
      per_page: 15,
      totalItems: 0,
      totalPages: 0,
      search: "",
      form: new Form({
        id: "",
        nip: "",
        name: "",
        email: "",
        password: "",
        phone_number: "",
        address: "",
        role: "",
        status: "",
        position_id: "",
        department_id: "",
      }),
      isFormCreateEmployeMode: true,
    };
  },

  methods: {
    searchAgenda() {
      this.current_page = 1; // Reset halaman saat melakukan pencarian
      this.getEmployee();
    },

    previousPage() {
      if (this.current_page > 1) {
        this.current_page--;
        this.getEmployee();
      }
    },
    nextPage() {
      if (this.current_page < this.totalPages) {
        this.current_page++;
        this.getEmployee();
      }
    },

    getEmployee(page = 1) {
      this.$axios
        .get("/employees", {
          params: {
            page: page,
            per_page: this.per_page,
            search: this.search,
          },
        })
        .then((response) => {
          this.employees = this.getItemsOnCurrentPage(response.data.data);
          this.totalItems = response.data.data.length;
          this.totalPages = Math.ceil(this.totalItems / this.per_page);
        })
        .catch((error) => {
          console.error(error);
        });
    },

    getItemsOnCurrentPage(items) {
      const startIndex = (this.current_page - 1) * this.per_page;
      const endIndex = startIndex + this.per_page;
      return items.slice(startIndex, endIndex);
    },

    changePage(pageNumber) {
      this.current_page = pageNumber;
      this.getEmployee(pageNumber);
    },
    changePerPage() {
      this.current_page = 1; // Reset halaman saat per_page berubah
      this.per_page = parseInt(this.per_page);
      this.getEmployee();
    },

    showModal() {
      this.isFormCreateEmployeMode = true;
      this.form.reset(); // v form reset
      $("#exampleModal").modal("show"); // show modal
    },

    getPosition() {
      this.$axios
        .get("/positions")
        .then((response) => {
          this.positions = response.data.data;
        })
        .catch((error) => {
          console.error(error);
        });
    },

    getDepartment() {
      this.$axios
        .get("/departments")
        .then((response) => {
          this.departments = response.data.data;
        })
        .catch((error) => {
          console.error(error);
        });
    },

    //   getPositionNameById(positionId) {
    //   const position = this.positions.data.find(position => position.id === positionId);
    //   return position ? position.name : "";
    // },
    // getDepartmentNameById(departmentId) {
    //   const department = this.departments.data.find(department => department.id === departmentId);
    //   return department ? department.name : "";
    // },

    createEmployee() {
      // request post
      this.form
        .post("https://api.klikagenda.com/api/employees", {
          headers: {
            Authorization: "Bearer " + localStorage.getItem("access_token"),
          },
        })
        .then(() => {
          $("#exampleModal").modal("hide");
          swal.fire({
            icon: "success",
            title: "Pegawai berhasil ditambahkan",
          });
          this.getEmployee();
        })
        .catch((error) => {
          console.error(error);
        });
    },

    showDetailModal(employe) {
      const employeId = employe.id;
      this.$axios
        .get(`/employees/${employeId}`)
        .then(() => {
          this.form.fill(employe);
          $("#detailModal").modal("show");
        })
        .catch((error) => {
          console.error(error);
        });
    },
  },

  created() {
    this.getEmployee();
    this.getPosition();
    this.getDepartment();
  },
  mounted() {
    console.log("Component mounted.");
  },
};
</script>
