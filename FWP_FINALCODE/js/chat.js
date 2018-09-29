$(function(){
  feedContacts()
  poll()
  $('#sidebarCollapse').on('click', function () {
        $('#sidebar').toggleClass('active');
    });

  $('#message-to-send').on('input', function(){
    var str = $('#message-to-send').val();
    if (str.replace(/\s/g, '').length) {
        $('#send-button').removeAttr('disabled')
    } else{
      $('#send-button').attr('disabled', ' ')
    }
  })

  $('form.send-message').submit(function(){return false;})

  $('#send-button').on("click",sendmessage)

  $('#message-to-send').keydown(function (e){
    if(e.keyCode == 13){
        var str = $('#message-to-send').val();
        if (str.replace(/\s/g, '').length) {
            sendmessage()
        }
    }
})
})

var BASEURL = 'php/'
var currentindex = 0
var currentid = 0
var currentpicture = ''
function feedContacts(showmessages = true){
  //var id = document.cookie['userid']
  var id = getCookie('userID')
  $.ajax({
    url: BASEURL + 'messages.php',
    type: "POST",
    dataType: 'json',
    data: {action: "get-users", userID: id},
    success: function(response){
      if(response.success == 1){
        contacts = response.data
        if(contacts.length > 0){
          var i
          $('ul#contacts').empty();
          for(i = 0; i<contacts.length; i++){
            var contactdisplay = contacts[i].username
            if(contacts[i].messages > 0){
              contactdisplay += " (" + contacts[i].messages + ")"
            }
            var listobject = $("<li></li>").append($("<a></a>").append(contactdisplay))
            listobject.append($("<p></p>").hide().append(contacts[i].id))
            listobject.append($("<p></p>").hide().append(contacts[i].profilepicture))


            if(i == currentindex){
              if(showmessages)
              {
                feedMessages(contacts[i].id, BASEURL + contacts[i].profilepicture)
              }
              listobject.addClass('active')
            }
            $('ul#contacts').append(listobject)

          }
          $('ul#contacts li').on('click', function () {
            currentindex = $('ul#contacts li').index($(this))
            feedMessages($(this).children().eq(1).html(), $(this).children().eq(2).html())
            $('ul#contacts li').removeClass('active')
            $(this).addClass('active')
            feedContacts()
            });
        }
      }
    }
  })
}

function feedMessages(otheruserid, otheruserpicture){
  currentid = otheruserid
  currentpicture = otheruserpicture
  var id = getCookie('userID')
  //var mypicture = document.cookie['profilepicture']
  var mypicture = getCookie('image')
  var pictoshow = BASEURL + mypicture;
  $.ajax({
    url: BASEURL + 'messages.php',
    type: "POST",
    dataType: 'json',
    data: {action: "read", userID: id, oppositeID: otheruserid},
    success: function(response){
      if(response.success == 1){
        if(response.data.length > 0){
          var i
          var messagesarea = $('#content div.messages-area');
          messagesarea.empty();
          for(i = 0; i<response.data.length; i++){
            var m = response.data[i]
            var messageElement = $("<div></div>")
                                  .addClass('message')
                                  .addClass('media')
            if(m.senderID == id){
              messageElement.addClass('you')
              messageElement.append(
                      $('<div></div>').addClass('media-body')
                        .append($('<p></p>').html(m.content))
                        .append($('<span></span>').
                        addClass('messagetime').html(m.messageTime))
                      )
                      .append(
                        $('<div></div>').addClass('media-right')
                          .append(
                              $('<img />').addClass('media-object')
                              .attr('src', pictoshow)
                              .on("error", function(){
                                $(this).attr('src', 'images/generic-user-profile.svg')
                              })
                            ))
            } else if(m.receiverID == id){
              messageElement.addClass('other')
              messageElement.append(
                $('<div></div>').addClass('media-left')
                  .append(
                      $('<img />').addClass('media-object')
                      .attr('src', otheruserpicture)
                      .on("error", function(){
                        $(this).attr('src', 'images/generic-user-profile.svg')
                      })
                    ))
                  .append(
                    $('<div></div>').addClass('media-body')
                      .append($('<p></p>').html(m.content))
                      .append($('<span></span>').
                      addClass('messagetime').html(m.messageTime)))
            }
            messagesarea.append(messageElement)
            messagesarea.scrollTop(messagesarea[0].scrollHeight);

          }
        }
      }
    }
  })
}

function sendmessage(){
  var id = getCookie('userID')
  var attr = $(this).attr('disabled')
  if (!(typeof attr !== typeof undefined && attr !== false)) {

    $.ajax({
      url: BASEURL + 'messages.php',
      type: "POST",
      dataType: 'json',
      data: {action: "send", userID: id, oppositeID: currentid, content: $('#message-to-send').val().trim()},
      success: function(response){
        if(response.success == 1){
          feedMessages(currentid, currentpicture)
          $('#message-to-send').val('')
          $('#send-button').attr('disabled', ' ')
        }
      }
    })

  }
}

function poll(){
  var id = getCookie('userID')
  $.ajax({
    url: BASEURL + 'messages.php',
    type: "POST",
    dataType: 'json',
    data: {action: "get-unread", userID: id},
    success: function(response){
      setTimeout(function(){
        if(response.success == 1){
          if(response.data > 0){
            $.ajax({
              url: BASEURL + 'messages.php',
              type: "POST",
              dataType: 'json',
              data: {action: "get-unread-from", userID: id, oppositeID: currentid},
              success: function(response2){
                updatemessages = false;
                if(response2.success == 1){
                  if(response2.data > 0){
                    updatemessages = true;
                  }
                }
                feedContacts(updatemessages)
              }
            })
          }
        }
        poll()
      },2000)
    }
  })
}
