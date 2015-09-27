<?php

include('db.php');

$url = 'http://www.speedrun.com/api/v1/runs?orderby=submitted&direction=desc';

date_default_timezone_set('UTC');

$hour = date('G');
$day  = date('N');
$min  = round(date('i')/5)*5;

while(true){

   # echo $url;
   # echo "\n";

   $get = file_get_contents($url);

   $arr = json_decode($get, TRUE);

   foreach($arr['data'] as $run){
      $id        = mysqli_real_escape_string($connection, $run['id']);
      $game      = mysqli_real_escape_string($connection, $run['game']);
      $level     = mysqli_real_escape_string($connection, $run['level']);
      $category  = mysqli_real_escape_string($connection, $run['category']);

      $status    = mysqli_real_escape_string($connection, $run['status']['status']);

      $player = NULL;
      $guest  = NULL;
      if (isset($run['players'][0]['id'])){
         $player    = mysqli_real_escape_string($connection, $run['players'][0]['id']);
      }
      elseif ( isset($run['players'][0]['rel']) && $run['players'][0]['rel'] == 'guest' ){
         $guest     = mysqli_real_escape_string($connection, $run['players'][0]['name']);
      }

      $platform  = mysqli_real_escape_string($connection, $run['system']['platform']);
      $date      = mysqli_real_escape_string($connection, $run['date']);

      $primary_t          = (float)$run['times']['primary_t'];
      $realtime_t         = (float)$run['times']['realtime_t'];
      $realtime_noloads_t = (float)$run['times']['realtime_noloads_t'];
      $ingame_t           = (float)$run['times']['ingame_t'];

      $test = mysqli_query($connection,"
         SELECT 1 FROM `runs` WHERE `id` = '$id'
      ");
      if (mysqli_num_rows($test)){
         if ($hour==0&&$day==7&&$min==0){}
         else{ die(); }

         mysqli_query($connection,"
            UPDATE `runs` SET
            `game` = '$game',
            `level` = '$level',
            `category` = '$category',
            `status` = '$status',
            `player` = ".($player?"'$player'":'NULL').",
            `guest` = ".($guest?"'$guest'":'NULL').",
            `platform` = '$platform',
            `date` = '$date'
            WHERE `id` = '$id'
         ");

         mysqli_query($connection,"
            UPDATE `runs` SET
            `primary_t` = $primary_t,
            `realtime_t` = $realtime_t,
            `realtime_noloads_t` = $realtime_noloads_t,
            `ingame_t` = $ingame_t
            WHERE `id` = '$id' AND `sync_times` = 1
         ");
      }
      else{
         # echo 'inserting a run '."\n";
         mysqli_query($connection,"
            INSERT INTO `runs` (`id`, `game`, `level`, `category`, `status`, `player`, `guest`, `platform`, `date`, `primary_t`, `realtime_t`, `realtime_noloads_t`, `ingame_t`)
            VALUES (
               '$id', '$game', '$level', '$category', '$status', ".($player?"'$player'":'NULL').", ".($guest?"'$guest'":'NULL').", '$platform', '$date',
               $primary_t, $realtime_t, $realtime_noloads_t, $ingame_t
            );
         ");
      }
      if (mysqli_error($connection)){
         echo mysqli_error($connection);
         echo "\n";
      }
      else{
         mysqli_query($connection,"
            INSERT IGNORE INTO `categories` (`id`) VALUES ('$category')
         ");
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
