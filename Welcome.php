<?php
require('loginFunctions.php');
?>

<html>
<head>
<style>
@-webkit-keyframes autofill {
    to {
        color: #666;
        background: transparent;
    }
}

input:-webkit-autofill {
    -webkit-animation-name: autofill;
    -webkit-animation-fill-mode: both;
}

</style>
<title><?php if(isset($fetchedUsername)){echo $fetchedUsername;} ?></title>
<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.1/css/materialize.min.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<?php getMetadata($description = "Page which is me", $keywords = "MrBurtbox, Home, Burt, Burtbox", $author = "MrBurtbox", $robots = "index, nofollow");?>
</head>
<body>
<div class="parallax-container">
  <div class="parallax"><img src="background.jpg"></div>
</div>
<div class="container">
	<div class="row">
		<form action="loginFunctions.php" method="post">
			<div class="input-field col s12">
			  <input id="username" type="text" class="validate" name="username">
			  <label for="username">Username</label>
			</div>
			<div class="input-field col s12">
			  <input id="password" type="password" class="validate" name="password">
			  <label for="password">Password</label>
			</div>
			<button class="btn waves-effect waves-light" type="submit" name="action">Submit
				<i class="material-icons right">send</i>
			</button>
		</form>
	</div>
</div>
</body>
<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.1/js/materialize.min.js"></script>
<script>
$(document).ready(function(){
	$('.parallax').parallax();
});
</script>
</html>