<?php
if(isset($_COOKIE['userID'])){ ?>
  <!DOCTYPE html>
  <html lang="en" dir="ltr">
    <head>
      <meta name = "viewport" content = "width = device-width, initial-scale = 1.0">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
      <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
      <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
      <link rel="stylesheet" href="css/font-awesome.min.css">
      <link rel="stylesheet" href="css/recommendations.css">
      <link rel="stylesheet" href="css/nav.css">
      <link rel="stylesheet" href="css/footer.css">
      <meta charset="utf-8">
      <title>Recommendations</title>
    </head>
    <body>
      <?php include "php/includes/nav.php";?>
      <main class="content">
        <div class="info-content">
          <section class="period-selector">
            <label for="" class="title-label">Period</label>
            <div class="dropdown">
              <button class="btn btn-default dropdown-toggle" type="button" id="menu1" data-toggle="dropdown"><span id="dd-title">Two weeks</span>
              <span class="caret"></span></button>
              <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                <li role="presentation"><a id="s1" role="menuitem" tabindex="-1" href="#">Two weeks</a></li>
                <li role="presentation"><a id="s2" role="menuitem" tabindex="-1" href="#">One month</a></li>
                <li role="presentation"><a id="s3" role="menuitem" tabindex="-1" href="#">Always</a></li>
              </ul>
            </div>
          </section>
          <section class="recom-area clearfix" hidden>
            <div class="chart-zone area-cat">
              <h2>Categories you shared the most</h2>
              <div class="chart-container">
                <canvas id="chart"></canvas>
              </div>
            </div>
            <div class="recom-zone">
              <h4>Your most common combination...</h4>
              <p>This was your most common combination of categories per single item.
                You should try stop buying food with the these categories!</p>
              <div class="cat-combination">
              </div>
            </div>

          </section>

          <section class="recom-area clearfix" hidden>
            <div class="chart-zone area-day">
              <h3>Your shares through the week</h3>
              <div class="chart-container">
                <canvas id="daychart"></canvas>
              </div>
            </div>
            <div class="recom-zone">
              <h4>The period you share the most...</h4>
              <p>In this part of the week you usually share a lot of items.
              You should buy less food these days!</p>
              <div class="days-combination">
                <p></p>
              </div>
            </div>
          </section>
        </div>

      </main>
      <?php include "php/includes/footer.php";?>

      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
      <script src="js/cookies.js"></script>
      <script src="js/nav.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
      <script src="js/recommendations.js"></script>
    </body>
  </html>
<?php } else{
  header('HTTP/1.0 403 Forbidden');
}
 ?>
