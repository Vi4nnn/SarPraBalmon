@extends('layouts.app')

@section('title', 'Peminjaman Hari Ini')
@section('description', 'Halaman Daftar Peminjaman Hari Ini')

@section('content')
<section class="row">
  <div class="col-12">
    @include('utilities.alert')
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">@yield('title')</h4>
      </div>
      <div class="card-body">
        <div class="alert alert-warning" role="alert">
          <i class="bi bi-exclamation-circle"></i>
          Setiap data peminjaman dari mahasiswa petugas wajib melakukan validasi dengan menekan tombol
          validasi
          pada data di tabel agar petugas bisa memberikan pertanggung jawaban jika terjadinya barang yang
          hilang. Silahkan petugas melakukan validasi jika jam kembali sudah terisi. Jika jam kembali sudah terisi maka
          barang yang dipinjam telah dikembalikan oleh pegawai tersebut.

          <div class="fw-bold pt-3">Diharapkan kembali petugas sebelum melakukan validasi melakukan cek terhadap
            barang yang sudah
            dipinjam apakah benar sudah dikembalikan.</div>
        </div>


        <x-filter-menu>
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="student_id" class="form-label">Pegawai:</label>
                <select name="student_id" id="student_id" class="form-select">
                  <option value="">Pilih pegawai.</option>
                  @foreach ($students as $student)
                  <option value="{{ $student->id }}" @selected(request('student_id')==$student->id)>{{
                    $student->identification_number }} - {{ $student->name }}
                  </option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="status" class="form-label">Status pengembalian:</label>
                <select name="status" id="status" class="form-select">
                  <option value="" @selected(request('status')==='' )>Pilih status pengembalian..</option>
                  <option value="1" @selected(request('status')==='1' )>Sudah dikembalikan</option>
                  <option value="0" @selected(request('status')==='0' )>Belum dikembalikan</option>
                </select>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="validate" class="form-label">Status validasi:</label>
                <select name="validate" id="validate" class="form-select">
                  <option value="" @selected(request('validate')==='' )>Pilih status validasi..</option>
                  <option value="1" @selected(request('validate')==='1' )>Sudah divalidasi</option>
                  <option value="0" @selected(request('validate')==='0' )>Belum divalidasi</option>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="commodity_id" class="form-label">Barang:</label>
                <select name="commodity_id" id="commodity_id" class="form-select">
                  <option value="">Pilih Barang..</option>
                  @foreach ($commodities as $commodity)
                  <option value="{{ $commodity->id }}" @selected(request('commodity_id')==$commodity->id)>{{
                    $commodity->name }}
                  </option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>

          <x-slot name="resetButtonURL">{{ route('officers.borrowings.index') }}</x-slot>
        </x-filter-menu>

        <div class="table-responsive">
          <table class="table datatable">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Nama Mahasiswa</th>
                <th scope="col">Barang</th>
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
                <td>{{ $borrowing->getDateFormatted() }}</td>
                <td>
                  <span class="badge text-bg-secondary">
                    <i class="bi bi-clock-fill"></i>
                    {{ $borrowing->time_start }}
                  </span>
                </td>
                <td>
                  @if($borrowing->time_end === NULL)
                  <span class="badge text-bg-info" data-bs-toggle="tooltip" data-bs-placement="top"
                    data-bs-title="Sedang dipinjam">
                    <i class="bi bi-clock"></i></span>
                  @else
                  <span class="badge text-bg-secondary">
                    <i class="bi bi-clock-fill"></i>
                    {{ $borrowing->time_end }}
                  </span>
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
                    @if($borrowing->time_end !== NULL && $borrowing->officer_id === NULL)
                    <form action="{{ route('officers.borrowings.validate', $borrowing) }}">
                      <button type="submit" class="btn btn-sm btn-info btn-validate" data-bs-toggle="tooltip"
                        data-bs-placement="top" data-bs-title="Validasi">
                        <i class="bi bi-person-lines-fill"></i>
                      </button>
                    </form>
                    @endif

                    <button type="button" class="btn btn-sm btn-success showBorrowingButton" data-bs-toggle="modal"
                      data-id="{{ $borrowing->id }}" data-bs-target="#detailBorrowingModal">
                      <i class="bi bi-eye-fill"></i>
                    </button>
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
@include('officer.borrowing.main.modal.show')
@endpush

@push('script')
@include('officer.borrowing.script')
@endpush
