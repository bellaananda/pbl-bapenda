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
                <h4 class="card-title">Data Posisi</h4>
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
                      <tr v-for="(category, index) in categories.data" :key="category.id">
                        <template v-if="editId == category.id">
                          <td>{{ index + 1}}</td>
                          <td><input v-model="editCategoryData.name" type="text"></td>
                          <td>
                            <a href="" class="btn btn-sm btn-inverse-success" @click.prevent="editCategory(category.id)">
                              <i class="mdi mdi-check btn-icon-prepend"></i>
                            </a>
                            <a href="" class="btn btn-sm btn-inverse-danger" @click.prevent="onCancel()">
                              <i class="mdi mdi-close btn-icon-prepend"></i>
                            </a>
                          </td>
                        </template>
                        <template v-else>
                          <td>{{ index + 1}}</td>
                          <td>{{ category.name }}</td>
                          <td>
                            <a href="" class="btn btn-sm btn-inverse-warning" @click.prevent="onEdit(category)">
                              <i class="mdi mdi-pencil btn-icon-prepend"></i>
                            </a>
                            <a href="" class="btn btn-sm btn-inverse-danger" @click.prevent="deleteCategory(category.id)">
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
                  <h4 class="card-title">Form Tambah Kategori Agenda</h4>
                  <div class="table-responsive">
                    <form class="forms-sample" v-on:submit.prevent="createCategory()">
                      <div class="form-group">
                        <label for="inputCategories">Kategori Agenda</label>
                        <input type="text" class="form-control" v-model="form.name" :class="{ 'is-invalid': form.errors.has('name') }" id="inputCategories" placeholder="Masukkan Kategori Agenda">
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
      name: 'KategoriAgenda',
      data() {
        return {
          editId: '',
          categories: {},
          form: new Form({
            id: '',
            name: ''
          }),
          editCategoryData: {
            name: ''
          },
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
            this.categories = data.data.data;
          });     
        },


        createCategory() {
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

        onEdit(category){
          this.editId = category.id
          this.editCategoryData.name = category.name
        },

        onCancel(){
          this.editId = ''
          this.editCategoryData.name = ''
        },

        editCategory(id){
          let name        = this.editCategoryData.name
          this.editId = ''
           axios.put('http://localhost:8000/api/categories/' + id, {
            name: name
          }).then(() => {
            swal.fire({
              icon: 'success',
              title: 'Category updated successfully'
            })
            this.getCategories();

          }).catch(() => {
            console.log('transaction fail');
          });
        }, 

        deleteCategory(id) {
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