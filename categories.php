<?php

if(isset($_GET['pwd'])) {
    $password = $_GET['pwd'];
    $hash = password_hash($_ENV["PASSWORD"],PASSWORD_DEFAULT);
    if (password_verify($password, $hash) == false) {
        exit ();
    }
}
else {
    echo "Hello world!";
    exit();
}

// configuration
$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$today = date('Ymd');
$categoriesFile = '/config/categories-'.$today.'.txt';
$keepOnlyFile = '/config/keep-only.txt';

// check if form has been submitted
if (isset($_POST['keeponly']))
{
    copy($keepOnlyFile, $keepOnlyFile.'.bkp');
    // save the text contents
    file_put_contents($keepOnlyFile, str_replace("\r", '', $_POST['keeponly']));

    // redirect to form again
    header(sprintf('Location: %s', $actual_link));
    printf('<a href="%s">Moved</a>.', htmlspecialchars($actual_link));
    exit();
}

// read the textfile
$categories = file_get_contents($categoriesFile);
$keepOnly = file_get_contents($keepOnlyFile);

?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {
  font-family: Arial;
  color: white;
}

.split {
  height: 100%;
  width: 50%;
  position: fixed;
  z-index: 1;
  top: 0;
  overflow-x: hidden;
}

.left {
  left: 0;
  background-color: #111;
}

.right {
  right: 0;
  background-color: red;
}
form {
  width:100%;
  height:98.5%;
}
textarea {
  border:0px solid #999999;
  width:100%;
  height:95%;
  margin:0px 0;
  padding:3px;
}
</style>
</head>
<body>

<div class="split left">
    <textarea name="source"><?php echo htmlspecialchars($categories) ?></textarea>
</div>

<div class="split right">
    <form action="" method="post">
        <textarea name="keeponly"><?php echo htmlspecialchars($keepOnly) ?></textarea>
        <input type="submit" />
        <input type="reset" />
    </form>
</div>
     
</body>
</html> 
