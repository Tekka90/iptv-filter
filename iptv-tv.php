<?php 
#exec('/var/www/html/iptv-tv.sh');

if(isset($_GET['pwd'])) {
    $password = $_GET['pwd'];
    $hash = password_hash($_ENV["PASSWORD"],PASSWORD_DEFAULT);
    if (password_verify($password, $hash)) {
        #echo 'Password is valid!';
        header("Content-Description: File Transfer");
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment; filename=\"iptv-filtered.m3u\"");
        readfile("/config/iptv-filtered.m3u");
    } else {
        echo 'Invalid password.';
    }
}
else {
    echo "Hello world!";
}

?>
