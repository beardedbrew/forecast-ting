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
  <script type="text/javascript" src="lib/iOS.js"></script>
  
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
    <div class="span12 weather-block">
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
  <hr class="visible-phone">
  <p class="visible-phone"><small>Please support this app by tapping an ad.</small></p>
</div>

<div class="ads" style="margin-left:-20px;">
  <?php

$GLOBALS['google']['client']='ca-mb-pub-7222067173487624';
$GLOBALS['google']['https']=read_global('HTTPS');
$GLOBALS['google']['ip']=read_global('REMOTE_ADDR');
$GLOBALS['google']['markup']='xhtml';
$GLOBALS['google']['output']='xhtml';
$GLOBALS['google']['ref']=read_global('HTTP_REFERER');
$GLOBALS['google']['slotname']='5119463552';
$GLOBALS['google']['url']=read_global('HTTP_HOST') . read_global('REQUEST_URI');
$GLOBALS['google']['useragent']=read_global('HTTP_USER_AGENT');
$google_dt = time();
google_set_screen_res();
google_set_muid();
google_set_via_and_accept();
function read_global($var) {
  return isset($_SERVER[$var]) ? $_SERVER[$var]: '';
}

function google_append_url(&$url, $param, $value) {
  $url .= '&' . $param . '=' . urlencode($value);
}

function google_append_globals(&$url, $param) {
  google_append_url($url, $param, $GLOBALS['google'][$param]);
}

function google_append_color(&$url, $param) {
  global $google_dt;
  $color_array = explode(',', $GLOBALS['google'][$param]);
  google_append_url($url, $param,
                    $color_array[$google_dt % count($color_array)]);
}

function google_set_screen_res() {
  $screen_res = read_global('HTTP_UA_PIXELS');
  if ($screen_res == '') {
    $screen_res = read_global('HTTP_X_UP_DEVCAP_SCREENPIXELS');
  }
  if ($screen_res == '') {
    $screen_res = read_global('HTTP_X_JPHONE_DISPLAY');
  }
  $res_array = preg_split('/[x,*]/', $screen_res);
  if (count($res_array) == 2) {
    $GLOBALS['google']['u_w']=$res_array[0];
    $GLOBALS['google']['u_h']=$res_array[1];
  }
}

function google_set_muid() {
  $muid = read_global('HTTP_X_DCMGUID');
  if ($muid != '') {
    $GLOBALS['google']['muid']=$muid;
     return;
  }
  $muid = read_global('HTTP_X_UP_SUBNO');
  if ($muid != '') {
    $GLOBALS['google']['muid']=$muid;
     return;
  }
  $muid = read_global('HTTP_X_JPHONE_UID');
  if ($muid != '') {
    $GLOBALS['google']['muid']=$muid;
     return;
  }
  $muid = read_global('HTTP_X_EM_UID');
  if ($muid != '') {
    $GLOBALS['google']['muid']=$muid;
     return;
  }
}

function google_set_via_and_accept() {
  $ua = read_global('HTTP_USER_AGENT');
  if ($ua == '') {
    $GLOBALS['google']['via']=read_global('HTTP_VIA');
    $GLOBALS['google']['accept']=read_global('HTTP_ACCEPT');
  }
}

function google_get_ad_url() {
  $google_ad_url = 'http://pagead2.googlesyndication.com/pagead/ads?';
  google_append_url($google_ad_url, 'dt',
                    round(1000 * array_sum(explode(' ', microtime()))));
  foreach ($GLOBALS['google'] as $param => $value) {
    if (strpos($param, 'color_') === 0) {
      google_append_color($google_ad_url, $param);
    } else if (strpos($param, 'url') === 0) {
      $google_scheme = ($GLOBALS['google']['https'] == 'on')
          ? 'https://' : 'http://';
      google_append_url($google_ad_url, $param,
                        $google_scheme . $GLOBALS['google'][$param]);
    } else {
      google_append_globals($google_ad_url, $param);
    }
  }
  return $google_ad_url;
}

$google_ad_handle = @fopen(google_get_ad_url(), 'r');
if ($google_ad_handle) {
  while (!feof($google_ad_handle)) {
    echo fread($google_ad_handle, 8192);
  }
  fclose($google_ad_handle);
}

?>
</div>
<div class="container">

  <hr>
  <p><small>Powered by <strong>Forecast.io</strong><br>Thundered together by Sketchybear<br>Climacons by Adam Whitcroft</small></p>
  
  
</div>

</body>


</html>
