<?php

header('Expires: Thu, 01-Jan-70 00:00:01 GMT');
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');

include('core/db.php');
include('core/functions.php');

date_default_timezone_set('UTC');

if (isset($_GET['category']) && $_GET['category']){
   $category = $_GET['category'];
}
else{
   $category = 'z275w5k0';
}

echo'

<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link href="/css/reset.css" rel="stylesheet" />
      <link href=\'http://fonts.googleapis.com/css?family=Exo+2:400,300,600,700,800\' rel=\'stylesheet\' type=\'text/css\'>
      <link href="/css/reset.css" rel="stylesheet" />
      <link href="/css/style.css?rev=3" rel="stylesheet" />

      <script src="/js/jquery-2.1.1.min.js"></script>
      <script src="/js/highcharts.js"></script>
      <script src="/js/custom.js?rev=2"></script>

      <title>Speedrunstats.com</title>

      <script>
        (function(i,s,o,g,r,a,m){i[\'GoogleAnalyticsObject\']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,\'script\',\'//www.google-analytics.com/analytics.js\',\'ga\');

        ga(\'create\', \'UA-5194258-68\', \'auto\');
        ga(\'send\', \'pageview\');

      </script>
   </head>
   <body>
      <h1>Speedrunstats.com</h1>

      '.graph_mostRuns().'
      '.graph_mostRuns2().'
      '.graph_mostCats().'
      '.graph_players().'
      '.graph_shortestWRruns().'
      '.graph_longestWRruns().'
      '.graph_scatter().'
      '.graph_zelda().'

      <h2>The progress of WR of <select name="category">'.category_selector($category).'</select></h2>

      '.graph_WRhistory($category).'
   </body>
</html>

';
