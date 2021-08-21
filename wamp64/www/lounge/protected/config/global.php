<?php
	
function forceDownload($dir) {
    if (file_exists($dir)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($dir));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . filesize($dir));
        ob_clean();
        flush();
        readfile($dir);
//exit;
    } else {
        die("File not found.");
//$this->render('error_download');
    }
}

?>