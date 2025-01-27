@extends('layouts.app')
@section('title', 'Laporan Peminjaman')
@section('description', 'Halaman Laporan Peminjaman')
@section('content')
<section class="row">
  <div class="col-12">
    @include('utilities.alert')
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">@yield('title')</h4>
      </div>
      <div class="card-body">
        <x-filter-menu>
          <div class="row">
            <div class="col-md-4">
              <div class="mb-3">
                <label for="student_id" class="form-label">Pegawai:</label>
                <select name="student_id" id="student_id" class="form-select">
                  <option value="">Pilih Pegawai..</option>
                  @foreach ($students as $student)
                  <option value="{{ $student->id }}" @selected(request('student_id')==$student->id)>{{
                    $student->identification_number }} - {{ $student->name }}
                  </option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-4">
              <div class="mb-3">
                <label for="program_study_id" class="form-label">Divisi:</label>
                <select name="program_study_id" id="program_study_id" class="form-select">
                  <option value="">Pilih Divisi..</option>
                  @foreach ($programStudies as $programStudy)
                  <option value="{{ $programStudy->id }}" @selected(request('program_study_id')==$programStudy->id)>{{
                    $programStudy->name }}
                  </option>
                  @endforeach
                </select>
              </div>
            </div>
            {{-- <div class="col-md-4">
              <div class="mb-3">
                <label for="school_class_id" class="form-label">Kelas:</label>
                <select name="school_class_id" id="school_class_id" class="form-select">
                  <option value="">Pilih kelas..</option>
                  @foreach ($schoolClasses as $schoolClass)
                  <option value="{{ $schoolClass->id }}" @selected(request('school_class_id')==$schoolClass->id)>{{
                    $schoolClass->name }}
                  </option>
                  @endforeach
                </select>
              </div>
            </div>
          </div> --}}

          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="start_date">Tanggal Awal:</label>
              </div>
              <div class="input-group">
                <span class="input-group-text">
                  <div><i class="bi bi-calendar-date-fill"></i></div>
                </span>
                <input type="date" class="form-control" name="start_date" id="start_date"
                  value="{{ request('start_date') }}" placeholder="Pilih tanggal awal..">
              </div>
            </div>

            <div class="col-md-6">
              <div class="mb-3">
                <label for="end_date">Tanggal Akhir:</label>
              </div>
              <div class="input-group">
                <span class="input-group-text">
                  <div><i class="bi bi-calendar-date-fill"></i></div>
                </span>
                <input type="date" class="form-control" name="end_date" id="end_date" value="{{ request('end_date') }}"
                  placeholder="Pilih tanggal akhir..">
              </div>
            </div>
          </div>

          <x-slot name="resetButtonURL">{{ route('officers.borrowings-report.index') }}</x-slot>
        </x-filter-menu>

        <div class="d-flex flex-row-reverse pb-3">
          <form action="{{ route('officers.borrowings-report.export') }}" method="POST">
            @csrf
            <input type="hidden" name="start_date" value="{{ request('start_date') }}">
            <input type="hidden" name="end_date" value="{{ request('end_date') }}">
            <input type="hidden" name="program_study_id" value="{{ request('program_study_id') }}">
            <input type="hidden" name="student_id" value="{{ request('student_id') }}">
            <input type="hidden" name="school_class_id" value="{{ request('school_class_id') }}">
            <button class="btn btn-success" type="submit"><i class="bi bi-file-earmark-excel-fill"></i></button>
          </form>
        </div>

        <div class="table-responsive">
          <table class="table datatable">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Nama Pegawai</th>
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
@include('officer.borrowing.report.modal.show')
@endpush

@push('script')
@include('officer.borrowing.script')
@endpush
