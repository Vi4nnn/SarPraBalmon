@extends('layouts.app')

@section('title', 'Peminjaman Hari Ini')
@section('description', 'Halaman Daftar Peminjaman Hari Ini')

@section('content')
<section class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">@yield('title')</h4>
      </div>
      <div class="card-body">
        @include('utilities.alert')
        <div class="alert alert-warning" role="alert">
          <i class="bi bi-exclamation-circle"></i>
          Setiap data peminjaman dari mahasiswa petugas wajib melakukan validasi dengan menekan tombol
          validasi
          pada data di tabel agar petugas bisa memberikan pertanggung jawaban jika terjadinya komoditas yang
          hilang. Silahkan petugas melakukan validasi jika jam kembali sudah terisi. Jika jam kembali sudah terisi maka
          komoditas yang dipinjam telah dikembalikan oleh mahasiswa tersebut.

          <div class="fw-bold pt-3">Diharapkan kembali petugas sebelum melakukan validasi melakukan cek terhadap
            komoditas yang sudah
            dipinjam apakah benar sudah dikembalikan.</div>
        </div>

        <div class="alert alert-info" role="alert">
          Secara default data peminjaman akan tampil dengan tanggal hari ini. Jika ingin melihat data
          peminjaman
          dengan tanggal yang spesifik bisa menggunakan fitur pencarian di bawah.
        </div>
        <form action="" method="GET">
          <div class="d-flex">
            <div class="flex-fill">
              <label for="date" class="form-label">Tanggal:</label>
              <div class="input-group">
                <span class="input-group-text">
                  <div>
                    <i class="bi bi-calendar-date-fill"></i>
                  </div>
                </span>
                <input type="date" name="date" id="date" class="form-control" placeholder="Pilih tanggal..">
              </div>
            </div>
          </div>

          <div class="d-flex pt-3 pb-3">
            <button type="submit" class="btn btn-primary flex-fill">Cari</button>
          </div>
        </form>

        <div class="table-responsive">
          <table class="table" id="datatable">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Nama Mahasiswa</th>
                <th scope="col">Komoditas</th>
                <th scope="col">Tanggal</th>
                <th scope="col">Jam Pinjam</th>
                <th scope="col">Jam Kembali</th>
                <th scope="col">Petugas</th>
                <th scope="col">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($borrowings as $borrowing)
              <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <th>
                  <span class="badge text-bg-primary" data-bs-toggle="tooltip" data-bs-placement="top"
                    data-bs-title="{{ $borrowing->student->identification_number }}">{{
                    $borrowing->student->name }}</span>
                </th>
                <td>{{ $borrowing->commodity->name }}</td>
                <td>{{ $borrowing->date }}</td>
                <td>{{ $borrowing->time_start }}</td>
                <td>
                  @if($borrowing->time_end === NULL)
                  <span class="badge text-bg-info" data-bs-toggle="tooltip" data-bs-placement="top"
                    data-bs-title="Sedang dipinjam">
                    <i class="bi bi-clock"></i></span>
                  @endif
                </td>
                <td>
                  @if($borrowing->officer_id !== NULL)
                  <span class="badge text-bg-success" data-bs-toggle="tooltip" data-bs-placement="top"
                    data-bs-title="Sudah divalidasi oleh {{ $borrowing->officer->name }}">
                    <i class="bi bi-check-circle"></i>
                  </span>
                  @else
                  <span class="badge text-bg-warning" data-bs-toggle="tooltip" data-bs-placement="top"
                    data-bs-title="Belum divalidasi oleh petugas!">
                    <i class="bi bi-exclamation-circle"></i>
                  </span>
                  @endif
                </td>
                <td>
                  <div class="btn-group gap-1">
                    @if($borrowing->officer_id === NULL)
                    <form action="{{ route('officers.borrowings.validate', $borrowing) }}">
                      <button type="submit" class="btn btn-sm btn-info" data-bs-toggle="tooltip" data-bs-placement="top"
                        data-bs-title="Validasi">
                        <i class="bi bi-person-lines-fill"></i>
                      </button>
                    </form>
                    @endif

                    <button type="button" class="btn btn-sm btn-success showBorrowingButton" data-bs-toggle="modal"
                      data-id="#" data-bs-target="#showBorrowingModal">
                      <i class="bi bi-eye-fill"></i>
                    </button>

                    <form action="#" method="POST">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-sm btn-danger btn-delete"><i
                          class="bi bi-trash-fill"></i></button>
                    </form>
                  </div>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

@push('modal')
@include('administrator.borrowing.main.modal.show')
@endpush

@push('script')
@include('administrator.borrowing.script')
@endpush