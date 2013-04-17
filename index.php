<!DOCTYPE html>
<html>
<head>
  <title>Ipswich</title>
  <link rel="apple-touch-icon-precomposed" href="lib/ios.png"/>
  <link rel="apple-touch-startup-image" href="lib/splash.png" />  
  <script src="http://code.jquery.com/jquery-1.6.4.min.js"></script>
        <script src="http://code.jquery.com/mobile/1.0/jquery.mobile-1.0.min.js"></script>
        <script src="scripts/pull-to-refresh.min.js"></script>
        <script>
            function callbackFunction() {
                // After one second (to simulate loading of external resources), append a list item, refresh the listview and hide pullToRefresh
                setTimeout(location.reload(true), 1000);
            }

            $(function() {
                $('#weather').pullToRefresh({
                    'callback': callbackFunction,
                    'height': 50
                });
            });
        </script>

  <link rel="stylesheet" type="text/css" href="sass/lib/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="sass/lib/responsive.css">
  
  
  <script type="text/javascript" src="http://fast.fonts.com/jsapi/50f59b9e-5b5e-4fc0-8af5-c75b6ffc57bd.js"></script>
  <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" /><meta name="apple-mobile-web-app-capable" content="yes" />
  <meta names="apple-mobile-web-app-status-bar-style" content="black-translucent" />


</head>



<?php
date_default_timezone_set('Europe/London');
include('lib/forecast.io.php');
$api_key = '7267fbb7a0735a88147f0db5ea3ecfbc';
$latitude = '52.0700';
$longitude = '1.1400';
$forecast = new ForecastIO($api_key);
?>



<?php $condition = $forecast->getCurrentConditions($latitude, $longitude); ?>
<body class="<?php echo $condition->geticon();?>">

<div id="weather" class="container">
  <div class="row">
    <div class="span12">
      <h2>Ipswich Weather</h2>
    </div>
    <hr>
    <div class="span6" style="position:relative;">
      <h1>Now</h1>
      <?php $condition = $forecast->getCurrentConditions($latitude, $longitude); ?>
      <img class="weather-icon" src="<?php echo $condition->geticon();?>.svg" alt="" width="100%" />
      <span class="now-temp"><?php echo round($condition->getTemperature());?></span>
      
      
    </div>
    <hr class="visible-phone">
    <div class="span3 forecast">
      <h2>The Rest of Today</h2>
      <?php $conditions_today = $forecast->getForecastToday($latitude, $longitude); ?>
      <ul>
        <?php foreach($conditions_today as $cond) 
        {
          echo '<li><img style="display:block; width:50px;" src='. $cond->geticon() . '.svg>';
          echo '<h4>' . $cond->getTime('H i') . '</h4><span class="temp">' . round($cond->getTemperature()) . '</span></li>' ; 
        }
        ?>
      </ul>
    </div>
    <hr class="visible-phone">
    <div class="span3 forecast">
      <h2>The Week Ahead</h2>
      <?php $conditions_week = $forecast->getForecastWeek($latitude, $longitude); ?>
      <ul>
        <?php foreach($conditions_week as $conditions)
        {
          echo '<li><img style="display:block; width:50px;" src='. $conditions->geticon() . '.svg>';
          echo '<h4>'. $conditions->getTime('D') .'</h4><span class="temp">' . round($conditions->getMaxTemperature()) .'</span></li>';
        }
        ?>

      </ul>
    </div>
  </div>
</div>

</body>


</html>
