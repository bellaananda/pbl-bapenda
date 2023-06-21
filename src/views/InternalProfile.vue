<template>
  <div class="main-panel">
    <div class="content-wrapper">
      <div class="row">
        <div class="col-md-12 grid-margin title">
          <div class="row">
            <div class="col-12 align-items-center">
              <h3 class="font-weight-bold">PROFILE</h3>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <p class="card-description float-right"></p>
              <div v-if="employeeData" class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <th>Nama</th>
                      <th>NIP</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>{{ employeeData.name }}</td>
                      <td>{{ employeeData.nip }}</td>
                    </tr>
                  </tbody>
                  <thead>
                    <tr>
                      <th>Bidang</th>
                      <th>Posisi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>{{ employeeData.department }}</td>
                      <td>{{ employeeData.position }}</td>
                    </tr>
                  </tbody>
                  <thead>
                    <tr>
                      <th>No. Telepon</th>
                      <th>Alamat Email</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>{{ employeeData.phone_number }}</td>
                      <td>{{ employeeData.email }}</td>
                    </tr>
                  </tbody>
                  <thead>
                    <tr>
                      <th>Status</th>
                      <th>Password</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>{{ employeeData.status_name }}</td>
                      <td>
                        Anda dapat mengubah password dengan menekan tombol
                        <b>Ubah Password</b> di bawah <br />
                        ini. Pastikan anda mencatat atau mengingat password baru
                        anda. Jika selanjutnya anda <br />
                        lupa password maka anda harus menghubungi admin untuk
                        melakukan reset password. <br />
                        <button>Ubah Password</button>
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
export default {
  created() {
    const employeesData = localStorage.getItem("employees");
    if (employeesData) {
      this.$store.commit("setEmployees", JSON.parse(employeesData));
    }

    const userRole = localStorage.getItem("userRole");
    if (userRole) {
      this.$store.commit("SET_USER_ROLE", userRole);
    }
  },
  computed: {
    employeeData() {
      return this.$store.state.employees; // Retrieve the employee data from the Vuex store
    },
    userRole() {
      return this.$store.state.userRole; // Retrieve the user role from the Vuex store
    },
  },
};
</script>
