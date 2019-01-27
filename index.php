<!-- Importing php files, where json parsing is happening -->
<?php
  //Reading json files
  $articlesFile = file_get_contents('data/articles.json');
  $eventsFile = file_get_contents('data/events.json');
  $userFile = file_get_contents('data/user.json');

  //Parsing JSON files
  $articles = json_decode($articlesFile, true);
  $events = json_decode($eventsFile, true);
  $user = json_decode($userFile, true);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset = utf-8/>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<title>3B Digital</title>
<link href="./css/style.css" rel="stylesheet" />
</head>
<body>
<header>
  <div class="navbar navbar-white bg-white shadow-sm">
    <div class="container">
    <a class="navbar-brand" href="#">
          <img class="logo" src="./images/image.png">
        </a>
      <strong>Hi, John!</strong>
  </div>
</header>
<div class="container">
  <div class="col-sm-9 float-left articles-col">
    <h4 class="articles-header">Articles</h4>
      <div class="col-md-12">
        <div class="row">
          <!-- Iterating through articles and generating cards  -->
              <?php for ($i = 0; $i < count($articles); ++$i): ?>
                <div class="col-md-6">
                  <div class="card card-article">
                    <h5 class="card-header"><?php print $articles[$i]["title"]; ?></h5>
                    <img class="card-img" src="./images/image.png" class="img">
                    <div class="card-body">
                      <?php print strip_tags(substr($articles[$i]["content"], 0, 100));  echo '...<a href="'.$articles[$i]['url'].'" target="_blank"> read more</a>' ?>
                    </div>
                  </div>
                </div>
              <?php endfor; ?>
            </div>
      </div>
  </div>
  <div class="col-sm-3 float-right events-col">
    <h4 class="events-header">Events</h4>
    <div class="row">
            <?php
              // Sorting events by time
              function compareByTimeStamp($time1, $time2) 
              { 
                return strtotime($time1["date"]) - strtotime($time2["date"]);
              } 
              usort($events, "compareByTimeStamp");

              // Iterating through events and inserting events where event tags match user interests
              for ($i = 0; $i < count($events); ++$i):
                  if (in_array('alternative', $events[$i]['tags']) || in_array('rock', $events[$i]['tags'])) { 
                    $event_title =  $events[$i]["title"];
                    $event_location = $events[$i]["location"];
                    $event_location_map = '<a href="https://www.google.com/maps/place/'.$events[$i]['geo']['lat'].','.$events[$i]['geo']['lng'].'" 
                        target="_blank"><i class="material-icons" style="font-size: 15px">place</i></a>';
                    $event_date = $events[$i]["date"];
                    echo '
                    <div class="col-md-12">
                      <div class="card">
                        <div class="card-body event-card-body">
                          <h5 class="card-title">'.$event_title.'</h5>
                          <b>Location: </b> '.$event_location.' '.$event_location_map .' <br>
                          <b>Date: </b> '.$event_date.'
                        </div>
                      </div>
                  </div>';
                  }
              ?>
            <?php endfor; ?>
          </div>
  </div>
</div>
</body>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
</html>