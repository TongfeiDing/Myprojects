$(function(){
  getCategories()

  $('.dropdown-menu > li a').click(showagain)
})
var categories;

var BASEURL = 'php/'
function getCategories(){
  $.get(BASEURL + 'getcategories.php', '', function(response){
    categories = response;
    getUserRecommendations()
  }, 'json')
}
function getUserRecommendations(timeselect = 1){
  var id = getCookie('userID')
  $.post(BASEURL + 'recommendationsalgorithm.php',
  {userID: id, timeselection: timeselect},
  function(response){
    if(response.success){
      var sum = 0
      var freqs = response.data.bycat.frequency
      var tosort = new Array()
      var tags = new Array()
      var vals = new Array()
      var keys = Object.keys(freqs)
      for(var i = 0; i<keys.length; i++){
        tosort[i] = {tag: getCatName(parseInt(keys[i])), val: freqs[keys[i]] }
      }
      var sorted = tosort.sort(function(a,b){return b.val - a.val})
      for(var i = 0; i<keys.length; i++){
        tags[i] = sorted[i].tag
        vals[i] = sorted[i].val
      }

      vals.forEach(function(element){
        sum += element
      })

      if(sum >= 10){
        $('.recom-area').removeAttr('hidden')
        var mostcommoncats = response.data.bycat.most_common_combination
        $('.cat-combination').empty()
        $('.cat-combination').append(
          $('<p></p>').addClass('cat3').text(getCatName(mostcommoncats[0])))

        if(mostcommoncats[1] > 0){
          $('.cat-combination').append(
            $('<p></p>').addClass('cat2').text(getCatName(mostcommoncats[1])))
        }

        if(mostcommoncats[2] > 0){
          $('.cat-combination').append(
            $('<p></p>').addClass('cat1').text(getCatName(mostcommoncats[2])))
        }

        fillChart(tags, vals)

        var dfreq = response.data.byday.frequency
        var dvals = new Array()
        dvals[0] = dfreq.mon
        dvals[1] = dfreq.tue
        dvals[2] = dfreq.wed
        dvals[3] = dfreq.thu
        dvals[4] = dfreq.fri
        dvals[5] = dfreq.sat
        dvals[6] = dfreq.sun

        var mostcommondays = response.data.byday.most_common_combination
        console.log(mostcommondays[0])
        console.log(mostcommondays[1])
        console.log(mostcommondays[2])
        var minday = mostcommondays[0]
        var maxday = minday
        if(mostcommondays[2] > 0){
          maxday = mostcommondays[2]
        } else if(mostcommondays[1] > 0){
          maxday = mostcommondays[1]
        }
        var daystring = ''
        if(minday == maxday){
          daystring = getDay(minday)
        } else {
          if(minday == 1){
            if(maxday <= 3){
              daystring = getDay(minday) + " - " + getDay(maxday)
            } else {
              daystring = getDay(maxday) + " - " + getDay(minday)
            }
          } else if(maxday == 7){
            if(minday >= 5){
              daystring = getDay(minday) + " - " + getDay(maxday)
            } else {
              daystring = getDay(maxday) + " - " + getDay(minday)
            }
          }
        }

        $('.days-combination p').text(daystring)

        fillDaysChart(dvals)
      } else {
        $('.info-content').html(
          $('<p></p>').addClass('not-enough')
          .text("You don't have enough data to get recommendations")
        )
      }

    }
  } ,'json')
}
function fillChart(tags, vals){
  var ctx = document.getElementById('chart').getContext("2d")
  var myChart = new Chart(ctx, {
      type: 'bar',
      data: {
          //labels: ["JAN", "FEB", "MAR", "APR", "MAY", "JUN", "JUL"],
          labels: tags,
          datasets: [{
              label: "Frequency",
              borderColor: "#EB5757",
              backgroundColor: "rgba(253, 87, 87, 0.5)",
              hoverBorderWidth: 1,
              fill: false,
              borderWidth: 1,
              data: vals
          }]
      },
      options: {
          legend: {
            display: false
          },
          scales: {
              yAxes: [{
                  ticks: {
                      fontColor: "rgba(0,0,0,0.5)",
                      fontStyle: "bold",
                      beginAtZero: true,
                      maxTicksLimit: 5,
                      padding: 20
                  },
                  gridLines: {
                      drawTicks: false,
                      display: false
                  }
  }],
              xAxes: [{
                  gridLines: {
                      zeroLineColor: "transparent"
  },
                  ticks: {
                      padding: 20,
                      fontColor: "rgba(0,0,0,0.5)",
                      fontStyle: "bold"
                  }
              }]
          }
      }
  });
}

function getCatName(index){
  for(var i = 0; i<categories.length; i++){
    if(categories[i].categoryID === index){
      return categories[i].name
    }
  }
}

function getDay(day){
  switch (day) {
    case 1:
      return 'MON';
    case 2:
      return 'TUE';
    case 3:
      return 'WED';
    case 4:
      return 'THU';
    case 5:
      return 'FRI';
    case 6:
      return 'SAT';
    case 7:
      return 'SUN';
    default:
      return '';
  }
}

function fillDaysChart(freq){
  var ctx = document.getElementById('daychart').getContext("2d")

  var gradientStroke = ctx.createLinearGradient(0, 0, 0, 500);
  gradientStroke.addColorStop(0, 'red');
  gradientStroke.addColorStop(0.2, 'red');
  gradientStroke.addColorStop(1, 'blue');

  var gradientFill = ctx.createLinearGradient(0, 0, 0, 500);
  gradientFill.addColorStop(0, "rgba(255, 0, 0, 0.6)");
  gradientFill.addColorStop(0.2, "rgba(255, 0, 0, 0.6)");
  gradientFill.addColorStop(1, "rgba(0, 0, 255, 0.6)");

  var myChart = new Chart(ctx, {
      type: 'line',
      data: {
          labels: ["MON", "TUE", "WED", "THU", "FRI", "SAT", "SUN"],
          datasets: [{
              label: "Items",
              borderColor: gradientStroke,
              pointBorderColor: gradientStroke,
              pointBackgroundColor: gradientStroke,
              pointHoverBackgroundColor: gradientStroke,
              pointHoverBorderColor: gradientStroke,
              pointBorderWidth: 10,
              pointHoverRadius: 10,
              pointHoverBorderWidth: 1,
              pointRadius: 3,
              fill: true,
              backgroundColor: gradientFill,
              borderWidth: 4,
              data: freq
          }]
      },
      options: {
          legend: {
              display: false
          },
          animation: {
            easing: "easeInOutBack"
          },
          scales: {
              yAxes: [{
                  ticks: {
                      fontColor: "rgba(0,0,0,0.5)",
                      fontStyle: "bold",
                      beginAtZero: true,
                      maxTicksLimit: 5,
                      padding: 10
                  },
                  gridLines: {
                      drawTicks: false,
                      display: false
                  }
  }],
              xAxes: [{
                  gridLines: {
                      zeroLineColor: "transparent"
  },
                  ticks: {
                      padding: 20,
                      fontColor: "rgba(0,0,0,0.5)",
                      fontStyle: "bold"
                  }
              }]
          }
      }
  });
}

function showagain(){
  $('#dd-title').text($(this).text())
  var sid = $(this).attr('id')

  if(sid === 's1'){
    getUserRecommendations()
  } else if(sid === 's2'){
    getUserRecommendations(2)
  } else if(sid === 's3'){
    getUserRecommendations(0)
  }
}
