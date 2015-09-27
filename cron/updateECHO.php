<?php

include('db.php');

##
## this file updates SQL to set column `echo` which defines which runs should be used
## in the graphs (i.e. it disables runs which are old, not verified, etc.
##

$q=mysqli_query($connection,"
   select `id`, `game`, `category`, `player`, MIN(`primary_t`) as `min`
   from `runs`
   where `status` = 'verified' AND (`level` is null OR `level` = '')
   group by `game`, `category`, `player`, `date`
");

$echo=array();

while($d=mysqli_fetch_assoc($q)){
   $echo[] = $d['id'];
}

$q=mysqli_query($connection,"
   UPDATE `runs` SET `echo` = 1 WHERE `id` IN ('".implode("','", $echo)."')
");

if (mysqli_error($connection)){
   echo 'error: '.mysqli_error($connection)."\n";
}
# else{ echo 'ok'."\n"; }

$q=mysqli_query($connection,"
   UPDATE `runs` SET `echo` = 0 WHERE `id` NOT IN ('".implode("','", $echo)."')
");

if (mysqli_error($connection)){
   echo 'error: '.mysqli_error($connection)."\n";
}
# else{ echo 'ok'."\n"; }

?>
