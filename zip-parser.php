<?php
//check if the file has been sent
print_r($_FILES);

// from https://stackoverflow.com/questions/1334613/how-to-recursively-zip-a-directory-in-php
function Zip($source, $destination)
{
    if (!extension_loaded('zip') || !file_exists($source)) {
        return false;
    }

    $zip = new ZipArchive();
    if (!$zip->open($destination, ZIPARCHIVE::CREATE)) {
        return false;
    }

    $source = str_replace('\\', '/', realpath($source));

    if (is_dir($source) === true)
    {

        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST);

        foreach ($files as $file)
        {
            $file = str_replace('\\', '/', $file);

            // Ignore "." and ".." folders
            if( in_array(substr($file, strrpos($file, '/')+1), array('.', '..')) )
                continue;

            if (is_dir($file) === true)
            {
              $dirpath = str_replace($news, ' ', $newf);
              $zip->addEmptyDir($dirpath);
            }
            else if (is_file($file) === true)
            {
                $filepath = str_replace($source . '/', '', $file);
                $zip->addFromString($filepath, file_get_contents($file));
            }
        }
    }
    else if (is_file($source) === true)
    {
        $zip->addFromString(basename($source), file_get_contents($source));
    }

    // header("Content-Disposition: attachment; filename=\"" . basename($File) . "\"");
    // header("Content-Type: application/force-download");
    // header("Content-Length: " . filesize($File));
    // header("Connection: close");

    return $zip->close();
}

if(isset($_FILES['zip']) && !empty($_FILES['zip'])) {
  $zipfile = $_FILES['zip'];
  $target_dir = "uploads/";
  $file_name = basename($zipfile["name"]);
  $ok = true;
  $imageFileType = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));


  // Check file size
  if ($zipfile["size"] > 5000000) {
      echo "Sorry, your file is too large. should be lower than 5Mb";
      $uploadOk = false;
  }

  //check if the file is a zip file
  if(strtolower($imageFileType) !== "zip") {
      echo "Sorry, only ZIP file is allowed.";
      $uploadOk = false;
  }

  // Check if $uploadOk is set to 0 by an error
  if (!$ok) {
      echo "Sorry, your file was not uploaded.";
  // if everything is ok, try to upload file
  } else {

    //check if the main uploads folder exists
    if(!is_dir($target_dir)) {
      mkdir($target_dir);
    }

    //wait for a created instance of the temp file to be deleted
    // and then create a new
    do {
      $date = new DateTime();
      $temp_dir = '~' . $date->getTimestamp() . '/';
    } while (is_dir($temp_dir));

    $istance_path = $target_dir . $temp_dir;
    if(mkdir($istance_path)){
      //new instance of ZipArchive

      if (move_uploaded_file($zipfile["tmp_name"], $istance_path . $file_name)) {
        //file on server
        $uploaed_file = $istance_path . $file_name;
        $zip = new ZipArchive;
        if($zip->open($uploaed_file)){
          $unzip_path = $istance_path . basename($uploaed_file, '.zip');
          if($zip->extractTo($unzip_path)) {
            //execute the conversion conditionally

            // then

            // Get real path for our folder
            $source = realpath($unzip_path);
            $destination = $source . '_converted.zip';

            if (!extension_loaded('zip') || !file_exists($source)) {
                return false;
            }

            $zip = new ZipArchive();
            if (!$zip->open($destination, ZIPARCHIVE::CREATE)) {
                return false;
            }

            $source = str_replace('\\', '/', realpath($source));

            if (is_dir($source) === true)
            {

                $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST);

                foreach ($files as $file)
                {
                    $file = str_replace('\\', '/', $file);

                    // Ignore "." and ".." folders
                    if( in_array(substr($file, strrpos($file, '/')+1), array('.', '..')) )
                        continue;

                    if (is_dir($file) === true)
                    {
                      $dirpath = str_replace($source . '/', '', $file . '/');
                      $zip->addEmptyDir($dirpath);
                    }
                    else if (is_file($file) === true)
                    {
                        $filepath = str_replace($source . '/', '', $file);
                        $zip->addFromString($filepath, file_get_contents($file));
                    }
                }
            }
            else if (is_file($source) === true)
            {
                $zip->addFromString(basename($source), file_get_contents($source));
            }



            if($zip->close()) {

              // send the zip to js : its store in $destination
            }

          }
        } else {
          echo "error when opening file";
        }
      } else {
          echo "Sorry, there was an error uploading your file.";
      }
    }
  }
}
