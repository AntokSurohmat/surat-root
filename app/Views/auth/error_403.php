<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

  <title>Forbidden</title>

  <!-- Google font -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:500" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Titillium+Web:700,900" rel="stylesheet">

  <!-- Custom stlylesheet -->
  <link type="text/css" rel="stylesheet" href="<?= base_url()?>/colorlib-error/css/style.css" />
  <!-- Admin LTE -->
 <!--  <link rel="stylesheet" href="<?= base_url('assets/AdminLTE-3.1.0-rc/')?>dist/css/adminlte.min.css"> -->

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

  </head>

  <body>

    <div id="notfound">
      <div class="notfound">
        <div class="notfound-404">
          <h1>403</h1>
        </div>
        <h2>Oops! You Dont Have Access.</h2>
        <p>You don't have permission to access this page</p>

        <a href="#" type="button" onclick="goBack();">Go Back</a>
        <a style="background: red;" href="<?= base_url()?>">Go To Homepage</a> 
      </div>
    </div>
    <script>
      function goBack() {
        window.history.back();
      }
    </script>
  </body><!-- This templates was made by Colorlib (https://colorlib.com) -->

  </html>
