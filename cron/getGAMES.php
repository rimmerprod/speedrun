<?php

include('db.php');

$url = 'http://www.speedrun.com/api/v1/games?orderby=created&direction=desc';

date_default_timezone_set('UTC');

$hour = date('G');
$day  = date('N');
$min  = round(date('i')/5)*5;

while(true){

   # echo $url;
   # echo "\n";

   $get = file_get_contents($url);

   $arr = json_decode($get, TRUE);

   foreach($arr['data'] as $game){
      $id        = mysqli_real_escape_string($connection, $game['id']);
      $name      = mysqli_real_escape_string($connection, $game['names']['international']);
      $released  = (int)$game['released'];
      $link_runs = NULL;
      foreach($game['links'] as $val){
         if ($val['rel']=='runs'){
            $link_runs = mysqli_real_escape_string($connection, $val['uri']);
            break;
         }
      }
      $test = mysqli_query($connection,"
         SELECT 1 FROM `games` WHERE `id` = '$id'
      ");
      if (mysqli_num_rows($test)){
         if ($hour==0&&$day==7&&$min==0){}
         else{ die(); }
         
         mysqli_query($connection,"
            UPDATE `games` SET
               `name` = '$name',
               `released` = $released
            WHERE `id` = '$id'
         ");
      }
      else{
         mysqli_query($connection,"
            INSERT INTO `games` (`id`, `name`, `released`)
            VALUES ('$id', '$name', $released)
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
