<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);


// Include necessary files
require_once 'config.php';
require_once 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Set the timezone to Istanbul
date_default_timezone_set('Europe/Istanbul');

// Function to download and generate Excel file
function downloadExcelFile($table_name, $filename_prefix)
{
    global $conn;

    // Fetch form data from MySQL

    if ($table_name === 'pump_section_periodic_check') {
        // order by date, time value
        $query = "SELECT * FROM $table_name ORDER BY date DESC, time DESC";
    } elseif (
        $table_name === 'manufacturing_approval_form' ||
        $table_name === 'pompa_final_quality_control' ||
        $table_name === 'white_product_and_electronic_form'
        || $table_name === 'rotation_shell_quality_control'
        || $table_name === 'valve_periodic_control_form'
        || $table_name === 'filtration_control'
    ) {
        $query = "SELECT * FROM $table_name ORDER BY date_time DESC";
    } else {
        $query = "SELECT * FROM $table_name ORDER BY id DESC";
    }

    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        // Create Excel spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Get current download date and time
        $downloadDateTime = date('Y-m-d_H-i-s');
        $downloadDate = date('Y-m-d');
        $downloadHour = date('H:i:s');

        // Set download date and time in the first column
        $sheet->setCellValue('A1', 'Download Date');
        $sheet->setCellValue('A2', $downloadDate);
        $sheet->setCellValue('A3', 'Download Time');
        $sheet->setCellValue('A4', $downloadHour);

        // Set column headers starting from the second column
        $col = 'B';
        $row = 1;
        $fieldinfo = $result->fetch_fields();
        foreach ($fieldinfo as $field) {
            $sheet->setCellValue($col . $row, $field->name);
            $col++;
        }

        // Set data rows starting from the second column
        $row = 2;
        while ($rowdata = $result->fetch_assoc()) {
            $col = 'B';
            foreach ($rowdata as $value) {
                $sheet->setCellValue($col . $row, $value);
                $col++;
            }
            $row++;
        }

        // Save Excel file
        $filename = $filename_prefix . $downloadDateTime . '.xlsx';
        $writer = new Xlsx($spreadsheet);
        $writer->save($filename);

        // Download the file
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        readfile($filename);

        // Delete the temporary file
        unlink($filename);

        // Stop script execution
        exit();
    } else {
        echo "No data found in the $table_name table.";
        // header("Location: dosyalar.php");
    }
}

// Fetch the username and user role from the session
session_start();

        // Handle form download based on the requested form type
        if (isset($_GET['form_type'])) {
            if ($_GET['form_type'] === 'quality_control_forms') {
                downloadExcelFile('quality_control_forms', 'quality_control_forms_');
            } elseif ($_GET['form_type'] === 'multiway_valve_control_form') {
                downloadExcelFile('multiway_valve_control_form', 'multiway_valve_control_form_');
            } elseif ($_GET['form_type'] === 'assembly_quality_control_form') {
                downloadExcelFile('assembly_quality_control_form', 'assembly_quality_control_form_');
            } elseif ($_GET['form_type'] === 'ladder_final_control') {
                downloadExcelFile('ladder_final_control', 'ladder_quality_control_forms_');
            } elseif ($_GET['form_type'] === 'filtration_control') {
                downloadExcelFile('filtration_control', 'filtration_quality_control_forms_');
            } elseif ($_GET['form_type'] === 'valve_periodic_control_form') {
                downloadExcelFile('valve_periodic_control_form', 'valve_periodic_control_forms_');
            } elseif ($_GET['form_type'] === 'pump_section_periodic_check') {
                downloadExcelFile('pump_section_periodic_check', 'pump_section_periodic_control_forms_');
            } elseif ($_GET['form_type'] === 'rotation_shell_quality_control') {
                downloadExcelFile('rotation_shell_quality_control', 'rotation_shell_quality_control_forms_');
            } elseif ($_GET['form_type'] === 'white_product_and_electronic_form') {
                downloadExcelFile('white_product_and_electronic_form', 'white_product_and_electronic_control_forms_');
            } elseif ($_GET['form_type'] === 'pompa_final_quality_control') {
                downloadExcelFile('pompa_final_quality_control', 'pompa_final_quality_control_forms_');
            } elseif ($_GET['form_type'] === 'manufacturing_approval_form') {
                downloadExcelFile('manufacturing_approval_form', 'manufacturing_approval_forms_');
            } else {
                echo "Invalid form type.";
                header("Location: dosyalar.php");
                exit();
            }
        } else {
            echo "Form type not specified.";
            header("Location: dosyalar.php");
            exit();
        }

?>