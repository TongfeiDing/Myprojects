$(function(){
  var id = parseInt($("#userid").html())
  fillInterests(id)
  fillProfile(id, true, true);

  $('#update-user-modal').click(function(){updateUser(id)})
  $('#edit-interest-modal').click(function(){
    updateInterestsFromUser(id)
  })

  $('#upload-image').click(function(){$('#fileToUpload').click()})
  $('#fileToUpload').change(function(){
    readURL(this)
  })
  $('#upload-image-button').click(function(){uploadimage(id)})
  $('#delete-image-button').click(function(){clearImage(id)})

})

var BASEURL = 'php/'

function fillProfile(id, updatetags = true, fillstatistics = false){
  $.ajax({
    url: BASEURL + 'profile.php',
    type: "POST",
    dataType: 'json',
    data: {userid: id},
    success: function(response){
      if(response.success){
        var profile = response.data
        $.get(BASEURL + profile.image)
            .done(function() {
              $('div.user-profile-picture > div')
                .css('background-image', "url('" + BASEURL + profile.image + "')")
              $('#clear-image').removeAttr('hidden')
            })
            .fail(function() {
                $('div.user-profile-picture > div')
                  .css('background-image', "url('images/generic-user-profile.svg')")
                $('#clear-image').attr('hidden', '')
              })

        $('h3.username-profile span').text(profile.firstName + " " + profile.lastName)
        $('#firstname').val(profile.firstName)
        $('#lastname').val(profile.lastName)
        $('mark.tag-username').text(profile.username)
        $('#email-user').text(profile.email)
        $('#staticEmail').val(profile.email)
        $('#address-user').text(profile.address)
        $('#address').val(profile.address)
        $('#phone-user').text(profile.phoneNo)
        $('#phone').val(profile.phoneNo)
        if(updatetags)
        {
          fillTags(id)
        }
        if(fillstatistics){
          fillStatistics(id)
        }
      }
    }
  })
}

function fillTags(id, isnew=true){
  $.ajax({
    url: BASEURL + 'usercategories.php',
    type: "POST",
    dataType: 'json',
    data: {userid: id},
    success: function(response){
      if(response.success){
        var container = $('<div></div>')
          .addClass('user-info-section')
          .attr('id', 'tags-section')
          .html(
            $('<span></span>').text('Interests: ').addClass('tag')
          )
        var categories = response.data
        categories.forEach(function(element){
          container
            .append(
              $('<span></span>')
                .addClass('interest-tags-id')
                .text(element.id)
              )
            .append(
              $('<mark></mark>')
                .addClass('interest-tags')
                .text(element.name)
              )
            })
            if(isnew){
              $('div.general-info').append(container)
            } else {
              $('#tags-section').remove()
              $('.interests-button').remove()
              $('div.general-info').append(container)
            }

      }
      var button = $('<button></button>')
                    .addClass('interests-button')
                    .attr('data-toggle', 'modal')
                    .attr('data-target', '#interestsmodal')
                    .text(response.success ? 'Edit interests' : 'Add Interests')
      $('div.general-info').append(button)
    }
  })
}

function updateUser(id){
  var data = {
    username: $('mark.tag-username').text(),
    firstname: $('#firstname').val(),
    lastname: $('#lastname').val(),
    address: $('#address').val(),
    phoneNo: $('#phone').val()
  }
  $.ajax({
    url: BASEURL + 'updateuser.php',
    type: "POST",
    dataType: 'json',
    data: data,
    success: function(response){
      $('#editmodal').modal('hide')
      if(response.success){
        fillProfile(id, false)
      }
    }
  })
}

function fillInterests(id){
  $.post(BASEURL + "usercategories.php", {userid: id}, function(response){
    if(response.success){
      writeInterests(response.data)
    } else{
      writeInterests()
    }
  }, 'json')
}

function writeInterests(interests = null){
  $.get(BASEURL + "getcategories.php", '', function(response){
    var form = $('#interestsmodal div.modal-body form')
    form.empty()
    console.log(interests)
    response.forEach(function(category){
      var checkbox =   $('<input></input>').attr('type', 'checkbox');
      if(interests != null){
        if(interests.some(function(o){return o['id'] === category.categoryID})){
          checkbox.attr('checked', '')
        }
      }
      form.append(checkbox)
      form.append(
        $('<span></span>')
          .css('display', 'none')
          .text(category.categoryID)
      )
      form.append(category.name)
      form.append('<br />')

    })
  }, 'json')
}

function updateInterestsFromUser(id){
   var cids = $('#interestsmodal div.modal-body form input:checked')
                .next()
                .map(function(){return $(this).text()})
                .get()
    console.log(cids)
    $.post(BASEURL + "usercategories.php", {userid: id, "categories[]": cids},
    function(response){
      console.log(response)
      if(response.success){
        fillTags(id, false)
        fillInterests(id)
        $('#interestsmodal').modal('hide')
      } else {
        alert('ERROR')
      }
    }, 'json')

}

function readURL(input) {

  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function(e) {
      $('#upload-image-modal').modal('toggle')
      $('#upload-image-modal .modal-body div.image-to-upload')
        .css('background-image', 'url(' + e.target.result + ')')
    }

    reader.readAsDataURL(input.files[0]);
  }
}

function uploadimage(id){
  var form = $('#upload-file-form')[0]
  var formData = new FormData(form);
  formData.append('username', $('mark.tag-username').text())
  console.log(formData)
  $.ajax({
    url: BASEURL + 'updateuser.php',
    type: "POST",
    dataType: 'json',
    data: formData,
    contentType: false,
    processData: false,
    success: function(response){
      $('#upload-image-modal').modal('toggle')
      if(response.success){
        fillProfile(id, false)
      }
    }
  })
}

function clearImage(id){
  $.post(BASEURL + 'clearprofilepicture.php', {userid: id},
    function(response){
      if(response.success){
        $('#clear-image-modal').modal('toggle')
        fillProfile(id, false)
      }
    }, 'json')
}

function fillStatistics(id){
  $.post(BASEURL + 'getstatistics.php', {userid: id},
    function(response){
      if(response.success){
        $('#available-items').text(response.data.available)
        $('#given-items').text(response.data.given)
        $('#requested-items').text(response.data.requested)
      }
    }, 'json')
}
// JavaScript Document