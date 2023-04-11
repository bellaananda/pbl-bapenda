<template>
  <div class="content-wrapper">
        <div class="row">
          <div class="col-md-12 grid-margin title">
            <div class="row">
              <div class="col-12 align-items-center">
                <h3 class="font-weight-bold">KELOLA DEPARTMENT BAPENDA SURAKARTA</h3>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <p class="card-description float-right">
                  <a href="#" class="btn btn-sm btn-primary btn-icon-text" data-toggle="modal" data-target="#modalCreate">
                    <i class="mdi mdi-plus btn-icon-prepend"></i>
                    Tambah
                  </a>
                </p>
                <div class="table-responsive">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Department</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(department, index) in departments.data" :key="department.id">
                        <td>{{  index + 1 }}</td>
                        <td>{{ department.name }}</td>
                        <td>
                          <a href="#" class="btn btn-sm" data-toggle="modal" data-target="#modalEdit">
                            <i class="mdi mdi-pencil btn-icon-prepend"></i>
                          </a>
                          <a href="" class="btn btn-sm btn-danger" @click.prevent="deleteDepartment(department.id)">
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

        <div class="modal fade" id="modalCreate" aria-labelledby="modalCreateLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content modal-md">
              <div class="modal-header">
                <h5 class="modal-title" id="modalCreateLabel">Form Tambah Department</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
              </div>
              <form class="forms-sample" @submit.prevent="createDepartment()">
                <div class="modal-body">
                  <div class="form-group">
                    <label for="inputDepartments">Department</label>
                      <input type="text" class="form-control" v-model="form.name" :class="{ 'is-invalid': form.errors.has('name') }" id="inputDepartments" placeholder="Department">
                      <has-error :form="form" field="name"></has-error>
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
          <div class="modal fade" id="modalUpdate" aria-labelledby="modalDepartmentLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content modal-md">
              <div class="modal-header">
                <h5 class="modal-title" id="modalKategoriLabel">Form Edit Department</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                  <span aria-hidden="true">×</span>
                </button>
              </div>
              <form class="forms-sample" >
                <div class="modal-body">
                  <div class="form-group">
                    <label for="inputDepartments">Department</label>
                      <input type="text" class="form-control" v-model="form.name" :class="{ 'is-invalid': form.errors.has('name') }" id="inputDepartments" placeholder="Department">
                      <has-error :form="form" field="name"></has-error>
                  </div>
                </div>
                <div class="modal-footer">
                  <button class="btn btn-light" @click="dialogUpdate=false">Batalkan</button>
                  <button type="submit" class="btn btn-primary" @click="updateDepartment()">Update</button>
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
  name: 'DepartmentPegawai',
      data() {
        return {
          departments: {},
          form: new Form({
            id: '',
            name: ''
          }),
          modalCreate: false,
          dialogUpdate: false
        }
      },

      methods: {

        getDepartment(page) {
          if (typeof page === 'undefined') {
            page = 1;
          }
  
          axios.get('http://localhost:8000/api/departments', {
            params: {
              page: page
            }
          }).then(data => {
            this.departments = data.data;
          });     
        },


        createDepartment() {
          // request post
          this.form.post('http://localhost:8000/api/departments', {
          }).then(() => {
            swal.fire({
              icon: 'success',
              title: 'departments created successfully'
              
            })
            this.getDepartment();
            
          }).catch(() => {
            console.log('transaction fail');
          });
        },

        editDepartment(department){
          this.dialogUpdate = false;
          this.form.reset(); // v form reset inputs
          this.form.clear(); // v form clear errors
          this.dialogUpdate = true;
          this.form.fill(department);
        },

        updateDepartment(){
          this.form.put('http://localhost:8000/api/departments/' + this.form.id, {
          }).then(() => {
            swal.fire({
              icon: 'success',
              title: 'Department updated successfully'
            })
            this.getDepartment();
          }).catch(() => {
            console.log('transaction fail');
          });
        }, 

        deleteDepartment(id) {
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
              this.form.delete('http://localhost:8000/api/departments/' + id, {
               }).then(() => {
                // sweet alert success
                swal.fire(
                  'Deleted!',
                  'Your file has been deleted.',
                  'success'
                )   
  
                this.getDepartment(); 
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
        this.getDepartment();
      },
      mounted() {
        console.log('Component mounted.')
      }
}
</script>