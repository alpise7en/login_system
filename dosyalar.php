<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Örnek başlıklar
$headers = [
    'Kod', 'Seri No', 'Üretim Tarihi', 'Çizimlere ve özel taleplere uygunluk', 
    'Dış temizlik ve yüzey kalitesi', 'İç temizlik', 'Boru bağlantılarının terazisi', 
    'İç elemanların uygunluğu', 'Kafadan terazi kontrolü', 'kapak, oring, vida, somun kontrolü',
    'Filtre ayak temizliği', 'Filtre ayağına uygun vida kontrolü', 'Etiketlerin kontrolü',
    'İç elyaf laminasyonu', 'Sonuç', 'Notlar', 'Numarası', 'Kontrol süresi',
    'Kontrol eden', 'Kontrol tarihi', 'Video linki', 'Müşteri'
];

// Örnek veriler
$data = [
    [
        'id' => 1,
        'client' => 'Müşteri Adı',
        'code' => 'Kod123',
        'serial_number' => 'SN456',
        'production_date' => '2023-08-23',
        'compliance_with_drawings_special_requests' => 'Uygun',
        'external_cleaning_surface_quality' => 'Temiz',
        'internal_cleaning_surface_quality' => 'Temiz',
        'scales_of_pipe_connections' => 'Uyumlu',
        'compatibility_of_internal_elements' => 'Uyumlu',
        'checking_the_scale_from_the_head' => 'Kontrol Edildi',
        'checking_the_cover_o_ring_screw_nut' => 'Kontrol Edildi',
        'filter_foot_cleaning' => 'Temiz',
        'screw_checking_suitable_for_filter_foot' => 'Uygun',
        'checking_the_labels' => 'Kontrol Edildi',
        'internal_fiber_lamination' => 'Lamine Edildi',
        'result' => 'Olumlu',
        'number' => 'Num123',
        'notes' => 'Özel notlar burada',
        'checker' => 'Kontrolcü Adı',
        'check_time' => '12:34',
        'check_date' => '2023-08-23',
        'video_link' => 'https://example.com/video123'
    ],
    // Diğer veriler burada olacak
];


$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Başlıkları ekleme
$col = 'A';
foreach ($headers as $header) {
    $sheet->setCellValue($col . '1', $header);
    $col++;
}

// Verileri ekleme
$row = 2;
foreach ($data as $item) {
    $col = 'A';
    foreach ($item as $value) {
        $sheet->setCellValue($col . $row, $value);
        $col++;
    }
    $row++;
}

// Excel dosyasını kaydetme
$writer = new Xlsx($spreadsheet);
$filename = 'veriler.xlsx';
$writer->save($filename);

// Dosyayı indirme
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');
$writer->save('php://output');

?>