<?php

function graph_mostRuns(){
   global $connection;
   $q=mysqli_query($connection,"
      select `game`, count(1) as `x`, `games`.`name`
      from `runs`
      left join `games` on `games`.`id` = `runs`.`game`
      where `echo` = 1
      group by `game`
      order by `x` desc
      limit 20
   ");
   $return='<div id="graph_mostRuns" class="graph"></div>';
   $return.="
      <script>
         $(function () {
            $('#graph_mostRuns').highcharts({
               chart: {
                  type: 'column',
                  inverted: true
               },
               title: {
                  text: 'What games have the most runs?'
               },
               xAxis: {
                  type: 'category'
               },
               yAxis: {
                  min: 0,
                  title: {
                      text: 'count'
                  }
               },
               tooltip: {
                  enabled: false
               },
               legend: {
                  enabled: false
               },
               series: [{
                  name: 'Games',
                  data: [";

                     while($d=mysqli_fetch_assoc($q)){
                        $return .= "['".str_replace("'", "\'", $d['name'])."', ".$d['x']."], ";
                     }

                  $return .= "],
               }]
             });
         });
      </script>
   ";
   return $return;
}

function graph_mostRuns2(){
   global $connection;
   $q=mysqli_query($connection,"
      select `game`, count(1) as `x`, `games`.`name`, `category`, `categories`.`name` as `catname`
      from `runs`
      left join `games` on `games`.`id` = `runs`.`game`
      left join `categories` on `categories`.`id` = `runs`.`category`
      where `echo` = 1
      group by `game`, `category`
      order by `x` desc
      limit 20
   ");
   $return='<div id="graph_mostRuns2" class="graph"></div>';
   $return.="
      <script>
         $(function () {
            $('#graph_mostRuns2').highcharts({
               chart: {
                  type: 'column',
                  inverted: true
               },
               title: {
                  text: 'What games + categories have the most runs?'
               },
               xAxis: {
                  type: 'category'
               },
               yAxis: {
                  min: 0,
                  title: {
                      text: 'count'
                  }
               },
               tooltip: {
                  enabled: false
               },
               legend: {
                  enabled: false
               },
               series: [{
                  name: 'Games',
                  data: [";

                     while($d=mysqli_fetch_assoc($q)){
                        $return .= "['".str_replace("'", "\'", $d['name'])." (".str_replace("'", "\'", $d['catname']).")', ".$d['x']."], ";
                     }

                  $return .= "],
               }]
             });
         });
      </script>
   ";
   return $return;
}

function graph_mostCats(){
   global $connection;
   $q=mysqli_query($connection,"
      select count(1) as `x`, categories.name
      from categories
      left join runs on runs.category = categories.id
      where `echo` = 1 AND `name`
      group by categories.name
      order by `x` desc
      limit 20
   ");
   $return='<div id="graph_mostCats" class="graph"></div>';
   $return.="
      <script>
         $(function () {
            $('#graph_mostCats').highcharts({
               chart: {
                  type: 'column',
                  inverted: true
               },
               title: {
                  text: 'What categories are the most played?'
               },
               xAxis: {
                  type: 'category'
               },
               yAxis: {
                  min: 0,
                  title: {
                      text: 'count'
                  }
               },
               tooltip: {
                  enabled: false
               },
               legend: {
                  enabled: false
               },
               series: [{
                  name: 'Games',
                  data: [";

                     while($d=mysqli_fetch_assoc($q)){
                        $return .= "['".str_replace("'", "\'", $d['name'])."', ".$d['x']."], ";
                     }

                  $return .= "],
               }]
             });
         });
      </script>
   ";
   return $return;
}

function graph_players(){
   global $connection;
   $q=mysqli_query($connection,"
      select count(1) as `x`, `player`, `users`.`name`
      from(
         select `player`, `game`
         from `runs`
         where `echo` = 1 and `player`
         group by `player`, `game`
      ) as `a`
      left join `users` on `users`.`id` = `a`.`player`
      group by `player`
      order by `x` desc
      limit 20
   ");
   $return='<div id="graph_players" class="graph"></div>';
   $return.="
      <script>
         $(function () {
            $('#graph_players').highcharts({
               chart: {
                  type: 'column',
                  inverted: true
               },
               title: {
                  text: 'Which player runs the most games?'
               },
               xAxis: {
                  type: 'category'
               },
               yAxis: {
                  min: 0,
                  title: {
                      text: 'count'
                  }
               },
               tooltip: {
                  enabled: false
               },
               legend: {
                  enabled: false
               },
               series: [{
                  name: 'Games',
                  data: [";

                     while($d=mysqli_fetch_assoc($q)){
                        $return .= "['".str_replace("'", "\'", ($d['name']?$d['name']:$d['player']))."', ".$d['x']."], ";
                     }

                  $return .= "],
               }]
             });
         });
      </script>
   ";
   return $return;
}

function graph_shortestWRruns(){
   global $connection;
   $q=mysqli_query($connection,"
      select `runs`.`id`, `game`, `category`, `categories`.`name` as `catname`, min(`primary_t`) as `time`, `games`.`name`
      from `runs`
      left join `games` on `games`.`id` = `runs`.`game`
      left join `categories` on `categories`.`id` = `runs`.`category`
      where `echo` = 1
      group by `game`, `category`
      order by `time` asc
      limit 40
   ");
   $return='<div id="graph_shortestWRruns" class="graph"></div>';
   $return.="
      <script>
         $(function () {
            $('#graph_shortestWRruns').highcharts({
               chart: {
                  type: 'column',
                  inverted: true
               },
               title: {
                  text: 'What are the shortest WR runs?'
               },
               xAxis: {
                  type: 'category'
               },
               yAxis: {
                  min: 0,
                  title: {
                      text: 'seconds'
                  }
               },
               tooltip: {
                  enabled: false
               },
               legend: {
                  enabled: false
               },
               series: [{
                  name: 'Games',
                  data: [";

                     while($d=mysqli_fetch_assoc($q)){
                        $return .= "['".str_replace("'", "\'", $d['name'])." (".str_replace("'", "\'", $d['catname']).")', ".$d['time']."], ";
                     }

                  $return .= "],
               }]
             });
         });
      </script>
   ";
   return $return;
}

function graph_longestWRruns(){
   global $connection;
   $q=mysqli_query($connection,"
      select `runs`.`id`, `game`, `category`, `categories`.`name` as `catname`, min(`primary_t`) as `time`, `games`.`name`
      from `runs`
      left join `games` on `games`.`id` = `runs`.`game`
      left join `categories` on `categories`.`id` = `runs`.`category`
      where `echo` = 1
      group by `game`, `category`
      order by `time` desc
      limit 40
   ");
   $return='<div id="graph_longestWRruns" class="graph"></div>';
   $return.="
      <script>
         $(function () {
            $('#graph_longestWRruns').highcharts({
               chart: {
                  type: 'column',
                  inverted: true
               },
               title: {
                  text: 'What are the longest WR runs?'
               },
               xAxis: {
                  type: 'category'
               },
               yAxis: {
                  min: 0,
                  title: {
                      text: 'hours'
                  }
               },
               tooltip: {
                  enabled: false
               },
               legend: {
                  enabled: false
               },
               series: [{
                  name: 'Games',
                  data: [";

                     while($d=mysqli_fetch_assoc($q)){
                        $return .= "['".str_replace("'", "\'", $d['name'])." (".str_replace("'", "\'", $d['catname']).")', ".($d['time']/60/60)."], ";
                     }

                  $return .= "],
               }]
             });
         });
      </script>
   ";
   return $return;
}

function graph_scatter(){
   global $connection;
   $q=mysqli_query($connection,"
      select count(1) as `x`, round(`primary_t`/10)*10 as `time`
      from runs
      where `echo` = 1 and `primary_t` <= 25000
      group by round(`primary_t`/10)
   ");
   $return='<div id="graph_scatter" class="graph"></div>';
   $return.="
      <script>
         $(function () {
            $('#graph_scatter').highcharts({
               chart: {
                  type: 'scatter',
                  inverted: true
               },
               title: {
                  text: 'Do players prefer to run shorter games? Probably!'
               },
               xAxis: {
                  type: 'category',
                  title: {
                      text: 'count of runs'
                  },
                  max: 100,
                  min: 0
               },
               yAxis: {
                  min: 0,
                  title: {
                      text: 'run length'
                  },
                  labels:{
                     formatter: function(){
                        var date = new Date(null);
                        date.setSeconds(this.value);
                        return date.toISOString().substr(11, 8);
                     }
                  }
               },
               tooltip: {
                  enabled: false
               },
               legend: {
                  enabled: false
               },
               plotOptions:{
                  scatter:{
                     marker:{
                        enabled: true,
                        radius: 3
                     }
                  }
               },
               series: [{
                  name: 'Games',
                  data: [";

                     while($d=mysqli_fetch_assoc($q)){
                        $return .= "[".$d['x'].", ".($d['time'])."], ";
                     }

                  $return .= "],
               }]
             });
         });
      </script>
   ";
   return $return;
}

function graph_zelda(){
   global $connection;
   $q=mysqli_query($connection,"
      select primary_t as `primary_t`, player, `users`.`name`
      from runs
      left join `users` on `users`.`id` = `runs`.`player`
      where `category` = 'z275w5k0' and `echo` = 1
      order by `primary_t` asc
      limit 50
   ");
   $return='<div id="graph_zelda" class="graph"></div>';
   $return.="
      <script>
         $(function () {
            $('#graph_zelda').highcharts({
               chart: {
                  type: 'scatter'
               },
               title: {
                  text: 'How is the Legend of Zelda: Ocarina of Time optimized? Quite well!'
               },
               xAxis: {
                  type: 'category'
               },
               yAxis: {
                  min: 1050,
                  tickPixelInterval: 20,
                  title: {
                      text: 'run time'
                  },
                  labels:{
                     formatter: function(){
                        var date = new Date(null);
                        date.setSeconds(this.value);
                        return date.toISOString().substr(11, 8);
                     }
                  }
               },
               tooltip: {
                  headerFormat: '<div style=\"font-size: 1.2em; font-weight: 700; margin: 0 0 0.25em 0;\">{point.key}</div>',
                  pointFormat: '{point.y}',
                  valueDecimals: 0,
                  shared: true,
                  useHTML: true,
               },
               legend: {
                  enabled: false
               },
               series: [{
                  tooltip: {
                     valueSuffix: ' seconds'
                  },
                  name: 'Games',
                  data: [";

                     while($d=mysqli_fetch_assoc($q)){
                        $return .= "['".str_replace("'", "\'", $d['name']?$d['name']:$d['player'])."', ".$d['primary_t']."], ";
                     }

                  $return .= "],
               }]
             });
         });
      </script>
   ";
   return $return;
}

function graph_WRhistory($category=null){
   global $connection;
   $category = mysqli_real_escape_string($connection, $category);
   $q=mysqli_query($connection,"
      select `date`, `time`, (SELECT `users`.`name` from `runs` left join `users` on `users`.`id` = `player` where `category` = '$category' and `date` = `b`.`date` and `time` = `b`.`time` limit 1) as `player` from(
      select min(`date`) as `date`, `time` from (
      SELECT `date`, (SELECT MIN(`primary_t`) from `runs` WHERE `category` = '$category' AND `date` <= `a`.`date`) as `time`
      FROM `runs` as `a`
      WHERE `category` = '$category'
      group by `date`
      ORDER BY `date` asc
      ) as `a`
      group by `time`
      order by `date` asc
      ) as `b`
      where `date` != '0000-00-00'
   ");
   if (mysqli_num_rows($q)<3){
      return 'This category does not exist, or does not have enough runs to plot a graph.';
   }
   $dateStart=NULL;
   while($d=mysqli_fetch_assoc($q)){
      if ($dateStart===NULL){
         $dateStart = strtotime($d['date']);
      }
      $data[] = $d;
   }
   $return='<div id="graph_WRhistory" class="graph"></div>';
   $return.="
      <script>
         $(function () {
            $('#graph_WRhistory').highcharts({
               chart: {
                  type: 'line'
               },
               title: {
                  text: ''
               },
               xAxis: {
                  min: ".($dateStart*1000).",
                  type: 'datetime'
               },
               yAxis: {
                  type: 'linear',
                  tickPixelInterval: 20,
                  title: {
                     text: 'run time'
                  },
                  labels:{
                     formatter: function(){
                        var date = new Date(null);
                        date.setSeconds(this.value);
                        return date.toISOString().substr(11, 8);
                     }
                  }
               },
               plotOptions:{
                  line:{
                     marker:{
                        enabled: true,
                        radius: 6
                     }
                  }
               },
               tooltip: {
                  headerFormat: '<div style=\"font-size: 1.2em; font-weight: 700; margin: 0 0 0.25em 0;\">{point.key}</div>',
                  pointFormatter: function(){
                     var date = new Date(null);
                     date.setSeconds(this.y);
                     return 'WR run time: '+date.toISOString().substr(11, 8)+' by <b>'+this.player+'</b>';
                     // return this.y;
                  },
                  valueDecimals: 0,
                  shared: true,
                  useHTML: true,
               },
               legend: {
                  enabled: false
               },







               series: [{
                  tooltip: {
                     valueSuffix: ' seconds'
                  },
                  name: 'Games',
                  data: [{";



                     foreach ($data as $d){
                        $return .= "
                           x:".(strtotime($d['date'])*1000).", y: ".$d['time'].", player: '".$d['player']."'},{
                        ";
                     }



                  $return .= "}]
               }]
             });
         });
      </script>
   ";
   return $return;
}

function category_selector($category=null){
   global $connection;
   $q=mysqli_query($connection,"
      select count(1) as `x`, `category`, CONCAT(`games`.`name`, ' (', `categories`.`name`, ')') as `catname`
      from runs
      left join `games` on `games`.`id` = `runs`.`game`
      left join `categories` on `categories`.`id` = `runs`.`category`
      where `echo` = 1
      group by `category`
      having `x` >= 10
      order by `catname` ASC
   ");
   $return=null;
   while($d=mysqli_fetch_assoc($q)){
      $return.='<option value="'.$d['category'].'" '.(($category && $category==$d['category'])?'selected':NULL).'>'.$d['catname'].'</option>';
   }
   return $return;
}

?>
