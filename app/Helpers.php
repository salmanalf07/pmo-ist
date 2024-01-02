<?php


function randomHexColor()
{
    $characters = '0123456789ABCDEF';
    $color = '#';
    for ($i = 0; $i < 6; $i++) {
        $color .= $characters[rand(0, 15)];
    }
    return $color;
}



function vlookupInKamus($record, $kamus)
{
    foreach ($kamus as $item) {
        if ($item['key'] === $record) {
            return $item['value'];
        }
    }
    // Jika tidak ditemukan, kembalikan nilai record asli
    return $record;
}

function formatAngka($angka)
{
    if ($angka != 0) {
        $satuan = ['', 'K', 'M', 'B', 'T']; // Menambahkan satuan seperti K (ribu), M (juta), B (miliar), dan T (triliun) sesuai kebutuhan
        $posisi = floor(log($angka, 1000));
        $nilai = $angka / pow(1000, $posisi);
        $nilai = number_format($nilai, 2); // Membatasi hanya 2 angka di belakang koma
        return $nilai . ' ' . $satuan[$posisi];
    } else {
        return 0;
    }
}

function getInitials($name)
{
    $words = explode(' ', $name);
    $initials = '';

    for ($i = 0; $i < min(count($words), 2); $i++) {
        $initials .= strtoupper(substr($words[$i], 0, 1));
    }

    return $initials;
}
