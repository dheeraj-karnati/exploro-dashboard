
I'm currently using the structured folder uploader from "nuhil" to make the upload of folders/complete folder structures possible with dropzone.js.

Uploading folders is working great, no matter how many folders are in the folder, and so on. But when I try to upload a single file, it's not working at all.

Here is the code I used to upload:

<?php


$ds = DIRECTORY_SEPARATOR;
$storeFolder = '../ead_uploads/';

if (!is_dir($storeFolder)) {
    mkdir($storeFolder);
}

if (!empty($_FILES)) {

    $tempFile = $_FILES['file']['tmp_name'];

    $targetPath = dirname( __FILE__ ) . $ds . $storeFolder . $ds;

    $fullPath = $storeFolder.rtrim($_POST['path'], "/.");
    $folder = substr($fullPath, 0, strrpos($fullPath, "/"));

    if (!is_dir($folder)) {
        $old = umask(0);
        mkdir($folder, 0777, true);
        umask($old);
    }

    if (move_uploaded_file($tempFile, $fullPath)) {
        die();
    } else {
        die('e');
    }
}
?>