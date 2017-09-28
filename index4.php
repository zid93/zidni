<?php
session_start();
/* DECLARE VARIABLES */
$username = 'username';
$password = 'password';
$random1 = 'secret_key1';
$random2 = 'secret_key2';
$hash = md5($random1 . $password . $random2);
$self = $_SERVER['REQUEST_URI'];
/* USER LOGOUT */
if(isset($_GET['logout']))
{
	unset($_SESSION['login']);
}
/* USER IS LOGGED IN */
if (isset($_SESSION['login']) && $_SESSION['login'] == $hash)
{
	logged_in_msg($username);
}
/* FORM HAS BEEN SUBMITTED */
else if (isset($_POST['submit']))
{
	if ($_POST['username'] == $username && $_POST['password'] == $password)
	{
		//IF USERNAME AND PASSWORD ARE CORRECT SET THE LOGIN SESSION
		$_SESSION["login"] = $hash;
		header("Location: $_SERVER[PHP_SELF]");
	}
	else
	{
		// DISPLAY FORM WITH ERROR
		display_login_form();
		display_error_msg();
	}
}
/* SHOW THE LOGIN FORM */
else
{
	display_login_form();
}
/* TEMPLATES */
function display_login_form()
{
	// echo '<form action="' . isset($self) . '" method="post">' .
	// 		 '<label for="username">username</label>' .
	// 		 '<input type="text" name="username" id="username">' .
	// 		 '<label for="password">password</label>' .
	// 		 '<input type="password" name="password" id="password">' .
	// 		 '<input type="submit" name="submit" value="submit">' .
	// 	 '</form>';

	echo '<html>'.
    '<head>'.
        '<meta charset="utf-8">'.
        '<title>Login</title>'.
        '<link rel="stylesheet" href="styles.css" media="screen" title="no title" charset="utf-8">'.
    '</head>'.
    '<body>'.
        '<div class="login-page">'.
          '<div class="form">'.
            '<form action="' . isset($self) . '" method="post">'.
              '<input type="username" name="username" placeholder="username" required/>'.
              '<input type="password" name="password" placeholder="password" required/>'.
              '<button type="submit" name="kirim">login</button>'.
              // <p class="message">Not registered? <a href="register.php">Create an account</a></p>
            '</form>'.
          '</div>'.
        '</div>'.
    '</body>'.
	'</html>';
}
function logged_in_msg($username)
{
	echo '<p>Hello ' . $username . ', you have successfully logged in!</p>' .
		 '<a href="?logout=true">Logout?</a>';
}
function display_error_msg()
{
	echo '<p>Username or password is invalid</p>';
}
?>