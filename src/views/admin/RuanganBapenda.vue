<template>
  <div class="content-wrapper">
        <div class="row">
          <div class="col-md-12 grid-margin title">
            <div class="row">
              <div class="col-12 align-items-center">
                <h3 class="font-weight-bold">KELOLA RUANG BAPENDA SURAKARTA</h3>
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
                  <table class="table table-hover">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Ruang Agenda</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(room, index) in rooms.data" :key="room.id">
                        <td>{{ index+1 }}</td>
                        <td>{{ room.name }}</td>
                        <td>
                          <a href="" class="btn btn-sm" @click.prevent="editRoom(room)" >
                            <i class="mdi mdi-pencil btn-icon-prepend"></i>
                          </a>
                          <a href="" class="btn btn-sm" @click.prevent="deleteRoom(room.id)">
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

        <div class="modal fade" id="modalCreate" aria-labelledby="ModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content modal-md">
              <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel">Form Tambah Ruang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <form class="forms-sample" @submit.prevent="createRoom()">
                <div class="modal-body">
                  <div class="form-group">
                    <label for="inputRooms">Ruang</label>
                      <input type="text" class="form-control" v-model="form.name" :class="{ 'is-invalid': form.errors.has('name') }" id="inputRooms" placeholder="Ruangan">
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
          <div class="modal fade" id="modalUpdate" aria-labelledby="modalRoomLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content modal-md">
              <div class="modal-header">
                <h5 class="modal-title" id="modalRoomLabel">Form Edit Room</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                  <span aria-hidden="true">×</span>
                </button>
              </div>
              <form class="forms-sample" >
                <div class="modal-body">
                  <div class="form-group">
                    <label for="inputRoom">Ruang</label>
                      <input type="text" class="form-control" v-model="form.name" :class="{ 'is-invalid': form.errors.has('name') }" id="inputRoom" placeholder="Ruangan">
                      <has-error :form="form" field="name"></has-error>
                  </div>
                </div>
                <div class="modal-footer">
                  <button class="btn btn-light" @click="dialogUpdate=false">Batalkan</button>
                  <button type="submit" class="btn btn-primary" @click="updateRoom()">Update</button>
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
      name: 'RuanganBapenda',
      data() {
        return {
          rooms: {},
          form: new Form({
            id: '',
            name: ''
          }),
          modalCreate: false
        }
      },

      methods: {

        getRooms(page) {
          if (typeof page === 'undefined') {
            page = 1;
          }
  
          axios.get('http://localhost:8000/api/rooms', {
            params: {
              page: page
            }
          }).then(data => {
            this.rooms = data.data;
          });     
        },

        createRoom() {
          // request post
          this.form.post('http://localhost:8000/api/rooms', {
          }).then(() => {
            swal.fire({
              icon: 'success',
              title: 'rooms created successfully'
            })
            this.getRooms();
            // this.modalCreate = false
            
          }).catch(() => {
            console.log('transaction fail');
          });
        },

        editRoom(room){
          this.dialogUpdate = false;
          this.form.reset(); // v form reset inputs
          this.form.clear(); // v form clear errors
          this.dialogUpdate = true; // show modal
          this.form.fill(room);
        },

        updateRoom(){
          this.form.put('http://localhost:8000/api/rooms/' + this.form.id, {
          }).then(() => {
            swal.fire({
              icon: 'success',
              title: 'User updated successfully'
            })
            this.getRooms();
          }).catch(() => {
            console.log('transaction fail');
          });
        }, 

        deleteRoom(id) {
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
              this.form.delete('http://localhost:8000/api/rooms/' + id, {
               }).then(() => {
                // sweet alert success
                swal.fire(
                  'Deleted!',
                  'Your file has been deleted.',
                  'success'
                )   
  
                this.getRooms(); 
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
        this.getRooms();
      },
      mounted() {
        console.log('Component mounted.')
      }
    }
</script>