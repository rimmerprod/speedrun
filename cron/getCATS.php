<?php

include('db.php');

## $q=mysqli_query($connection,"SELECT 1 FROM `cron` WHERE `file` = 'getCATS.php' AND `running` = 1");
## if (mysqli_num_rows($q)){ die(); }

## mysqli_query($connection,"UPDATE `cron` SET `running` = 1 WHERE `file` = 'getCATS.php'");

date_default_timezone_set('UTC');

$q=mysqli_query($connection,"
   SELECT `id` FROM `categories` ORDER BY `last_fetch` ASC LIMIT 3
");

while($d=mysqli_fetch_assoc($q)){

   $url = 'http://www.speedrun.com/api/v1/categories/'.$d['id'];

   $get = file_get_contents($url);

   $arr = json_decode($get, TRUE);

   $name = $arr['data']['name'];

   mysqli_query($connection,"
      UPDATE `categories`
      SET `name` = '".mysqli_real_escape_string($connection, $name)."', `last_fetch` = ".time()."
      WHERE `id` = '".mysqli_real_escape_string($connection, $d['id'])."'
   ");

   sleep(10);

}

## mysqli_query($connection,"UPDATE `cron` SET `running` = 0 WHERE `file` = 'getCATS.php'");

?>
