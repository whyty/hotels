<?php

$path = "public/downloads"; 

$latest_ctime = 0;
$latest_filename = '';    

$d = dir($path);
while (false !== ($entry = $d->read())) {
  $filepath = "{$path}/{$entry}";
  // could do also other checks than just checking whether the entry is a file
  if (is_file($filepath) && filectime($filepath) > $latest_ctime) {
    $latest_ctime = filectime($filepath);
    $latest_filename = $entry;
  }
  
}
if($latest_filename){
    $file = $path . "/" . $latest_filename;
    $mime = mime_content_type($file);

    // Build the headers to push out the file properly.
    header('Pragma: public');     // required
    header('Expires: 0');  // no cache
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s', filemtime($file)) . ' GMT');
    header('Cache-Control: private', false);
    header('Content-Type: ' . $mime);  
    header('Content-Disposition: attachment; filename="' . basename($file) . '"');  // Add the file name
    header('Content-Transfer-Encoding: binary');
    header('Content-Length: ' . filesize($file)); // provide file size
    header('Connection: close');
    readfile($file); // push it out
    exit();
}

