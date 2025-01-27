<div class="modal fade" id="detailBorrowingModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5">Detail Peminjaman</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12 col-lg-6">
            <div class="alert alert-primary">
              Data di bawah adalah detail data pegawai.
            </div>
            <div class="row">
              <div class="col-md-12 col-lg-6">
                <div class="mb-3">
                  <label class="form-label">Nomor Identitas Karyawan</label>
                  <input class="form-control" id="student_identification_number" disabled>
                </div>
              </div>
              <div class="col-md-12 col-lg-6">
                <div class="mb-3">
                  <label class="form-label">Nama Pegawai</label>
                  <input class="form-control" id="student_name" disabled>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 col-lg-6">
                <div class="mb-3">
                  <label class="form-label">Divisi</label>
                  <div class="input-group">
                    <span class="d-block input-group-text"><i class="bi bi-bookmarks-fill"></i></span>
                    <input class="form-control" id="program_study_name" disabled>
                  </div>
                </div>
              </div>
              {{-- <div class="col-md-6 col-lg-6">
                <div class="mb-3">
                  <label class="form-label">Kelas</label>
                  <div class="input-group">
                    <span class="d-block input-group-text"><i class="bi bi-building-fill"></i></span>
                    <input class="form-control" id="school_class_name" disabled>
                  </div>
                </div>
              </div>
            </div> --}}

            <div class="row">
              <div class="col-md-12">
                <div class="mb-3">
                  <label class="form-label">Nomor Handphone</label>
                  <div class="input-group">
                    <span class="d-block input-group-text"><i class="bi bi-telephone-fill"></i></span>
                    <input class="form-control" id="student_phone_number" disabled>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-12 col-lg-6">
            <div class="alert alert-primary">
              Data di bawah adalah detail data peminjaman.
            </div>
            <div class="row">
              <div class="col-md-12 col-lg-12">
                <div class="mb-3">
                  <label class="form-label">Nama Barang</label>
                  <div class="input-group">
                    <span class="d-block input-group-text"><i class="bi bi-collection-fill"></i></span>
                    <input class="form-control" id="commodity_name" disabled>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12 col-lg-12">
                <div class="mb-3">
                  <label class="form-label">Tanggal</label>
                  <div class="input-group">
                    <span class="d-block input-group-text"><i class="bi bi-calendar-fill"></i></span>
                    <input class="form-control" id="date" disabled>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 col-lg-6">
                <div class="mb-3">
                  <label class="form-label">Jam Pinjam</label>
                  <div class="input-group">
                    <span class="d-block input-group-text"><i class="bi bi-clock-fill"></i></span>
                    <input class="form-control" id="time_start" disabled>
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-lg-6">
                <div class="mb-3">
                  <label class="form-label">Jam Kembali</label>
                  <div class="input-group">
                    <span class="d-block input-group-text"><i class="bi bi-clock-fill"></i></span>
                    <input class="form-control" id="time_end" disabled>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="mb-3">
                  <label class="form-label">Status</label>
                  <input class="form-control" id="is_returned" disabled>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="mb-3">
                  <label class="form-label">Catatan</label>
                  <textarea class="form-control" id="note" disabled style="height: 100px"></textarea>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary close-button" data-bs-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>
</div>
