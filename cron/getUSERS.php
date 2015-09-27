<?php

include('db.php');

$url = 'http://www.speedrun.com/api/v1/users?orderby=signup&direction=desc';

date_default_timezone_set('UTC');

$hour = date('G');
$day  = date('N');
$min  = round(date('i')/5)*5;

while(true){

   # echo $url;
   # echo "\n";

   $get = file_get_contents($url);

   $arr = json_decode($get, TRUE);

   foreach($arr['data'] as $user){
      $id        = mysqli_real_escape_string($connection, $user['id']);
      $name      = mysqli_real_escape_string($connection, $user['names']['international']);

      $test = mysqli_query($connection,"
         SELECT 1 FROM `users` WHERE `id` = '$id'
      ");
      if (mysqli_num_rows($test)){
         ## tento user uz v DB existuje, takze uz som v bode, kedy nie su novi useri -- zomrem to
         ## ... unless je saturday midnight, kedy chcem updatnut vsetkych userov
         if ($hour==0&&$day==7&&$min==0){}
         else{ die(); }

         mysqli_query($connection,"
            UPDATE `users` SET
               `name` = '$name'
            WHERE `id` = '$id'
         ");
      }
      else{
         mysqli_query($connection,"
            INSERT INTO `users` (`id`, `name`)
            VALUES ('$id', '$name')
         ");
      }
      if (mysqli_error($connection)){
         echo mysqli_error($connection);
         echo "\n";
      }

   }

   $next=FALSE;
   if (isset($arr['pagination']['links'])){
      foreach($arr['pagination']['links'] as $val){
         if ($val['rel']=='next'){
            $next = $val['uri'];
         }
      }
   }

   if ($next){
      $url = $next;
      sleep(10);
   }

   else{
      break;
   }

}

?>
