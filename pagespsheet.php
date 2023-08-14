<?php
session_start();
include('connection/getConnection.php');

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

if(isset($_POST['save_excel_data'])) {
    $fileName = $_FILES['import_file']['name'];
    $file_ext = pathinfo($fileName, PATHINFO_EXTENSION);

    $allowed_ext = ['xls', 'csv', 'xlsx'];

    if(in_array($file_ext, $allowed_ext)) {
        $inputFileNamePath = $_FILES['import_file']['tmp_name'];
        $spreadsheet = IOFactory::load($inputFileNamePath);
        $worksheet = $spreadsheet->getActiveSheet();
        $data = $worksheet->toArray();

        $count = 0;
        $cusername = $_SESSION['name'];

        foreach($data as $row) {
            if($count > 0) {
                $studentname = $row[0];
                $dob = $row[1];
                $age = $row[2];
                $address = $row[3];
                $studentphone = $row[4];

                $studentQuery = "INSERT INTO studentinfo (studentname, dob, age, address, studentphone, cusername) VALUES (?, ?, ?, ?, ?, ?)";

                $stmt = $pdo->prepare($studentQuery);
                $stmt->execute([$studentname, $dob, $age, $address, $studentphone, $cusername]);
                $result = $stmt->rowCount();
                if($result) {
                    $_SESSION['message'] = "Successfully Imported";
                } else {
                    $_SESSION['message'] = "Error while importing data";
                    break;
                }
            } else {
                $count = 1;
            }
        }

        header("Location: pagedashboard.php?name=". urlencode($cusername));
        exit;
    } else {
        $_SESSION['message'] = "Invalid File";
        header("Location: " . $_SERVER['PHP_SELF'] . "?name=" . urlencode($cusername));
        exit;
    }
}
?>
