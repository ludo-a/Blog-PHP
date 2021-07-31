<?php
session_start();
//Si Session ok = redirection
if(isset($_SESSION['connect'])){
    header('location: page_admin.php');
    exit();
}

require('./src/connexionBDD.php');

//verif. email & mot de passe
if(!empty($_POST['email']) && !empty($_POST['password'])){

	// VARIABLES
	$email 		= htmlspecialchars($_POST['email']);
	$password 	= htmlspecialchars($_POST['password']);
	$error		= 1;

	//VERIFICATION USER DANS BDD
	$req = $bdd->prepare('SELECT * FROM admin_table WHERE email = ?');
	$req->execute(array($email));

	while($admin = $req->fetch()){

		if($password == $admin['password']){
			$error = 0;
			$_SESSION['connect'] = 1;
			$_SESSION['userlogged']	 = $user['email'];

			header('location: page_admin.php?success=1');
			exit();
		}
	}

	if($error == 1){
		header('location: page_admin_connection.php?error=1');
		exit();
	}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./src/style.css">
    <title>Connexion Blog</title>
</head>
<body>
<?php include("menu.php") ?>
    <div class="textDesc">
		<h3>Log In:</h3>
	 	
		<?php
			if(isset($_GET['error'])){
				echo'<p id="error">Nous ne pouvons pas vous authentifier.</p>';
			}
		?>

	 	<div id="form">
			<form method="POST" action="page_admin_connection.php">
				<table>
					<tr>
						<td>Email</td>
						<td><input type="email" name="email" placeholder="Ex : example@google.com" required></td>
					</tr>
					<tr>
						<td>Mot de passe</td>
						<td><input type="password" name="password" placeholder="Ex : ********" required ></td>
					</tr>
				</table>
				<div id="button">
					<button type='submit'>Connexion</button>
				</div>
			</form>
			<h3>Voici le log pour vous identifier et vous connecter :</h3>
			<p>
				Email: adminblog@test </br>
				Mot de passe: admin153Test? 
			</p>
		</div>
	</div>
</body>
</html>