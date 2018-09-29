<?php
  $userID = $_POST['userID'];

  //0 -> all data
  //1 -> two weeks
  //2 -> one month

  $timetag = 0;
  if(isset($_POST['timeselection']))
  {
    $timetag = intval($_POST['timeselection']);
  }

  $frequery = "SELECT
  SUM(CASE WHEN categoryID = 1 THEN 1 ELSE 0 END) as F1,
  SUM(CASE WHEN categoryID = 2 THEN 1 ELSE 0 END) as F2,
  SUM(CASE WHEN categoryID = 3 THEN 1 ELSE 0 END) as F3,
  SUM(CASE WHEN categoryID = 4 THEN 1 ELSE 0 END) as F4,
  SUM(CASE WHEN categoryID = 5 THEN 1 ELSE 0 END) as F5,
  SUM(CASE WHEN categoryID = 6 THEN 1 ELSE 0 END) as F6,
  SUM(CASE WHEN categoryID = 7 THEN 1 ELSE 0 END) as F7,
  SUM(CASE WHEN categoryID = 8 THEN 1 ELSE 0 END) as F8,
  SUM(CASE WHEN categoryID = 9 THEN 1 ELSE 0 END) as F9,
  SUM(CASE WHEN categoryID = 10 THEN 1 ELSE 0 END) as F10,
  SUM(CASE WHEN categoryID = 11 THEN 1 ELSE 0 END) as F11,
  SUM(CASE WHEN categoryID = 12 THEN 1 ELSE 0 END) as F12,
  SUM(CASE WHEN categoryID = 13 THEN 1 ELSE 0 END) as F13,
  SUM(CASE WHEN categoryID = 14 THEN 1 ELSE 0 END) as F14,
  SUM(CASE WHEN categoryID = 15 THEN 1 ELSE 0 END) as F15,
  SUM(CASE WHEN categoryID = 16 THEN 1 ELSE 0 END) as F16
  FROM Item_category
  INNER JOIN Items ON Items.itemID = Item_category.itemID
  WHERE Items.uploaderID = {$userID} ";

  if($timetag == 1){
    $twoweeksago = date('Y-m-d', strtotime("-2 week"));
    $frequery .= "AND Items.uploadDate >= '{$twoweeksago}' ";
  } else if($timetag == 2){
    $onemonthago = date('Y-m-d', strtotime("-1 month"));
    $frequery .= "AND Items.uploadDate >= '{$onemonthago}' ";
  }

  $responsecode = 0;
  $response = array();
  include 'DBconn.php';
  if($result = $conn->query($frequery)){

    if($row = $result->fetch_assoc()){
      $responsecode = 1;
      $F = array();
      for($i = 1; $i<=sizeof($row); $i++){
        $F[$i] = intval($row['F'.$i]);
      }
      $avg = array_sum($F)/count($F);
      $Fnorm = array();
      foreach ($F as $f) {
        $Fnorm[] = $f - $avg;
      }
      $Frs = $F;
      arsort($Frs);
      $keys = array_keys($Frs);

      $C = -1;
      $imax = 0;
      $jmax = 0;
      $kmax = 0;
      $n = sizeof($Fnorm);
      //Norm of Fnorm
      $norm = 0;
      for($i = 0; $i<$n; $i++){
        $norm += $Fnorm[$i] * $Fnorm[$i];
      }
      $norm = sqrt($norm);
      //For one category
      for($i = 0; $i<$n; $i++){
        $c = $Fnorm[$i]/$norm;
        if($c > $C){
          $C = $c;
          $imax = $i + 1;
        }
      }


      //For two categories
      for($i = 0; $i<$n; $i++){
        for($j = 0; $j<$n; $j++){
          if($j != $i){
            $c = ($Fnorm[$i] + $Fnorm[$j])/($norm*sqrt(2));
            if($c > $C){
              $C = $c;
              $imax = $i + 1;
              $jmax = $j + 1;
            }
          }
        }

      }


      //For three categories
      for($i = 0; $i<$n; $i++){
        for($j = 0; $j<$n; $j++){
          for($k = 0; $k<$n; $k++){
            if($i != $j && $i != $k && $j != $k){
              $c = ($Fnorm[$i] + $Fnorm[$j] + $Fnorm[$k])/($norm*sqrt(3));
              if($c > $C){
                $C = $c;
                $imax = $i + 1;
                $jmax = $j + 1;
                $kmax = $k + 1;
              }
            }
          }
        }

      }

      $dataarr = array();
      $dataarr['frequency'] = $Frs;
      $dataarr['most_common_combination'] = array($imax, $jmax, $kmax);
      $response['data'] = array();
      $response['data']['bycat'] = $dataarr;

      $daysquery = "SELECT
                    SUM(CASE WHEN DAYOFWEEK(uploadDate) = 1 THEN 1 ELSE 0 END) as sun,
                    SUM(CASE WHEN DAYOFWEEK(uploadDate) = 2 THEN 1 ELSE 0 END) as mon,
                    SUM(CASE WHEN DAYOFWEEK(uploadDate) = 3 THEN 1 ELSE 0 END) as tue,
                    SUM(CASE WHEN DAYOFWEEK(uploadDate) = 4 THEN 1 ELSE 0 END) as wed,
                    SUM(CASE WHEN DAYOFWEEK(uploadDate) = 5 THEN 1 ELSE 0 END) as thu,
                    SUM(CASE WHEN DAYOFWEEK(uploadDate) = 6 THEN 1 ELSE 0 END) as fri,
                    SUM(CASE WHEN DAYOFWEEK(uploadDate) = 7 THEN 1 ELSE 0 END) as sat
                    FROM Items
                    WHERE uploaderID = {$userID}";
      if($result = $conn->query($daysquery)){
        if($days = $result->fetch_assoc()){
          $avg = array_sum($days)/7;
          $Dnorm = array();
          $ndays = array_values($days);
          foreach($ndays as $day){
            $Dnorm[] = $day - $avg;
          }


          $C = -1;
          $imax = -1;
          $jmax = -1;
          $kmax = -1;

          //For one day
          for($i = 0; $i<7; $i++){
            $c = $Dnorm[$i];
            if($c > $C){
              $C = $c;
              $imax = $i;
            }
          }

          //For two days
          for($i = 0; $i<7; $i++){
            for($j = 0; $j<7; $j++){
              if($j != $i){
                $c = ($Dnorm[$i] + $Dnorm[$j])/sqrt(2);
                if($c > $C){
                  $C = $c;
                  $imax = $i;
                  $jmax = $j;
                }
              }
            }

          }


          //For three categories
          for($i = 0; $i<7; $i++){
            for($j = 0; $j<7; $j++){
              for($k = 0; $k<7; $k++){
                if($i != $j && $i != $k && $j != $k){
                  $c = ($Dnorm[$i] + $Dnorm[$j] + $Dnorm[$k])/sqrt(3);
                  if($c > $C){
                    $C = $c;
                    $imax = $i;
                    $jmax = $j;
                    $kmax = $k;
                  }
                }
              }
            }
          }

          $dayarr = array();
          $dayarr['frequency'] = $days;
          $dayarr['most_common_combination'] = array($imax, $jmax, $kmax);
          $response['data']['byday'] = $dayarr;
        }
      }
    }
  }

  $response['success'] = $responsecode;
  echo json_encode($response, JSON_NUMERIC_CHECK);

?>
