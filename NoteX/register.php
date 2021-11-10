<?php

include 'config.php';

error_reporting(0);

session_start();

if (isset($_SESSION['username'])) {
    header("Location: index.php");
}

if (isset($_POST['submit'])) {

	$username = $_POST['username'];
	$email = $_POST['email'];
	$password = md5($_POST['password']);
	$cpassword = md5($_POST['cpassword']);

	if ($password == $cpassword) {

		$sql = "SELECT * FROM users WHERE email='$email'";
		$result = mysqli_query($conn, $sql);

		if (!$result->num_rows > 0) {

			$sql = "INSERT INTO users (username, email, password)
					VALUES ('$username', '$email', '$password')";
			$result = mysqli_query($conn, $sql);

			if ($result) {

				echo "<script>alert('You have been successfully registered')</script>";
				$username = "";
				$email = "";
				$_POST['password'] = "";
				$_POST['cpassword'] = "";
			}

      else {
				echo "<script>alert('Error something went wrong')</script>";
			}
		}

    else {
			echo "<script>alert('Email already exists')</script>";
		}

	}

  else {
		echo "<script>alert('Passwords do not match')</script>";
	}
}

?>

<!DOCTYPE html>
<html>

<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="shortcut icon" type="image/png" href="favicon.png">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

	<link rel="stylesheet" type="text/css" href="style.css">

	<title>NoteX Sign Up</title>

</head>

<body>

  <h1>Note<span class="x_color">X</span></h1>


	<div class="container">

		<form action="" method="POST" class="login-email">

            <p class="login-text" style="font-size: 2rem; font-weight: 800;">Sign Up</p>

			<div class="input-group">
				<input type="text" placeholder="Username" name="username" value="<?php echo $username; ?>" required>
			</div>

			<div class="input-group">
				<input type="email" placeholder="Email" name="email" value="<?php echo $email; ?>" required>
			</div>

      <div class="input-group">
        <div class="pw-meter">
          <div class="form-element">
            <input type="password" id="password" placeholder="Password" name="password" value="<?php echo $_POST['password']; ?>" required>
            <div class="pw-display-toggle-btn">
              <i style='visibility:hidden;' class="fa fa-eye"></i>
              <i style='visibility:hidden;' class="fa fa-eye-slash"></i>
            </div>
            <div class="pw-strength">
              <span>Weak</span>
              <span></span>
            </div>
          </div>
        </div>
      </div>

      <div class="input-group">
				<input style="margin-top:30px;" type="password" placeholder="Confirm Password" name="cpassword" value="<?php echo $_POST['cpassword']; ?>" required>
			</div>

			<div class="input-group">
				<button style="margin-top:50px;" name="submit" class="btn">Sign Up</button>
			</div>

			<p style="margin-top:30px;" class="login-register-text">Already have an account? <a href="index.php">Sign In Here</a></p>

		</form>

	</div>


<script>
  function getPasswordStrength(password){
  let s = 0;
  if(password.length > 6){
    s++;
  }
  if(password.length > 10){
    s++;
  }
  if(/[A-Z]/.test(password)){
    s++;
  }
  if(/[0-9]/.test(password)){
    s++;
  }
  if(/[^A-Za-z0-9]/.test(password)){
    s++;
  }
  return s;
}
document.querySelector(".pw-meter #password").addEventListener("focus",function(){
  document.querySelector(".pw-meter .pw-strength").style.display = "block";
});
document.querySelector(".pw-meter .pw-display-toggle-btn").addEventListener("click",function(){
  let el = document.querySelector(".pw-meter .pw-display-toggle-btn");
  if(el.classList.contains("active")){
    document.querySelector(".pw-meter #password").setAttribute("type","password");
    el.classList.remove("active");
  } else {
    document.querySelector(".pw-meter #password").setAttribute("type","text");
    el.classList.add("active");
  }
});

document.querySelector(".pw-meter #password").addEventListener("keyup",function(e){
  let password = e.target.value;
  let strength = getPasswordStrength(password);
  let passwordStrengthSpans = document.querySelectorAll(".pw-meter .pw-strength span");
  strength = Math.max(strength,1);
  passwordStrengthSpans[1].style.width = strength*20 + "%";
  if(strength < 2){
    passwordStrengthSpans[0].innerText = "Weak";
    passwordStrengthSpans[0].style.color = "#111";
    passwordStrengthSpans[1].style.background = "#d13636";
  } else if(strength >= 2 && strength <= 4){
    passwordStrengthSpans[0].innerText = "Medium";
    passwordStrengthSpans[0].style.color = "#111";
    passwordStrengthSpans[1].style.background = "#e6da44";
  } else {
    passwordStrengthSpans[0].innerText = "Strong";
    passwordStrengthSpans[0].style.color = "#fff";
    passwordStrengthSpans[1].style.background = "#20a820";
  }
});
</script>

</body>
</html>
