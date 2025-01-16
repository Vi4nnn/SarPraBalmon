<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use App\Models\DocumentNumbering;
use Illuminate\Support\Carbon;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

class BorrowingReportExport extends Controller
{
    private string $filename = 'laporan-peminjaman.docx';

    private function generateDocumentNumber(): string
    {
        // Ambil nomor terakhir dari database
        $documentNumber = DocumentNumbering::latest('id')->first();
        $currentDate = Carbon::now()->format('d/m/Y');

        // Buat nomor baru
        if ($documentNumber) {
            $lastNumber = (int) filter_var($documentNumber->current_number, FILTER_SANITIZE_NUMBER_INT);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        // Format nomor surat
        $formattedNumber = sprintf('%03d/BMN/Balmon.73/PL.02/%s', $newNumber, $currentDate);

        // Simpan nomor baru ke database
        DocumentNumbering::create(['current_number' => $formattedNumber]);

        return $formattedNumber;
    }

    public function export(): void
    {
        $phpWord = new PhpWord();
        $section = $phpWord->addSection();

        $documentNumber = $this->generateDocumentNumber();
        
        // Header Dokumen
        $headerStyle = ['alignment' => 'center'];
        $boldStyle = ['bold' => true];

        $section->addText('KEMENTERIAN KOMUNIKASI DAN INFORMATIKA RI', ['size' => 12, 'bold' => true], $headerStyle);
        $section->addText('DIREKTORAT JENDERAL SUMBER DAYA DAN PERANGKAT POS DAN INFORMATIKA', ['size' => 11], $headerStyle);
        $section->addText('BALAI MONITOR SPEKTRUM FREKUENSI RADIO KELAS I MAKASSAR', ['size' => 11], $headerStyle);
        $section->addTextBreak(1);

        $section->addText('FORMULIR PEMINJAMAN/PENGEMBALIAN PERANGKAT SISTEM MONITORING FREKUENSI RADIO', ['size' => 11, 'bold' => true], $headerStyle);
        $section->addText('Nomor: ' . $documentNumber, ['size' => 11], $headerStyle);
        $section->addTextBreak(1);

         // Deskripsi
        $section->addText(
            'Saya yang bertanda tangan di bawah ini menyatakan bahwa benar telah meminjam barang inventaris BALAI MONITOR SPEKTRUM FREKUENSI RADIO KELAS I MAKASSAR sebagai berikut:',
            ['size' => 11]
        );
        $section->addTextBreak(1);

        // Judul
        $section->addText(
            'LAPORAN PEMINJAMAN PERANGKAT',
            ['size' => 11, 'bold' => true],
            $headerStyle
        );

        $section->addTextBreak(1);

        // Ambil Data dari Database
        $borrowings = Borrowing::with('commodity', 'student', 'officer')->get();

        // Tabel Data Peminjaman
        $table = $section->addTable([
            'borderSize' => 6,
            'borderColor' => '000000',
            'cellMargin' => 50,
            'alignment' => 'center',
        ]);

        // Header Tabel
        $table->addRow();
        $table->addCell(500)->addText('NO', $boldStyle, ['alignment' => 'center']);
        $table->addCell(2000)->addText('Nama Barang', $boldStyle, ['alignment' => 'center']);
        $table->addCell(1500)->addText('Nama Pegawai', $boldStyle, ['alignment' => 'center']);
        $table->addCell(2000)->addText('Tanggal', $boldStyle, ['alignment' => 'center']);
        $table->addCell(1500)->addText('Waktu Mulai', $boldStyle, ['alignment' => 'center']);
        $table->addCell(1500)->addText('Waktu Selesai', $boldStyle, ['alignment' => 'center']);

        // Data Tabel
        foreach ($borrowings as $index => $borrowing) {
            $table->addRow();
            $table->addCell(500)->addText($index + 1, [], ['alignment' => 'center']);
            $table->addCell(2000)->addText($borrowing->commodity->name ?? '-', [], ['alignment' => 'left']);
            $table->addCell(1500)->addText($borrowing->student->name ?? '-', [], ['alignment' => 'left']);
            $table->addCell(2000)->addText($borrowing->date ?? '-', [], ['alignment' => 'left']);
            $table->addCell(1500)->addText($borrowing->time_start ?? '-', [], ['alignment' => 'center']);
            $table->addCell(1500)->addText($borrowing->time_end ?? '-', [], ['alignment' => 'center']);
        }

        // Simpan File
        $writer = IOFactory::createWriter($phpWord, 'Word2007');
        $writer->save($this->filename);

        // Unduh File
        $contents = file_get_contents($this->filename);
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        header('Content-Disposition: attachment; filename=' . $this->filename);
        unlink($this->filename);

        exit($contents);
    }
}
