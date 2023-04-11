<template>
    <div class="content-wrapper">
      <div class="row">
        <div class="col-md-12 grid-margin title">
          <div class="row">
            <div class="col-12 align-items-center">
              <h3 class="font-weight-bold">AGENDA BAPENDA SURAKARTA</h3>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <div class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Judul Agenda</th>
                      <th>Tanggal</th>
                      <th>Waktu</th>
                      <th>Lokasi</th>
                      <th>Disposisi</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>1</td>
                      <td>Rapat rutin bulan Maret</td>
                      <td>9 Maret 2023</td>
                      <td>08.00 - 10.00</td>
                      <td>Ruang A13</td>
                      <td>Bidang Pendataan</td>
                      <td>
                        <a href="#" class="btn btn-sm" data-toggle="modal" data-target="#modalDetail">
                          <i class="mdi mdi-file-document-box-outline btn-icon-prepend"></i>
                        </a>
                      </td>
                    </tr>
                    <tr>
                      <td>2</td>
                        <td>Rapat rutin bulan Maret</td>
                        <td>9 Maret 2023</td>
                        <td>09.00 - 11.00</td>
                        <td>Ruang A13</td>
                        <td>Bidang Penagihan</td>
                        <td>
                          <a href="#" class="btn btn-sm" data-toggle="modal" data-target="#modalDetail">
                            <i class="mdi mdi-file-document-box-outline btn-icon-prepend"></i>
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
      <div class="row">
        <div class="col-md-12 grid-margin">
          <div class="row">
            <div class="col-3 button-generate">
              <button type="button" class="btn btn-primary btn-lg btn-block" data-toggle="modal" data-target="#modalDetail">
                <i class="ti-printer"></i>                      
                  Generate Agenda
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
</template>