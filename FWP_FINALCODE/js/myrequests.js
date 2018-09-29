$(function(){
  filltransactions()
})

function filltransactions(){
  var id = getCookie('userID')
  $.post('php/transactions2.php',
        {userID: id, action: 'viewordering'},
        function(response){
          if(response.success){
            $('.list').empty()
            response.data.forEach(function(element){

              var transaction = $('<div></div>')
                                  .addClass('transaction')
                                  .addClass('clearfix')
              var image = $('<div></div>').addClass('image')
              var itemimage = $('<div></div>').addClass('item-image')
              image.append(itemimage)
              var transinfo = $('<div></div>').addClass('trans-info')
              var iteminfo = $('<div></div>').addClass('item-info')
              var namefield = $('<p></p>').addClass('name-field')
              namefield.append($('<span></span>').addClass('tag-label').text('Name: '))
              namefield.append(element.name)
              var bestbeforefield = $('<p></p>').addClass('bestbefore-field')
              bestbeforefield.append($('<span></span>').addClass('tag-label').text('Best before: '))
              bestbeforefield.append(element.bestbeforeDate)
              var caloriesfield = $('<p></p>').addClass('calories-field')
              caloriesfield.append($('<span></span>').addClass('tag-label').text('Calories: '))
              caloriesfield.append(element.calorie)
              var descriptionfield = $('<p></p>').addClass('description-field')
              descriptionfield.append($('<span></span>').addClass('tag-label').text('Description: '))
              descriptionfield.append(element.description)
              var mapfield = $('<p></p>').addClass('map-field')
              mapfield.append($('<a></a>').attr('href', "https://www.google.com/maps/search/?api=1&query="+
                                                            element.gmapLatitude+"," + element.gmapLongitude)
                                                          .attr('target', '_blank').text('View location'))
              var transdate = $('<div></div>').addClass('trans-date')
              transdate.append($('<p></p>').text(element.transDate))
              var userinfo = $('<div></div>').addClass('user-info')

              var usernamefield = $('<p></p>').addClass('username-field')
              usernamefield.append($('<span></span>').addClass('tag-label').text('User: '))
              usernamefield.append('@')
              usernamefield.append($('<mark></mark>').text(element.username))
              userinfo.append(usernamefield)

              transaction.append(image)
              iteminfo.append(namefield)
              iteminfo.append(bestbeforefield)
              iteminfo.append(caloriesfield)
              iteminfo.append(descriptionfield)
              iteminfo.append(mapfield)
              transinfo.append(iteminfo)
              transinfo.append(transdate)
              transinfo.append(userinfo)

              transaction.append(transinfo)

              $('.list').append(transaction)
            })
          } else {
            $('.list').html(
              $('<div></div>').html($('<p></p>').addClass('no-trans')
              .text('You have not requested any item yet!'))
            )
          }
        }, 'json')
}
