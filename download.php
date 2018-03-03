<?php
echo $_GET['dir'];



if (file_exists($_GET['dest'])) {
  header('Content-Description: File Transfer');
  header('Content-Type: application/octet-stream');
  header('Content-Disposition: attachment; filename="'.basename($_GET['dest']).'"');
  header('Expires: 0');
  header('Cache-Control: must-revalidate');
  header('Pragma: public');
  header('Content-Length: ' . filesize($_GET['dest']));
  if(readfile($_GET['dest'])){
    $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($_GET['dir']), RecursiveIteratorIterator::CHILD_FIRST);

    foreach ($files as $file)
    {
        $file = str_replace('\\', '/', $file);

        // Ignore "." and ".." folders
        if( in_array(substr($file, strrpos($file, '/')+1), array('.', '..')) )
            continue;

        if (is_dir($file) === true)
        {
          rmdir($file);
        }
        else if (is_file($file) === true)
        {
            unlink($file);
        }
    }
    rmdir($_GET['dir']);
  }
  exit;
}
else {
  echo 'err';
}
