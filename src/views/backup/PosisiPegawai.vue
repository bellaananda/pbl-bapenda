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
                  <a href="#" class="btn btn-sm btn-primary btn-icon-text" data-toggle="modal" data-target="#modalTambah">
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
                          <!-- <a href="#" class="btn btn-sm" data-toggle="modal" data-target="#modalEdit">
                            <i class="mdi mdi-pencil btn-icon-prepend"></i>
                          </a>
                          <a v-on:click="postDelete(position.id)" class="btn btn-sm">
                              <i class="mdi mdi-delete btn-icon-prepend"></i>
                          </a> -->
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="modal fade" id="modalTambah" aria-labelledby="ModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content modal-md">
              <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel">Form Tambah Posisi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                  <form class="forms-sample">
                      <div class="form-group">
                        <label for="inputPositions">Posisi</label>
                        <input type="text" class="form-control" v-model="post_name" id="inputPositions" placeholder="Posisi Pegawai">
                        <!-- <div v-if="validation.name" class="mt-2 alert alert-danger">
                          {{ validation.name[0] }}
                        </div> -->
                      </div>
                      <button class="btn btn-primary mr-2" @click="createPosisi">Simpan</button>
                      <button class="btn btn-light" @click="modalTambah = false">Batalkan</button>
                  </form>
              </div>
            </div>
          </div>
        </div>
         
        <!-- <div class="modal fade" id="modalEdit" aria-labelledby="ModalLabel">
        <div class="modal-dialog" role="document">
          <div class="modal-content modal-md">
            <div class="modal-header">
              <h5 class="modal-title" id="ModalLabel">Form Edit Posisi</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form @submit.prevent="update" class="forms-sample">
                <div class="form-group">
                  <label for="inputPositions">Posisi</label>
                  <input type="text" class="form-control" id="inputPositions" v-model="post.name" placeholder="Posisi Pegawai">
                  <div v-if="validation.nama" class="mt-2 alert alert-danger">
                    {{ validation.name[0] }}
                  </div>
                </div>
                <button type="submit" class="btn btn-primary mr-2">Simpan</button>
                <button class="btn btn-light">Batalkan</button>
              </form>
            </div>
          </div>
        </div>
      </div> -->
      </div>

      
</template>

<script>
// import { Form } from 'vform'
import axios from 'axios'
// import swal from 'sweetalert2';

export default{
  name: 'PosisiPegawai',
      data() {
        return {
          positions: {},
          modalTambah: false
        }
      },

      methods: {
        getPositions(page) {
          if (typeof page === 'undefined') {
            page = 1;
          }
  
          axios.get('http://localhost:8000/api/positions', {
            params: {
              page: page
            }
          }).then(data => {
            this.positions = data.positions;
          }); 
        }
      },

      created() {
        this.getPositions();
      },
      mounted() {
        console.log('Component mounted.')
      }
}
</script>