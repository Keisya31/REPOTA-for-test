<?php

namespace App\Imports;

use App\Models\Mahasiswa;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MahasiswaImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {

        return new Mahasiswa([
            'nim'      => $row['nim'],
            'mhs_nama' => $row['nama'],
            'status'   => $row['status'],
            'semester' => $row['semester'],
            'kelas'    => $row['kelas'],
        ]);
      
    }
}