<?php
require_once("includes/config.php");
?>
<!DOCTYPE html>
<html lang="en">
   <head>
   <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Gigya Password Validator</title>
      <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
      <link href="https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/paper/bootstrap.min.css" rel="stylesheet" integrity="sha384-awusxf8AUojygHf2+joICySzB780jVvQaVCAt1clU3QsyAitLGul28Qxb2r1e5g+" crossorigin="anonymous">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css">

      <style type="text/css">
         html {
         min-height: 100%;
         position: relative;
         }
         body {
         background-color: #FEFEFE;
         margin-bottom: 60px;
         }
         body #history ol {
         padding-left: 20px;
         }
         body #history ol a {
         overflow: hidden;
         }
         .header {
         background-color: #1565C0;
         min-height: 64px;
         margin-bottom: 50px;
         }
         .header svg
         {
         height: 30px;
         margin-right:30px;
         }
         .heading {
         color: #FFFFFF;
         font-family: Arial, Helvetica, sans-serif;
         font-size: 1.1em;
         font-weight: bold;
         margin: 0px;
         margin-top: 15px;
         max-height: 64px;
         padding: 0 16px;
         }
         .vcenter {
         display: inline-block;
         float: none;
         vertical-align: middle;
         }
      </style>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
      <script src="js/algorithms.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

      <script type="text/javascript">

         $(document).ready(function()
         {

            $('#selectAlgorithms').change(function(e)
            {
               var algo = $(this).find(":selected");
               var urlRequired = $(algo).data("url");
               if(urlRequired) $('#customURLContainer').show(); else $('#customURLContainer').hide();
               $('.algorithmText').html(algo.val());

            });

            $('#hashedPassword').change(function(e)
            {
               var pwd = $(this).val();
               if( pwd.match(/[^A-Fa-f0-9]/) || pwd.length % 2 !== 0 ) {
                  $('#hexError').hide();
               }
               else
               {
                  if(pwd.length > 0)
                  $('#hexError').fadeIn();
               }
            });

            $('#btnValidate').click(function(e)
            {
               var pwd = $('#hashedPassword').val();
               var passEncType = "hex";
               if( pwd.match(/[^A-Fa-f0-9]/) || pwd.length % 2 !== 0 ) {
               	passEncType = "base64";
               }
               var salt = $('#salt').val();
               var saltEncType = "hex";
               if( salt.match(/[^A-Fa-f0-9]/) || salt.length % 2 !== 0 ) {
               	saltEncType = "base64";
               }
               $.post( "validate.php", { plainpass: $('#plainPass').val(), hashedpass: $('#hashedPassword').val(), salt: $('#salt').val(), algorithm: $('#selectAlgorithms').find(":selected").val(), rounds: 1, requiredSalt: $('#selectAlgorithms').find(":selected").data('salt'), requiredURL: $('#selectAlgorithms').find(":selected").data('url'), url: $('#customURL').val(), passwordFormat: $('#passwordFormat').val(), passEncType: passEncType, saltEncType: saltEncType }).done(function( data ) {
                 if(data.valid)
                 {
                 	$('#hashTemplate').html(JSON.stringify(JSON.parse(data.template), null, 2));
                  $('#successModal').modal({
                    keyboard: false
                  });
                 }
                 else
                 {
                  $('#invalidModal').modal({
                    keyboard: false
                  });
                 }
               });
            });
         });
      </script>

   </head>
   <body>
   <!-- Modal -->
<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
      <div class="row">
        <div class="text-center">
        <i class="zmdi zmdi-check-circle zmdi-hc-5x text-success"></i>
        </div>
        <h3 class="text-center">Hash Validated!</h3>
        </div>
        <div class="row">
        <div class="col-md-offset-1 col-md-10">
        The hash has been successfully validated. Please find the hash settings for the algorithm below.<br /><br />
        </div>

        <div class="col-md-offset-1 col-md-10">
        <pre id="hashTemplate" class=""></pre>
        </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
   <!-- / Modal -->
   <!-- Modal -->
<div class="modal fade" id="invalidModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
      <div class="row">
        <div class="text-center">
        <i class="zmdi zmdi-alert-circle zmdi-hc-5x text-danger"></i>
        </div>
        <h3 class="text-center">Invalid Hash!</h3>
        </div>
        <div class="row">
        <div class="text-center">
        The hash did not match the plain text version.
        </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
   <!-- / Modal -->
      <div class="container-fluid">
      <div class="header row">
         <div class="heading vcenter">
            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="3 609.9 612 182.5" enable-background="new 3 609.9 612 182.5" xml:space="preserve">
               <g>
                  <path fill="#FFFFFF" d="M134.6,669.1c0-1.5-0.2-15.9-8.5-30c-5-8.7-12-15.5-20.7-20.4c-10.2-5.9-22.6-8.8-36.8-8.8
                     c-14.1,0-26.5,3-36.7,8.8c-8.6,4.9-15.5,11.9-20.6,20.4c-8.1,14-8.3,27.8-8.3,29.4v67c0,1.5,0.2,15,8.5,28.8
                     c7.8,12.9,24,28.2,57.1,28.2c33.3,0,49.5-15.4,57.4-28.5c8.3-13.7,8.5-27.4,8.5-29v-39.4h-15.3l0,0h-60l7.3,27.7h37.3v11.5
                     c0,0.6-0.4,7.6-4.6,14c-5.5,8.5-15.7,12.7-30.6,12.7c-14.6,0-24.8-4.2-30.3-12.5c-4.1-6.4-4.5-13.2-4.5-13.8v-66.7
                     c0-0.6,0.4-8,4.6-14.7c5.5-8.8,15.4-13.1,30.2-13.1c14.9,0,24.8,4.3,30.4,13.1c4.4,7.1,4.6,15.3,4.6,15.3c0-0.1,0-0.2,0-0.2
                     L134.6,669.1L134.6,669.1z"></path>
                  <path fill="#FFFFFF" d="M338.4,669.1c0-1.5-0.2-15.9-8.5-30c-5-8.7-12-15.5-20.7-20.4c-10.2-5.9-22.6-8.8-36.7-8.8
                     s-26.5,3-36.6,8.8c-8.7,4.9-15.5,11.8-20.6,20.4c-8.2,14-8.4,27.7-8.4,29.3v67c0,1.5,0.2,15,8.5,28.8c7.8,12.9,24,28.2,57.1,28.2
                     c33.3,0,49.5-15.4,57.4-28.5c8.3-13.7,8.5-27.4,8.5-29v-39.3H323l0,0h-60l7.3,27.7h37.2v11.5c0,0.6-0.4,7.6-4.6,14
                     c-5.5,8.5-15.7,12.7-30.6,12.7c-14.6,0-24.8-4.2-30.3-12.5c-4.1-6.4-4.5-13.2-4.5-13.8v-66.7c0-0.6,0.4-8,4.6-14.7
                     c5.5-8.8,15.4-13.1,30.2-13.1c14.9,0,24.8,4.3,30.4,13.1c4.4,7.1,4.6,15.3,4.6,15.3c0-0.1,0-0.2,0-0.2L338.4,669.1L338.4,669.1z"></path>
                  <rect x="155.2" y="613.4" fill="#FFFFFF" width="30.8" height="175.4"></rect>
                  <path fill="#FFFFFF" d="M433.2,613.4l-27,80.1l-29.9-80.1h-32.8L390.3,739c-2.7,6.2-5.6,12-8.5,15.7c-3.2,3-5.9,3.3-18.9,3.2
                     c-1.7,0-3.4,0-5.2,0v30.9c1.7,0,3.4,0,5,0c1.4,0,2.8,0,4.2,0c13.1,0,25.4-1,37.2-12.8c0.4-0.4,0.7-0.7,1-1.1
                     c12-14.7,20.6-42.3,21.8-46.7l38.6-114.7h-32.5V613.4z"></path>
                  <path fill="#FFFFFF" d="M463.1,788.8l13.8-37.5h65.8l13.8,37.5h32.8l-13.8-37.5H615l-7.3-27.7h-42.5l-40.7-110.1h-29.8l-64.7,175.4
                     h32.9V788.8z M509.8,662l22.7,61.5h-45.4L509.8,662z"></path>
               </g>
            </svg>
         </div>
      </div>
      <div class="row">
         <div class="col-md-8 col-md-offset-2">
            <div class="form-group">
               <label>Hashing Algorithm</label>
               <select class="form-control" id="selectAlgorithms">
                  <option value="">Select...</option>
                  <?php
                  foreach ($algorithms as $key => $value) {
                     $conf = $value->getConfig();
                     $requiresSalt = !empty($conf["requiresSalt"]) ? 'true' : 'false';
                     $requiresURL = !empty($conf["requiresURL"]) ? 'true' : 'false';
                     echo '<option value="'.get_class($value).'" data-url="'.$requiresURL.'" data-salt="'.$requiresSalt.'">'.$key.'</option>';
                  } 
                  ?>
               </select>
            </div>
            <div class="form-group">
               <label>Plain Text Password</label>
               <div class="input-group">
                  <div class="input-group-addon"><strong class="algorithmText"></strong> (</div>
                  <input id="plainPass" type="text" class="form-control" placeholder="Test123">
                  <div class="input-group-addon">)</div>
               </div>
            </div>
            <div class="form-group">
               <label>Hashed Password</label>
               <input type="text" class="form-control" id="hashedPassword">
            </div>
            <div id="hexError" class="alert alert-warning collapse" role="alert"><strong>Base64 hash required.</strong> It is a requirement to use a base64 version of the hash instead of hex as Gigya Imports can only handle base64 passwords. Password's can be converted during the import process by using a <a href="">transformation script</a>.</div>
            <div class="form-group">
               <label>Salt</label>
               <input id="salt" type="text" class="form-control">
            </div>
            <div class="form-group">
               <label>Password Format</label>
               <input id="passwordFormat" type="text" class="form-control" value="$password$salt">
            </div>
            <div class="form-group">
               <label>Hashing Rounds</label>
               <input id="hashRounds" type="number" class="form-control" value="1">
            </div>
            <div id="customURLContainer" class="form-group collapse">
               <label>URL Endpoint</label>
               <input id="customURL" type="url" class="form-control" placeholder="https://">
            </div>
         </div>

         </div>
         <div class="row">
         <div class="col-md-offset-8 col-md-4">
         <button type="button" class="btn btn-success" id="btnValidate">Validate Password</button>
         </div>
         </div>

      </div>
   </body>
</html>