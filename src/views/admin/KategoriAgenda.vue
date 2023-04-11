<template>
  <div class="content-wrapper">
        <div class="row">
          <div class="col-md-12 grid-margin title">
            <div class="row">
              <div class="col-12 align-items-center">
                <h3 class="font-weight-bold">KELOLA KATEGORI BAPENDA SURAKARTA</h3>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <p class="card-description float-right">
                  <a href="#" class="btn btn-sm btn-success btn-icon-text" data-toggle="modal" data-target="#modalKategori">
                    <i class="mdi mdi-plus btn-icon-prepend"></i>
                    Tambah
                  </a>
                </p>
                <div class="table-responsive">
                  <table class="table table-hover">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Kategori Agenda</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(categori, index) in categories.data" :key="categori.id">
                        <td>{{ index + 1}}</td>
                        <td>{{ categori.name }}</td>
                        <td>
                          <a href="" class="btn btn-sm btn-primary" @click.prevent="editCategori(categori)" data-toggle="modal" data-target="#modalUpdate">
                            <i class="mdi mdi-pencil btn-icon-prepend"></i>
                          </a>
                          <a href="" class="btn btn-sm btn-danger" @click.prevent="deleteCategori(categori.id)">
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

        <div class="modal fade" id="modalKategori" aria-labelledby="modalKategoriLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content modal-md">
              <div class="modal-header">
                <h5 class="modal-title" id="modalKategoriLabel">Form Tambah Kategori</h5>
                <!-- <h5 v-show="isFormCreateCategoriMode" class="modal-title" id="modalKategoriLabel">Form Edit Kategori</h5> -->
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
              </div>
              <form class="forms-sample" @submit.prevent="createCategori()">
                <div class="modal-body">
                  <div class="form-group">
                    <label for="inputCategories">Kategori</label>
                      <input type="text" class="form-control" v-model="form.name" :class="{ 'is-invalid': form.errors.has('name') }" id="inputCategories" placeholder="Kategori">
                      <has-error :form="form" field="name"></has-error>
                  </div>
                </div>
                <div class="modal-footer">
                  <button class="btn btn-light">Batalkan</button>
                  <button type="submit" class="btn btn-primary">Save changes</button>
                  <!-- <button type="submit" class="btn btn-primary" v-show="isFormCreateCategoriMode">Update</button> -->
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
                <!-- <h5 v-show="isFormCreateCategoriMode" class="modal-title" id="modalKategoriLabel">Form Edit Kategori</h5> -->
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                  <span aria-hidden="true">×</span>
                </button>
              </div>
              <form class="forms-sample" >
                <div class="modal-body">
                  <div class="form-group">
                    <label for="inputCategories">Kategori</label>
                      <input type="text" class="form-control" v-model="form.name" :class="{ 'is-invalid': form.errors.has('name') }" id="inputCategories" placeholder="Kategori">
                      <has-error :form="form" field="name"></has-error>
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
      name: 'KategoriAgenda',
      data() {
        return {
          categories: {},
          form: new Form({
            id: '',
            name: ''
          }),
          modalKategori: false,
          dialogUpdate: false
        }
      },

      methods: {

        getCategories(page) {
          if (typeof page === 'undefined') {
            page = 1;
          }
  
          axios.get('http://localhost:8000/api/categories', {
            params: {
              page: page
            }
          }).then(data => {
            this.categories = data.data;
          });     
        },


        createCategori() {
          // request post
          this.form.post('http://localhost:8000/api/categories', {
          }).then(() => {
            // this.modalKategori = false;
            swal.fire({
              icon: 'success',
              title: 'Categories created successfully'
              
            })
            this.getCategories();
            
          }).catch(() => {
            console.log('transaction fail');
          });
        },

        editCategori(categori){
          this.dialogUpdate = false;
          this.form.reset(); // v form reset inputs
          this.form.clear(); // v form clear errors
          this.dialogUpdate = true;
          this.form.fill(categori);
          this.updateCategori();
        },

        updateCategori(){
          this.form.put('http://localhost:8000/api/categories/' + this.form.id, {
          }).then(() => {
            swal.fire({
              icon: 'success',
              title: 'User updated successfully'
            })
            this.getCategories();
          }).catch(() => {
            console.log('transaction fail');
          });
        }, 

        deleteCategori(id) {
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
              this.form.delete('http://localhost:8000/api/categories/' + id, {
               }).then(() => {
                // sweet alert success
                swal.fire(
                  'Deleted!',
                  'Your file has been deleted.',
                  'success'
                )   
  
                this.getCategories(); 
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
        this.getCategories();
      },
      mounted() {
        console.log('Component mounted.')
      }
    }
</script>