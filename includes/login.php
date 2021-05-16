<?php
 
if ($_SERVER['REQUEST_METHOD'] == "GET" && realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
  header('Location: ../index.php');
}
  if(isset($_POST['login']) && !empty($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if(!empty($email) or !empty($password)) {
      $email = $getFromU->checkInput($email);
      $password = $getFromU->checkInput($password);

      if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errorMsg = "Invalid format";
      }else {
        if($getFromU->login($email, $password) === false){
          $errorMsg = "The email or password is incorrect!";
        }
      }
    }else {
      $errorMsg = "Please enter username and password!";
    }
  }
?>

<div class="form-container sign-in-container">
<form method="post">
  <h1>Connexion</h1>
    <input type="text" name="email" placeholder="Email"/>
    <input type="password" name="password" placeholder="Mot de passe"/>
    <input type="submit" name="login" value="SE CONNECTER" style="width: 150px; border-radius: 20px; background:#50b7f5; color: #FFF; font-weight: bold;"/>
    <?php
      if(isset($errorMsg)){
        echo '<li class="error-li">
        <div class="span-fp-error">'.$errorMsg.'</div>
        </li>';
      }
    ?>
	</ul>

	</form>
</div>