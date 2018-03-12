<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL);
ini_set("memory_limit", "-1");

date_default_timezone_set("America/New_York");

// Confirmation number
$confirm = strtoupper("SPC" . substr(md5(uniqid(rand(), true)), 0, 7));

$filenames = array();
$i = 0;

foreach ($_FILES as $file) {
    $n = $file['name'];
    $s = $file['size'];
    $t = $file['tmp_name'];
    if (!$n)
        continue;

    $filename = $confirm . "_" . $n;
    $directory = realpath("../Schoolpub/uploads/senior_ads/");
//    chmod($directory, 0777);
    echo "Directory: ". $directory . "\n";
    $file_path = str_replace('/', '\\', $directory . "/" . $filename);
    echo "Full Path: " . $file_path . "\n";

    if (file_exists($file_path)) {
        // do nothing
        echo "File already exists";
    }
    else {
        if (move_uploaded_file($t, $file_path)) {
            echo $filename . " upload OK!\n";
            $filenames[$i] = $filename;
            $i++;
        }
        else {
            echo $filename . " upload FAIL!\n";
        }
    }
}

if ($i > 0) {
    buildXML();
}

function buildXML() {

    global $confirm, $filenames, $i;

    $xml = '<response><confirm>' . $confirm . '</confirm><num_files>' . $i . '</num_files>';
    foreach ($filenames as $a => $b) {
        $xml .= '<file' . ($a + 1) . '>' . $filenames[$a] . '</file' . ($a + 1) . '>';
    }
    $xml .= '</response>';
    echo $xml;
}

?>
