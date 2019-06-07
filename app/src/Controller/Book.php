<?php

namespace Controller;

use Core\Request;

class Book extends AbstractController
{
  const BOOKS_DIR = 'books';

  private $target_dir;

  public function __construct()
  {
    parent::__construct();

    $this->target_dir = getenv('STORAGE_ROOT') . self::BOOKS_DIR;
    if(!is_dir($this->target_dir)) {
      mkdir($this->target_dir, 0777, true);
    }
  }

  public function uploadMethod(Request $request)
  {
    $upload_file = $request->getFiles()['fileToUpload'];
    $upload_name = basename($upload_file['name']);
    $target_file = $this->target_dir . DIRECTORY_SEPARATOR . $upload_name;
    $uploadOk = 1;
    /* $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION)); */

    if(isset($request->getPost()['submit'])) {
      $check = filesize($upload_file['tmp_name']);
      if($check === false) {
        $uploadOk = 0;
      }
    }

    // Check if file already exists
    if (file_exists($target_file)) {
      echo "Sorry, file already exists.";
      $uploadOk = 0;
    }

    /* // Check file size */
    /* if ($_FILES["fileToUpload"]["size"] > 500000) { */
    /*     echo "Sorry, your file is too large."; */
    /*     $uploadOk = 0; */
    /* } */

    /* // Only allow certain file formats */
    /* if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) { */
    /*     echo 'Sorry, only JPG, JPEG, PNG & GIF files are allowed.'; */
    /*     $uploadOk = 0; */
    /* } */

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
      echo "Sorry, your file was not uploaded.";
    }
    else {
      // if everything is ok, try to upload file
      if (move_uploaded_file($upload_file["tmp_name"], $target_file)) {
        echo "The file ". $upload_name ." has been uploaded.";
      } else {
        echo "Sorry, there was an error uploading your file.";
      }
    }
  }
}
