<?php

function autoload($classname) {
  $lastSlash = strpos($classname, '\\') + 1;
  $classname = substr($classname, $lastSlash);
  $directory = str_replace('\\', '/', $classname);
  $filename = __DIR__ . '/src/' . $directory . '.php';
  require_once($filename);
}
spl_autoload_register('autoload');

function dirToArray($dir) {
   $result = array();

   $cdir = scandir($dir);
   foreach ($cdir as $key => $value) {
      if (!in_array($value,array(".",".."))) {
         if (is_dir($dir . DIRECTORY_SEPARATOR . $value)) {
            $result[$value] = dirToArray($dir . DIRECTORY_SEPARATOR . $value);
         }
         else {
            $result[] = $value;
         }
      }
   }
   return $result;
}

$books = dirToArray(getenv('STORAGE_ROOT') . 'uploads')

?>

<!DOCTYPE html>
<html>
<body>

<h1>Alexandria</h1>

<form action="upload.php" method="post" enctype="multipart/form-data">
    Select file to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload" name="submit">
</form>

<h3>books:</h3>
<ul>
  <? foreach ($books as $key => $book): ?>
    <li>
      <?= $book ?>
    </li>
  <? endforeach; ?>
</ul>

</body>
</html>
