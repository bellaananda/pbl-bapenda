<template>
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
          <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <p class="card-description float-right">
                  <a href="#" class="btn btn-sm btn-success btn-icon-text" data-toggle="modal" data-target="#modalCreate">
                    <i class="mdi mdi-plus btn-icon-prepend"></i>
                    Tambah
                  </a>
                </p>
                <div class="table-responsive">
                  <table class="table table-hover">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>NIP</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>No. Telp</th>
                        <th>Alamat</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(employee, index) in employees.data" :key="employee.id">
                        <td>{{ index + 1}}</td>
                        <td>{{ employee.name }}</td>
                        <td>
                          <a href="" class="btn btn-sm btn-primary" @click.prevent="editEmployee(employee)" data-toggle="modal" data-target="#modalUpdate">
                            <i class="mdi mdi-pencil btn-icon-prepend"></i>
                          </a>
                          <a href="" class="btn btn-sm btn-danger" @click.prevent="deleteEmployee(employee.id)">
                              <i class="mdi mdi-delete btn-icon-prepend"></i>
                          </a>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="modal fade" id="modalCreate" aria-labelledby="modalPegawaiLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content modal-md">
              <div class="modal-header">
                <h5 class="modal-title" id="modalPegawaiLabel">Form Tambah Pegawai</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
              </div>
              <form class="forms-sample" @submit.prevent="createEmployee()">
                <div class="modal-body">
                  <div class="form-group">
                    <label for="inputEmployees">NIP</label>
                      <input type="text" class="form-control" v-model="form.nip" :class="{ 'is-invalid': form.errors.has('nip') }" id="inputEmployees" placeholder="Masukkan NIP Pegawai">
                      <has-error :form="form" field="nip"></has-error>
                  </div>
                  <div class="form-group">
                    <label for="inputEmployees">Nama Pegawai</label>
                      <input type="text" class="form-control" v-model="form.name" :class="{ 'is-invalid': form.errors.has('name') }" id="inputEmployees" placeholder="Masukkan Nama Pegawai">
                      <has-error :form="form" field="name"></has-error>
                  </div>
                  <div class="form-group">
                    <label for="inputEmployees">Email</label>
                      <input type="text" class="form-control" v-model="form.email" :class="{ 'is-invalid': form.errors.has('email') }" id="inputEmployees" placeholder="Masukkan Email Pegawai">
                      <has-error :form="form" field="email"></has-error>
                  </div>
                  <div class="form-group">
                    <label for="inputEmployees">No. Telepon</label>
                      <input type="text" class="form-control" v-model="form.phone_number" :class="{ 'is-invalid': form.errors.has('phone_number') }" id="inputEmployees" placeholder="Masukkan Nomor Telepon Pegawai">
                      <has-error :form="form" field="phone_number"></has-error>
                  </div>
                  <div class="form-group">
                    <label for="inputEmployees">Alamat</label>
                      <input type="text" class="form-control" v-model="form.address" :class="{ 'is-invalid': form.errors.has('address') }" id="inputEmployees" placeholder="Masukkan Alamat Pegawai">
                      <has-error :form="form" field="address"></has-error>
                  </div>
                  <div class="form-group">
                    <label for="inputEmployees">Role Pegawai</label>
                      <input type="text" class="form-control" v-model="form.role" :class="{ 'is-invalid': form.errors.has('role') }" id="inputEmployees" placeholder="Masukkan Role Pegawai">
                      <has-error :form="form" field="role"></has-error>
                  </div>
                  <div class="form-group">
                    <label for="inputEmployees">Status Pegawai</label>
                      <input type="text" class="form-control" v-model="form.status" :class="{ 'is-invalid': form.errors.has('status') }" id="inputEmployees" placeholder="Masukkan Status Pegawai">
                      <has-error :form="form" field="status"></has-error>
                  </div>
                </div>
                <div class="modal-footer">
                  <button class="btn btn-light">Batalkan</button>
                  <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
              </form>
            </div>
          </div>
        </div>

        <v-dialog v-model="dialogUpdate">
          <div class="modal fade" id="modalUpdate" aria-labelledby="modalKategoriLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content modal-md">
              <div class="modal-header">
                <h5 class="modal-title" id="modalKategoriLabel">Form Edit Kategori</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                  <span aria-hidden="true">×</span>
                </button>
              </div>
              <form class="forms-sample" >
                <div class="modal-body">
                  <div class="form-group">
                    <label for="inputEmployees">NIP</label>
                      <input type="text" class="form-control" v-model="form.nip" :class="{ 'is-invalid': form.errors.has('nip') }" id="inputEmployees" placeholder="Masukkan NIP Pegawai">
                      <has-error :form="form" field="nip"></has-error>
                  </div>
                  <div class="form-group">
                    <label for="inputEmployees">Nama Pegawai</label>
                      <input type="text" class="form-control" v-model="form.name" :class="{ 'is-invalid': form.errors.has('name') }" id="inputEmployees" placeholder="Masukkan Nama Pegawai">
                      <has-error :form="form" field="name"></has-error>
                  </div>
                  <div class="form-group">
                    <label for="inputEmployees">Email</label>
                      <input type="text" class="form-control" v-model="form.email" :class="{ 'is-invalid': form.errors.has('email') }" id="inputEmployees" placeholder="Masukkan Email Pegawai">
                      <has-error :form="form" field="email"></has-error>
                  </div>
                  <div class="form-group">
                    <label for="inputEmployees">No. Telepon</label>
                      <input type="text" class="form-control" v-model="form.phone_number" :class="{ 'is-invalid': form.errors.has('phone_number') }" id="inputEmployees" placeholder="Masukkan Nomor Telepon Pegawai">
                      <has-error :form="form" field="phone_number"></has-error>
                  </div>
                  <div class="form-group">
                    <label for="inputEmployees">Alamat</label>
                      <input type="text" class="form-control" v-model="form.address" :class="{ 'is-invalid': form.errors.has('address') }" id="inputEmployees" placeholder="Masukkan Alamat Pegawai">
                      <has-error :form="form" field="address"></has-error>
                  </div>
                  <div class="form-group">
                    <label for="inputEmployees">Role Pegawai</label>
                      <input type="text" class="form-control" v-model="form.role" :class="{ 'is-invalid': form.errors.has('role') }" id="inputEmployees" placeholder="Masukkan Role Pegawai">
                      <has-error :form="form" field="role"></has-error>
                  </div>
                  <div class="form-group">
                    <label for="inputEmployees">Status Pegawai</label>
                      <input type="text" class="form-control" v-model="form.status" :class="{ 'is-invalid': form.errors.has('status') }" id="inputEmployees" placeholder="Masukkan Status Pegawai">
                      <has-error :form="form" field="status"></has-error>
                  </div>
                </div>
                <div class="modal-footer">
                  <button class="btn btn-light" @click="dialogUpdate=false">Batalkan</button>
                  <button type="submit" class="btn btn-primary" @click="updateCategori()">Update</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        </v-dialog>

      </div>
</template>

<script>
import { Form } from 'vform'
import axios from 'axios'
import swal from 'sweetalert2';

  export default {
      name: 'PegawaiBapenda',
      data() {
        return {
          employees: {},
          form: new Form({
            id: '',
            nip: '',
            name: '',
            email: '',
            phone_number: '',
            address: '',
            role:'',
            status:'',
          }),
          modalCreate: false,
          dialogUpdate: false
        }
      },

      methods: {

        getEmployee(page) {
          if (typeof page === 'undefined') {
            page = 1;
          }
  
          axios.get('http://localhost:8000/api/employees', {
            params: {
              page: page
            }
          }).then(data => {
            this.employees = data.data;
          });     
        },


        createEmployee() {
          // request post
          this.form.post('http://localhost:8000/api/employees', {
          }).then(() => {
            swal.fire({
              icon: 'success',
              title: 'employees created successfully'
              
            })
            this.getEmployee();
            
          }).catch(() => {
            console.log('transaction fail');
          });
        },

        editEmployee(employee){
          this.dialogUpdate = false;
          this.form.reset(); // v form reset inputs
          this.form.clear(); // v form clear errors
          this.dialogUpdate = true;
          this.form.fill(employee);
        },

        updateEmployee(){
          this.form.put('http://localhost:8000/api/employees/' + this.form.id, {
          }).then(() => {
            swal.fire({
              icon: 'success',
              title: 'employees updated successfully'
            })
            this.getEmployee();
          }).catch(() => {
            console.log('transaction fail');
          });
        }, 

        deleteEmployee(id) {
          // sweet alert confirmation
          swal.fire({
            title: 'Ingin menghapus data?',
            // text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya hapus data'
          }).then((result) => {
            // confirm delete?
            if (result.value) {
              // request delete
              this.form.delete('http://localhost:8000/api/employees/' + id, {
               }).then(() => {
                // sweet alert success
                swal.fire(
                  'Deleted!',
                  'Your file has been deleted.',
                  'success'
                )   
  
                this.getEmployee(); 
              }).catch(() => {
                // sweet alert fail
                swal.fire({
                  icon: 'error',
                  title: 'Oops...',
                  text: 'Something went wrong!',
                  footer: '<a href>Why do I have this issue?</a>'
                })
              }); 
            }
          })
        }
      },

      created() {
        this.getEmployee();
      },
      mounted() {
        console.log('Component mounted.')
      }
    }
</script>