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
          <div class="col-md-12 grid-margin">
            <div class="row">
              <div class="col-lg-5">
                <input type="text" placeholder="Search..." name="cari" id="cari" class="form-control">
              </div>
            </div>
          </div>
        </div> 
        <div class="row">
          <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">Data Pegawai</h4>
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
                      <tr v-for="(user, index) in users.data" :key="user.id">
                          <td>{{ index + 1}}</td>
                          <td>{{ user.nip }}</td>
                          <td>{{ user.name }}</td>
                          <td>{{ user.email }}</td>
                          <td>{{ user.phone_number }}</td>
                          <td>{{ user.address }}</td>
                          <td>{{ user.role }}</td>
                          <td>{{ user.status }}</td>
                          <td>
                            <!-- <a href="" class="btn btn-sm btn-inverse-warning" @click.prevent="onEdit(user)">
                              <i class="mdi mdi-pencil btn-icon-prepend"></i>
                            </a>
                            <a href="" class="btn btn-sm btn-inverse-danger" @click.prevent="deleteUser(user.id)">
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
// import { Form } from 'vform'
import axios from 'axios'
// import swal from 'sweetalert2';

  export default {
      name: 'PegawaiBapenda',
      data() {
        return {
          editId: '',
          users: {},
        }
      },

      methods: {

        getUser(page) {
          if (typeof page === 'undefined') {
            page = 1;
          }
  
          axios.get('http://localhost:8000/api/users', {
            params: {
              page: page
            }
          }).then(data => {
            this.users = data.data.data;
          });     
        },
      },

      created() {
        this.getUser();
      },
      mounted() {
        console.log('Component mounted.')
      }
    }
</script>