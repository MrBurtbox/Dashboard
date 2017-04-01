<?php 
require('loginFunctions.php');

if(!isset($fetchedUsername)){
	header('Location: Welcome.php');
	die('Unallowed Return...');
}

if(isset($_POST['postContent']) && isset($fetchedUsername)){
	
	$postContent = strip_tags($_POST['postContent']);
	
	
	$conn = connDatabase($username = "root", $password = "", $database = "user", $ipaddress = "");	
	$insertPost = "INSERT INTO content (contentPost, username) VALUES ('".$postContent."', '".$fetchedUsername."')";
	if ($conn->query($insertPost) === TRUE){
		echo '<script>console.log("posted");</script>';
		mysql_close($conn);
		header('Location: /');
	}
}
?>
<html>
<head>
	<title>Home</title>
	<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.1/css/materialize.min.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<?php getMetadata($description = "Page which is me", $keywords = "MrBurtbox, Home, Burt, Burtbox", $author = "MrBurtbox", $robots = "index, nofollow");?>
</head>
<body>
<form action="/" method="get"> 
	<nav>
		<div class="nav-wrapper grey">
		  <form>
			<div class="input-field">
			  <input id="search" name="" type="search" required placeholder="Looking for anything?">
			  <label class="label-icon" for="search"><i class="material-icons">search</i></label>
			  <i class="material-icons">close</i>
			</div>
		  </form>
		</div>
	</nav>	
</form>

<div class="container">
	<div class="row">
		<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
			<div class="card col s12">
				<div class="card-content">
						<div class="input-field col s12">
						  <i class="material-icons prefix">mode_edit</i>
						  <textarea id="icon_prefix2" class="materialize-textarea" name="postContent"></textarea>
						  <label for="icon_prefix2">Whats on your mind?</label>
						</div>
					<button class="btn waves-effect waves-light" type="submit" name="action">post
						<i class="material-icons right">send</i>
					</button>						
				</div>
				<div class="card-tabs">
				  <ul class="tabs tabs-fixed-width">
				  	<li class="tab"><a class="active" href="#notIntrested"><i class="material-icons">not_interested</i></a></li>
					<li class="tab"><a href="#image"><i class="material-icons">add_a_photo</i></a></li>
				  </ul>
				</div>
				<div class="card-content grey lighten-4">
					<div id="notIntrested"></div>
					<div id="image"></div>
			</div>
			</div>
		</form>			  
					 
		<?php
		$conn = connDatabase($username = "root", $password = "", $database = "user", $ipaddress = "");	
		$read = "SELECT contentPost, username FROM content ORDER BY id DESC";
		$result = $conn->query($read);
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				echo '
					<div class="col s12">
					  <div class="card">
						<div class="card-content">
						  <p>'.$row['contentPost'].'</p>
						</div>
						<div class="card-action">
						  <a href="#">'.$row['username'].'</a>
						</div>
					  </div>
					</div>
				
				';
			}
		} else {
			echo 'I went looking and didn\'t found anything...';
		}
		?>		
	</div>
</div>

<div id="Settings" class="modal modal-fixed-footer">
	<div class="modal-content">
	  <h4>Settings</h4>
	  <div class="row">

	  </div>
	</div>
	<div class="modal-footer">
		<a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Close</a>
		<a href="Logout" class="modal-action modal-close waves-effect waves-green btn-flat tooltipped" data-position="top" data-delay="50" data-tooltip="Bye then?">Logout</a>
	</div>
</div>	



<div class="fixed-action-btn horizontal click-to-toggle">
	<a class="btn-floating btn-large red">
	  <i class="material-icons">menu</i>
	</a>
	<ul>
		<li>
			<a class="btn-floating blue tooltipped modal-trigger" data-position="top" data-delay="50" data-tooltip="Settings" href="#Settings">
				<i class="material-icons">settings</i>
			</a>			
		</li>
	</ul>
</div>	

<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.1/js/materialize.min.js"></script>
<script>
$(document).ready(function(){
	$('.modal').modal();
});
</script>
</body>
</html>
