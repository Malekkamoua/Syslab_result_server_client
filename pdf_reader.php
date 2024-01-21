<?php
if (isset($_GET['file'])) {
    $pdfFileUrl = './data/' . urldecode($_GET['file']);
    if (file_exists($pdfFileUrl)) {
        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="output.pdf"'); 
        readfile($pdfFileUrl);
        exit; 
    } else {
        echo 'File not found';
    }
} 
?>
