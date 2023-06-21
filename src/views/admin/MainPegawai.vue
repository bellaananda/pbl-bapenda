<template>
  <div class="main-panel">
    <div class="content-wrapper">
      <div class="row">
        <div class="col-md-12 grid-margin title">
          <div class="row">
            <div class="col-12 align-items-center">
              <h3 class="font-weight-bold">KELOLA PEGAWAI BAPENDA SURAKARTA</h3>
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
              <div class="card-tools float-right">
                <div class="input-group input-group-sm">
                  <button
                    type="submit"
                    class="btn btn-primary"
                    data-toggle="modal"
                    data-target="#exampleModal"
                    @click.prevent="showModal"
                  >
                    Tambah
                  </button>
                </div>
              </div>
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
                    <tr
                      v-for="(employe, index) in employees"
                      :key="employe.id"
                    >
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
                          href=""
                          class="btn btn-sm btn-inverse-success"
                          @click.prevent="editModal(employe)"
                        >
                          <i class="mdi mdi-pencil btn-icon-prepend"></i>
                        </a>
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
        id="exampleModal"
        tabindex="-1"
        role="dialog"
        aria-labelledby="exampleModalLabel"
        aria-hidden="true"
      >
        <div class="modal-dialog modal-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <!-- Show/hide headings dynamically based on /isFormCreateUserMode value (true/false) -->
              <h5
                v-show="isFormCreateEmployeMode"
                class="modal-title"
                id="exampleModalLabel"
              >
                Tambah Pegawai
              </h5>
              <h5
                v-show="!isFormCreateEmployeMode"
                class="modal-title"
                id="exampleModalLabel"
              >
                Edit Pegawai
              </h5>
              <button
                type="button"
                class="close"
                data-dismiss="modal"
                aria-label="Close"
              >
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <!-- Form for adding/updating user details. When submitted call /createUser() function if /isFormCreateUserMode value is true. Otherwise call /updateUser() function. -->
            <form
              @submit.prevent="
                isFormCreateEmployeMode ? createEmployee() : editEmployee()
              "
            >
              <div class="modal-body">
                <div class="form-group">
                  <label for="nip">NIP</label>
                  <input
                    type="text"
                    class="form-control"
                    v-model="form.nip"
                    :class="{ 'is-invalid': form.errors.has('nip') }"
                    id="nip"
                    placeholder="Masukkan NIP Pegawai"
                  />
                  <has-error :form="form" field="nip"></has-error>
                </div>
                <div class="form-group">
                  <label for="name">Nama Pegawai</label>
                  <input
                    type="text"
                    class="form-control"
                    v-model="form.name"
                    :class="{ 'is-invalid': form.errors.has('name') }"
                    id="name"
                    placeholder="Masukkan Nama Pegawai"
                  />
                  <has-error :form="form" field="name"></has-error>
                </div>
                <div class="form-group">
                  <label for="email">Email</label>
                  <input
                    type="email"
                    class="form-control"
                    v-model="form.email"
                    :class="{ 'is-invalid': form.errors.has('email') }"
                    id="email"
                    placeholder="Masukkan Email Pegawai"
                  />
                  <has-error :form="form" field="email"></has-error>
                </div>
                <div class="form-group">
                  <label for="phone_number">No. Telepon</label>
                  <input
                    type="text"
                    class="form-control"
                    v-model="form.phone_number"
                    :class="{ 'is-invalid': form.errors.has('phone_number') }"
                    id="phone_number"
                    placeholder="Masukkan Nomor Telepon Pegawai"
                  />
                  <has-error :form="form" field="phone_number"></has-error>
                </div>
                <div class="form-group">
                  <label for="address">Alamat</label>
                  <input
                    type="text"
                    class="form-control"
                    v-model="form.address"
                    :class="{ 'is-invalid': form.errors.has('address') }"
                    id="address"
                    placeholder="Masukkan Alamat Pegawai"
                  />
                  <has-error :form="form" field="address"></has-error>
                </div>
                <div v-show="!isFormCreateEmployeMode" class="form-group">
                  <label for="role">Role</label>
                  <select
                    class="form-control"
                    id="role"
                    v-model="form.role"
                    :class="{ 'is-invalid': form.errors.has('role') }"
                  >
                    <option disabled value="">Pilih Role Pegawai</option>
                    <option value="user">User</option>
                    <option value="operator">Operator</option>
                    <option value="admin">admin</option>
                  </select>
                  <has-error :form="form" field="role"></has-error>
                </div>
                <div v-show="!isFormCreateEmployeMode" class="form-group row">
                  <label class="col-sm-3 col-form-label">Status</label>
                  <div class="col-sm-4">
                    <div class="form-check">
                      <input
                        type="radio"
                        class="form-check-input"
                        name="status"
                        id="status"
                        value="1"
                        v-model="form.status"
                        checked
                      />
                      <label class="form-check-label" for="Aktif">
                        Aktif
                      </label>
                    </div>
                  </div>
                  <div class="col-sm-5">
                    <div class="form-check">
                      <input
                        type="radio"
                        class="form-check-input"
                        name="status"
                        id="status"
                        value="0"
                        v-model="form.status"
                      />
                      <label class="form-check-label" for="Nonaktif">
                        Nonaktif
                      </label>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="position">Posisi Pegawai</label>
                  <select
                    class="form-control"
                    id="position"
                    v-model="form.position_id"
                    :class="{ 'is-invalid': form.errors.has('position_id') }"
                  >
                    <option disabled value>Pilih Posisi Pegawai</option>
                    <option
                      v-for="position in positions.data"
                      :key="position.id"
                      :value="position.id"
                    >
                      {{ position.name }}
                    </option>
                  </select>
                  <has-error :form="form" field="position_id"></has-error>
                </div>
                <div class="form-group">
                  <label for="department">Department Pegawai</label>
                  <select
                    class="form-control"
                    id="department"
                    v-model="form.department_id"
                    :class="{ 'is-invalid': form.errors.has('department_id') }"
                  >
                    <option disabled value>Pilih Department Pegawai</option>
                    <option
                      v-for="department in departments.data"
                      :key="department.id"
                      :value="department.id"
                    >
                      {{ department.name }}
                    </option>
                  </select>
                  <has-error :form="form" field="department_id"></has-error>
                </div>
              </div>
              <div class="modal-footer">
                <button
                  type="button"
                  class="btn btn-secondary"
                  data-dismiss="modal"
                >
                  Batalkan
                </button>
                <button
                  type="submit"
                  class="btn btn-primary"
                  v-show="isFormCreateEmployeMode"
                >
                  Simpan
                </button>
                <button
                  type="submit"
                  class="btn btn-primary"
                  v-show="!isFormCreateEmployeMode"
                >
                  Edit
                </button>
              </div>
            </form>
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
              <!-- <p>Posisi Pegawai: {{ getPositionNameById(form.position_id) }}</p> -->
              <!-- <p>Department Pegawai: {{ getDepartmentNameById(form.department_id) }}</p> -->
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
        .then(response => {
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

    editModal(employe) {
      this.isFormCreateEmployeMode = false;
      this.form.fill(employe);
      $("#exampleModal").modal("show");
    },

    editEmployee() {
      const url = `https://api.klikagenda.com/api/employees/${this.form.id}`;
      this.form
        .put(url, {
          headers: {
            Authorization: "Bearer " + localStorage.getItem("access_token"),
          },
        })
        .then(() => {
          $("#exampleModal").modal("hide"); // Sembunyikan modal setelah berhasil memperbarui
          swal.fire({
            icon: "success",
            title: "Pegawai berhasil diperbarui",
          });
          this.getEmployee(); // Perbarui daftar pegawai
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
