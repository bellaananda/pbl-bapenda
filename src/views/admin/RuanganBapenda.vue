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
          <div class="col-md-12 grid-margin">
            <div class="row">
              <div class="col-lg-5">
                <input type="text" placeholder="Search..." name="cari" id="cari" class="form-control">
              </div>
            </div>
          </div>
        </div> 
        <div class="row">
          <div class="col-lg-6 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">Data Ruang</h4>
                <div class="table-responsive">
                  <table class="table table-hover">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Ruangan</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(room, index) in rooms.data" :key="room.id">
                        <template v-if="editId == room.id">
                          <td>{{ index + 1}}</td>
                          <td><input v-model="editRoomData.name" type="text"></td>
                          <td>
                            <a href="" class="btn btn-sm btn-inverse-success" @click.prevent="editRoom(room.id)">
                              <i class="mdi mdi-check btn-icon-prepend"></i>
                            </a>
                            <a href="" class="btn btn-sm btn-inverse-danger" @click.prevent="onCancel()">
                              <i class="mdi mdi-close btn-icon-prepend"></i>
                            </a>
                          </td>
                        </template>
                        <template v-else>
                          <td>{{ index + 1}}</td>
                          <td>{{ room.name }}</td>
                          <td>
                            <a href="" class="btn btn-sm btn-inverse-warning" @click.prevent="onEdit(room)">
                              <i class="mdi mdi-pencil btn-icon-prepend"></i>
                            </a>
                            <a href="" class="btn btn-sm btn-inverse-danger" @click.prevent="deleteRoom(room.id)">
                              <i class="mdi mdi-delete btn-icon-prepend"></i>
                            </a>
                          </td>
                        </template>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Form Tambah Ruangan Bapenda</h4>
                  <div class="table-responsive">
                    <form class="forms-sample" v-on:submit.prevent="createRoom()">
                      <div class="form-group">
                        <label for="inputRooms">Ruang</label>
                        <input type="text" class="form-control" v-model="form.name" :class="{ 'is-invalid': form.errors.has('name') }" id="inputRooms" placeholder="Masukkan Nama Ruangan">
                        <has-error :form="form" field="name"></has-error>
                      </div>
                      <button type="submit" class="btn btn-primary mr-2">Simpan</button>
                      <!-- <button class="btn btn-light">Batalkan</button> -->
                    </form>
                  </div>
                </div>
              </div>
          </div>
        </div>
        <div class="row">
            <div class="col-6">
              <nav aria-label="Page navigation example">
                <ul class="pagination">
                  <li class="page-item">
                    <a class="page-link" href="#" aria-label="Previous">
                      <span aria-hidden="true">&laquo;</span>
                      <span class="sr-only">Previous</span>
                    </a>
                  </li>
                  <li class="page-item"><a class="page-link" href="#">1</a></li>
                  <li class="page-item"><a class="page-link" href="#">2</a></li>
                  <li class="page-item"><a class="page-link" href="#">3</a></li>
                  <li class="page-item">
                    <a class="page-link" href="#" aria-label="Next">
                      <span aria-hidden="true">&raquo;</span>
                      <span class="sr-only">Next</span>
                    </a>
                  </li>
                </ul>
              </nav>
            </div>
            <div class="col-6 col-xl-4">
              <!-- <div id="search_processes" class="center">   <div id="filter_content" class="table pull-left"> -->
                <table id="table_filters">
                  <tr id="row_special">
                    <td class="exp">
                      <label>Records per Page:</label>
                      <select id="records_comboBox">
                        <option id="any" value="any">Any</option>
                        <option id="10" value="10">10</option>
                        <option id="25" value="25">25</option>
                        <option id="50" value="50">50</option>
                      </select>
                    </td>
                  </tr>
                </table>   
              <!-- </div>    -->
            </div> 
        </div>
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
          editId: '',
          rooms: {},
          form: new Form({
            id: '',
            name: ''
          }),
          editRoomData: {
            name: ''
          },
        }
      },

      methods: {

        getRoom(page) {
          if (typeof page === 'undefined') {
            page = 1;
          }
  
          axios.get('https://v3421024.mhs.d3tiuns.com/api/rooms', {
            params: {
              page: page
            }
          }).then(data => {
            this.rooms = data.data.data;
          });     
        },


        createRoom() {
          // request post
          this.form.post('https://v3421024.mhs.d3tiuns.com/api/rooms', {
          }).then(() => {
            swal.fire({
              icon: 'success',
              title: 'Rooms created successfully'
              
            })
            this.getRoom();
            
          }).catch(() => {
            console.log('transaction fail');
          });
        },

        onEdit(room){
          this.editId = room.id
          this.editRoomData.name = room.name
        },

        onCancel(){
          this.editId = ''
          this.editRoomData.name = ''
        },

        editRoom(id){
          let name        = this.editRoomData.name
          this.editId = ''
           axios.put('https://v3421024.mhs.d3tiuns.com/api/rooms/' + id, {
            name: name
          }).then(() => {
            swal.fire({
              icon: 'success',
              title: 'Room updated successfully'
            })
            this.getRoom();

          }).catch(() => {
            console.log('transaction fail');
          });
        }, 

        deleteRoom(id) {
          // sweet alert confirmation
          swal.fire({
            title: 'Ingin menghapus data?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya hapus data'
          }).then((result) => {
            // confirm delete?
            if (result.value) {
              // request delete
              this.form.delete('https://v3421024.mhs.d3tiuns.com/api/rooms/' + id, {
               }).then(() => {
                // sweet alert success
                swal.fire(
                  'Deleted!',
                  'Your file has been deleted.',
                  'success'
                )   
  
                this.getRoom(); 
              }).catch(() => {
                // sweet alert fail
                swal.fire({
                  icon: 'error',
                  title: 'Oops...',
                  text: 'Something went wrong!',
                  // footer: '<a href>Why do I have this issue?</a>'
                })
              }); 
            }
          })
        }
      },

      created() {
        this.getRoom();
      },
      mounted() {
        console.log('Component mounted.')
      }
    }
</script>