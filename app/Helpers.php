<?php

use Carbon\Carbon;

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

function record($log, $description, $err)
{
    $activity = activity()
        ->withProperties(['login_ip' => request()->ip(), 'status' => $err])
        ->log($description);
    $activity->log_name = $log; // Set log_name
    $activity->save(); // Simpan aktivitas dengan log_name yang telah ditetapkan
}

function tentukanStatusProyek($startDate, $dueDate, $progressTask)
{
    // Jika startDate atau dueDate null, langsung skip pengecekan durasi
    if (is_null($startDate) || is_null($dueDate)) {
        if ($progressTask == 100) {
            return "Completed";
        }
    } else {
        if ($progressTask == 100) {
            return "Completed";
        }

        if (Carbon::parse($dueDate)->greaterThan(Carbon::parse($startDate))) {
            // Menghitung durasi antara start date dan due date
            $durasiTotal = Carbon::parse($startDate)->diffInDays(Carbon::parse($dueDate));

            // Menghitung durasi antara start date dan hari ini
            $durasiBerlalu = Carbon::parse($startDate)->diffInDays(Carbon::now());

            // Menghitung persentase waktu yang telah berlalu
            $persentaseWaktu = ($durasiBerlalu / $durasiTotal) * 100;

            // Memeriksa kondisi untuk status proyek
            if (Carbon::now()->greaterThan(Carbon::parse($dueDate)) && $progressTask < 100) {
                return "Off Track";
            } elseif ($progressTask < $persentaseWaktu) {
                return "At Risk";
            } else {
                return "On Track";
            }
        }
    }
}
