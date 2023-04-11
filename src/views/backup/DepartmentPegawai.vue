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
                        <th>Department</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(departments, index) in posts" :key="index">
                        <td>{{ departments.id }}</td>
                        <td>{{ departments.name }}</td>
                        <td>
                          <a href="#" class="btn btn-sm" data-toggle="modal" data-target="#modalEdit">
                            <i class="mdi mdi-pencil btn-icon-prepend"></i>
                          </a>
                          <a v-on:click="postDelete(posts.id)" class="btn btn-sm">
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

        <div class="modal fade" id="modalTambah" aria-labelledby="ModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content modal-md">
              <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel">Form Tambah Department</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                  <form class="forms-sample" @submit.prevent="store">
                      <div class="form-group">
                        <label for="inputDepartments">Department</label>
                        <input type="text" class="form-control" v-model="post.name" id="inputDepartment" placeholder="Department">
                        <div v-if="validation.name" class="mt-2 alert alert-danger">
                          {{ validation.name[0] }}
                        </div>
                      </div>
                      <button type="submit" class="btn btn-primary mr-2">Simpan</button>
                      <button class="btn btn-light">Batalkan</button>
                  </form>
              </div>
            </div>
          </div>
        </div>
         
        <div class="modal fade" id="modalEdit" aria-labelledby="ModalLabel">
        <div class="modal-dialog" role="document">
          <div class="modal-content modal-md">
            <div class="modal-header">
              <h5 class="modal-title" id="ModalLabel">Form Edit Department</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form @submit.prevent="update" class="forms-sample">
                <div class="form-group">
                  <label for="inputDepartment">Department</label>
                  <input type="text" class="form-control" id="inputDepartment" v-model="post.name" placeholder="Department">
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
      </div>
    </div>    
</template>

<script>
import axios from 'axios'
import { onMounted, ref, reactive } from 'vue'
import { useRouter, useRoute } from 'vue-router'

export default {
setup() {

  //read
  let posts = ref([])

  onMounted(() => {
    axios.get('http://localhost:8000/api/departments')
    .then(response => {
      posts.value = response.data.data
    }).catch(error => {
     console.log(error.response.data)
    })
  })

  //create
  const post = reactive({
    name: ''
  })

  const validation = ref([])
  const router = useRouter()

  function store() {
    let name = post.name

    axios.post('http://localhost:8000/api/departments', {
      name: name
    }).then(() => {
      router.push ({
        name: 'departments.index'
      })
    }).catch(error => {
     validation.value = error.response.data
    })
  }

  //update
  const route = useRoute()

  onMounted(() => {

    axios.get(`http://localhost:8000/api/departments${route.params.id}`)
    .then(response => {
      post.name    = response.data.data.name
    }).catch(error => {
      console.log(error.response.data)
    })
  })
  
  
  function update() {
    let name = post.name

    axios.put(`http://localhost:8000/apidepartments/${route.params.id}`, {
      name: name,
    }).then(() => {
        router.push({
          name: 'departments.index'
      })
    }).catch(error => {
        validation.value = error.response.data
    })
  }

  //delete
  function postDelete(id) {
    axios.delete("http://localhost:8000/api/departments/" + id)
    .then(() => {
      const index = this.posts.findIndex(post => post.id === id)

      if(~index) {
        this.posts.splice(index, 1)
      }
    }).catch(error => {
      console.log(error.response.data)
    })
  }

  return {
    posts,
    post,
    validation,
    router,
    store,
    update,
    postDelete
  }
}
}
</script>