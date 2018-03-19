<!doctype php>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../../../favicon.ico">

    <title>My Website</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- Custom styles for this template -->
    <!-- Custom styles for this template -->
    <link href="css\custom.css" rel="stylesheet">
  </head>
  
  <body>
    <p id="ajaxContent"></p>
    <?php include($_SERVER['DOCUMENT_ROOT'] . "/appShell/header.html"); ?>
    <?php include($_SERVER['DOCUMENT_ROOT'] . "/appShell/home.html"); ?>
    <?php include($_SERVER['DOCUMENT_ROOT'] . "/appShell/about.html"); ?>
    <?php include($_SERVER['DOCUMENT_ROOT'] . "/appShell/contact.html"); ?>
    <?php include($_SERVER['DOCUMENT_ROOT'] . "/appShell/signup.html"); ?>
    <?php include($_SERVER['DOCUMENT_ROOT'] . "/appShell/manage.html"); ?>
    <?php include($_SERVER['DOCUMENT_ROOT'] . "/appShell/login.html"); ?>
    <?php include($_SERVER['DOCUMENT_ROOT'] . "/appShell/footer.html"); ?>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="js\appshell.js"></script>
    
    <script src="js\jquery-cookie-master\src\jquery.cookie.js"></script>
    <script> //jquery
		$(document).ready(function() {
		    $('main').eq(0).show(); //take all home index 0 show it
		    $('.navbar-nav').on('click', 'a', function() {
		        $($(this).attr('href')).show().siblings('main:visible').hide(); // this what was clicked on # id of something and show it and then lets get all the siblings and hide them
		    });
    });

</script>
</body>
</html>
