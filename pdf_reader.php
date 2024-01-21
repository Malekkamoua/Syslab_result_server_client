<?php
if (isset($_POST['filename'])) {
    $pdfFileUrl = './data/' . urldecode($_POST['filename']);
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
