<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require '../vendor/autoload.php'; 
include('../database/connectdb.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$sheet->setCellValue('A1', 'STT');
$sheet->setCellValue('B1', 'ID Người đặt');
$sheet->setCellValue('C1', 'Số hóa đơn');
$sheet->setCellValue('D1', 'Tổng tiền');
$sheet->setCellValue('E1', 'Ngày đặt');

$query = "SELECT * FROM `user_orders` WHERE order_status = 'confirmed' ";
$stmt = $con->prepare($query);
$stmt->execute();
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (empty($orders)) {
    echo "No data found.";
    exit();
}

$rowNumber = 2; 
$number = 1;

foreach ($orders as $row) {
    $sheet->setCellValue('A' . $rowNumber, $number++);
    $sheet->setCellValue('B' . $rowNumber, $row['user_id']);
    $sheet->setCellValue('C' . $rowNumber, $row['invoice_number']);
    $sheet->setCellValue('D' . $rowNumber, number_format($row['total_price'], 0, ',', '.') . " VND");
    $sheet->setCellValue('E' . $rowNumber, $row['order_date']);
    $rowNumber++;
}

ob_end_clean();

$fileName = 'danh_sach_don_hang.xlsx';
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment; filename=\"$fileName\"");

$writer = new Xlsx($spreadsheet);
$writer->save("php://output");
exit();
?>
