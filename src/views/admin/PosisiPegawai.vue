<template>
  <div class="content-wrapper">
        <div class="row">
          <div class="col-md-12 grid-margin title">
            <div class="row">
              <div class="col-12 align-items-center">
                <h3 class="font-weight-bold">KELOLA POSISI BAPENDA SURAKARTA</h3>
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
                        <th>Posisi</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(position, index) in positions.data" :key="position.id">
                        <td>{{ index + 1}}</td>
                        <td>{{ position.name }}</td>
                        <td>
                          <a href="" class="btn btn-sm btn-primary" @click.prevent="editPosition(position)" data-toggle="modal" data-target="#modalUpdate">
                            <i class="mdi mdi-pencil btn-icon-prepend"></i>
                          </a>
                          <a href="" class="btn btn-sm btn-danger" @click.prevent="deletePosition(position.id)">
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
                <h5 class="modal-title" id="modalCreateLabel">Form Tambah Posisi Pegawai</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
              </div>
              <form class="forms-sample" @submit.prevent="createPosition()">
                <div class="modal-body">
                  <div class="form-group">
                    <label for="inputPositions">Posisi Pegawai</label>
                      <input type="text" class="form-control" v-model="form.name" :class="{ 'is-invalid': form.errors.has('name') }" id="inputPositions" placeholder="Masukkan Posisi Pegawai">
                      <has-error :form="form" field="name"></has-error>
                  </div>
                </div>
                <div class="modal-footer">
                  <button class="btn btn-light" @click="modalCreate=false">Batalkan</button>
                  <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
              </form>
            </div>
          </div>
        </div>

        <v-dialog v-model="dialogUpdate">
          <div class="modal fade" id="modalUpdate" aria-labelledby="modalUpdateLabel">
            <div class="modal-dialog" role="document">
              <div class="modal-content modal-md">
                <div class="modal-header">
                  <h5 class="modal-title" id="modalUpdateLabel">Form Edit Posisi Pegawai</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                    <span aria-hidden="true">×</span>
                  </button>
                </div>
                <form class="forms-sample" >
                  <div class="modal-body">
                    <div class="form-group">
                      <label for="inputPositions">Posisi Pegawai</label>
                      <input type="text" class="form-control" v-model="form.name" :class="{ 'is-invalid': form.errors.has('name') }" id="inputPositions" placeholder="Masukkan Posisi Pegawai">
                      <has-error :form="form" field="name"></has-error>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button class="btn btn-light" @click="dialogUpdate=false">Batalkan</button>
                    <button type="submit" class="btn btn-primary" @click="updatePosition()">Update</button>
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

export default{
  name: 'PosisiPegawai',
  data() {
        return {
          positions: {},
          form: new Form({
            id: '',
            name: ''
          }),
          modalCreate: false,
          dialogUpdate: false
        }
      },

      methods: {

        getPosition(page) {
          if (typeof page === 'undefined') {
            page = 1;
          }
  
          axios.get('http://localhost:8000/api/positions', {
            params: {
              page: page
            }
          }).then(data => {
            this.positions = data.data;
          });     
        },


        createPosition() {
          // request post
          this.form.post('http://localhost:8000/api/positions', {
          }).then(() => {
            this.modalCreate = false;
            swal.fire({
              icon: 'success',
              title: 'positions created successfully'
              
            })
            this.getPosition();
          }).catch(() => {
            console.log('transaction fail');
          });
        },

        editPosition(position){
          this.dialogUpdate = false;
          this.form.reset(); // v form reset inputs
          this.form.clear(); // v form clear errors
          this.dialogUpdate = true;
          this.form.fill(position);
        },

        updatePosition(){
          this.form.put('http://localhost:8000/api/positions/' + this.form.id, {
          }).then(() => {
            swal.fire({
              icon: 'success',
              title: 'Position updated successfully'
            })
            this.getPosition();
          }).catch(() => {
            console.log('transaction fail');
          });
        }, 

        deletePosition(id) {
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
              this.form.delete('http://localhost:8000/api/positions/' + id, {
               }).then(() => {
                // sweet alert success
                swal.fire(
                  'Deleted!',
                  'Your file has been deleted.',
                  'success'
                )   
  
                this.getPosition(); 
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
        this.getPosition();
      },
      mounted() {
        console.log('Component mounted.')
      }
}
</script>