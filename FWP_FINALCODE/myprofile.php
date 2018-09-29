<?php
if(isset($_COOKIE['userID'])){?>
  <!DOCTYPE html>
  <html lang="en" dir="ltr">
    <head>
      <meta charset="utf-8">
      <title>My Profile</title>
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
      <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
      <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
      <link rel="stylesheet" href="css/font-awesome.min.css">
      <link rel="stylesheet" href="css/profile.css">
      <link rel="stylesheet" href="css/nav.css">
      <link rel="stylesheet" href="css/footer.css">
    </head>
    <body>

      <?php include "php/includes/nav.php"; ?>

      <main class="content">
        <div id="background">
          <div class="featured-image">
            <div class="overlay"></div>
          </div>
        </div>

        <div class="user-section">

          <div class="user-content clearfix">

            <div class="user-profile-picture">
              <div>
                <div>
                  <button class="image-button" id="clear-image"
                  data-toggle="modal" data-target="#clear-image-modal" hidden>Clear</button>
                  <form id="upload-file-form" enctype="multipart/form-data" hidden>
                    <input type="file" name="profilepicture" id="fileToUpload">
                  </form>
                  <button class="image-button" id="upload-image">Upload</button>
                </div>
              </div>
            </div>

            <div class="user-profile-info">
              <h3 class="username-profile">Hi! I'm <span>Brian Isaac</span></h3>
              <p>@<mark class="tag-username">username</mark></p>

              <hr />
              <div class="information-content">
                <div class="statistics clearfix">
                  <div class="statistic-wrapper">
                    <div class="statistic">
                      <p id="available-items">1000</p>
                      <p>Available items</p>
                    </div>
                  </div>
                  <div class="statistic-wrapper">
                    <div class="statistic">
                      <p id="given-items">1000</p>
                      <p>Given items</p>
                    </div>
                  </div>
                  <div class="statistic-wrapper">
                    <div class="statistic">
                      <p id="requested-items">0</p>
                      <p>Requested items</p>
                    </div>
                  </div>
                </div>
                <div class="general-info">
                  <div class="user-info-section">
                    <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
                    <span class="tag">Email: </span> <span id="email-user">user@email.com</span>
                  </div>
                  <div class="user-info-section">
                    <span class="glyphicon glyphicon-home" aria-hidden="true"></span>
                    <span class="tag">Address: </span> <span id="address-user">24 High Street North</span>
                  </div>
                  <div class="user-info-section">
                    <span class="glyphicon glyphicon-earphone" aria-hidden="true"></span>
                    <span class="tag">Phone: </span> <span id="phone-user">07512 691549</span>
                  </div>
                </div>
              </div>

            </div>

          </div>

          <div id="floatbutton" data-toggle="modal" data-target="#editmodal">
            <span class="glyphicon glyphicon-pencil"></span>
          </div>

          <div class="bottom-banner"></div>

        </div> <!--.user-section-->
      </main> <!--.content-->

      <?php include "php/includes/footer.php"; ?>
      <div class="modal fade" tabindex="-1" role="dialog" id="editmodal">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title">Edit your profile</h4>
            </div>
            <div class="modal-body">
              <form id="edit-form">
                <div class="form-group row">
                  <label for="staticEmail" class="col-sm-2 col-md-3 col-lg-3">Email</label>
                  <div class="col-sm-10 col-md-9 col-lg-9">
                    <input type="text" readonly class="form-control" id="staticEmail">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="firstname" class="col-sm-2 col-md-3 col-lg-3 col-form-label">First Name</label>
                  <div class="col-sm-10 col-md-9 col-lg-9">
                    <input type="text" class="form-control" id="firstname" name="firstname">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="lastname" class="col-sm-2 col-md-3 col-lg-3 col-form-label">Last Name</label>
                  <div class="col-sm-10 col-md-9 col-lg-9">
                    <input type="text" class="form-control" id="lastname" name="lastname">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="address" class="col-sm-2 col-md-3 col-lg-3 col-form-label align-middle">Address</label>
                  <div class="col-sm-10 col-md-9 col-lg-9">
                    <input type="text" class="form-control" id="address" name="address">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="phone" class="col-sm-2 col-md-3 col-lg-3 ">Phone</label>
                  <div class="col-sm-10 col-md-9 col-lg-9">
                    <input type="text" class="form-control" id="phone" name="phoneNo">
                  </div>
                </div>
              </form>
            </div>
            <div class="modal-footer">
              <button id="update-user-modal" class="btn btn-primary" type="button">Save changes</button>
              <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" tabindex="-1" role="dialog" id="interestsmodal">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title">Add interests</h4>
            </div>
            <div class="modal-body">
              <form>

              </form>
            </div>
            <div class="modal-footer">
              <button id="edit-interest-modal" class="btn btn-primary" type="button">Save interests</button>
              <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" tabindex="-1" role="dialog" id="upload-image-modal">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title">Upload image</h4>
            </div>
            <div class="modal-body">
              <p>Are you sure you want to upload the following image?</p>
              <div class="image-to-upload-wrapper"><div class="image-to-upload"></div></div>
            </div>
            <div class="modal-footer">
              <button id="upload-image-button" class="btn btn-primary" type="button">Upload</button>
              <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" tabindex="-1" role="dialog" id="clear-image-modal">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title">Clear image</h4>
            </div>
            <div class="modal-body">
              <p>Are you sure you want to delete your profile picture?</p>
            </div>
            <div class="modal-footer">
              <button id="delete-image-button" class="btn btn-primary" type="button">Delete</button>
              <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            </div>
          </div>
        </div>
      </div>



      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
      <script src="js/cookies.js"></script>
      <script src="js/nav.js"></script>
      <script src="js/profilemain.js"></script>
    </body>
  </html>

<?php } else {
  header('HTTP/1.0 403 Forbidden');
}
 ?>
