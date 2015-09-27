<?php

include('db.php');

$url = 'http://www.speedrun.com/api/v1/users?orderby=signup&direction=desc';

date_default_timezone_set('UTC');

$hour = date('G');
$day  = date('N');
$min  = round(date('i')/5)*5;

$q=mysqli_query($connection,"
   SELECT `id`, `name`, `country` FROM `users`
");
$existingUsers = array();
while($d=mysqli_fetch_assoc($q)){
   $existingUsers[$d['id']] = array(
      'name'    => $d['name'],
      'country' => $d['country']
   );
}

$countries = array();

$stopMainLoop = FALSE;

while(true){

   if ($stopMainLoop){ break; }

   # echo $url;
   # echo "\n";

   $get = file_get_contents($url);

   $arr = json_decode($get, TRUE);

   foreach($arr['data'] as $user){
      $id        = mysqli_real_escape_string($connection, $user['id']);
      $name      = mysqli_real_escape_string($connection, $user['names']['international']);
      $country   = mysqli_real_escape_string($connection, $user['location']['country']['code']);

      if (!array_key_exists($country, $countries)){
         $countries[$country] = mysqli_real_escape_string($connection, $user['location']['country']['names']['international']);
      }
      // $user['location']['country']['names']['international']

      if ( array_key_exists($id, $existingUsers) ){
         ## tento user uz v DB existuje, takze uz som v bode, kedy nie su novi useri -- zomrem to
         ## ... unless je saturday midnight, kedy chcem updatnut vsetkych userov
         if ($hour==0&&$day==7&&$min==0){}
         else{ $stopMainLoop = TRUE; }

         if ($name!=$existingUsers[$id]['name'] || $country!=$existingUsers[$id]['country']){

            echo 'updating'."\n";

            mysqli_query($connection,"
               UPDATE `users` SET
                  `name` = '$name',
                  `country` = '$country'
               WHERE `id` = '$id'
            ");

         }
      }
      else{
         mysqli_query($connection,"
            INSERT INTO `users` (`id`, `name`, `country`)
            VALUES ('$id', '$name', '$country')
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
   # $next=FALSE;

   if ($next){
      $url = $next;
      sleep(10);
   }

   else{
      break;
   }

}

$cQ = "INSERT IGNORE INTO `countries` (`code`, `name`) VALUES ";
foreach($countries as $key=>$val){
   if ($key && $val){
      $cQ .= "('$key', '$val'),";
   }
}
$cQ = trim($cQ);
$cQ = trim($cQ, ',');

mysqli_query($connection, $cQ);

?>
