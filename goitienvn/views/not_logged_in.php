<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="REFRESH" content="1800" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
<title>Tyger Chuyen Tien</title>
<link rel="shortcut icon" href="/images/TygerXs.ico">

<style>
body {
	font: normal 11px Verdana, Arial, Helvetica, sans-serif;
	background-color: #3A4061;
}

.toppane {
	height: 80px;
	width: 100%;
}

.mainpane {
	margin: auto;
	height: 350px;
	width: 100%;
	background: #fff;
	border-top: solid 1px #999999;
	border-bottom: solid 1px #999999;
}

.topright {
	position: absolute;
	top: 73px;
	right: 30px;
	color: #FFFFFF;
	font: bold 10px Georgia, "Times New Roman", Times, serif;
}

.toprightitem {
	cursor: hand;
	cursor: pointer;
	float: left;
	padding: 0px 10px 0px 0px;
	text-transform: uppercase;
}

.topleft {
	
}

.bottomright {
	position: absolute;
	top: 440px;
	right: 30px;
	color: #FFFFFF;
	font: bold 10px Verdana, Arial, Helvetica, sans-serif;
}

.bottomleft {
	
}

.floatnone {
	float: none;
}

.contactpane {
	position: absolute;
	top: 100px;
	right: 30px;
	width: none;
	height: none;
	border: solid 1px #ccc;
	padding: 8px;
	z-index: 10;
	background-color: #f4f4f4;
	box-shadow: 1px 1px 5px #888888;
}

img {
	width: 100%:
}

#exampleSlider {
	margin-left: 25%;
	max-height: 250px;
	overflow: hidden;
	list-style: none;
	padding: 0;
}

.loginpane {
	margin: 50px auto;
	width:300px;
}

.errorpane {
	position: absolute;
	top: 10px;
	left: 10px;
	width: 200px;
	color: #f1f1f1;
}
a.tygerlink {text-decoration: none;}
</style>
</head>
<body>
	<div class="toppane">
		<div class="topright">
			<div class="toprightitem">log in</div>
			<div class="toprightitem">contact</div>
			<div class="floatnone">&nbsp;</div>
		</div>
	</div>
	<div class="contactpane">
		 Google Maps
	</div>
	<div class="mainpane">
		<div class="loginpane">
			<form method="post" action="index.php" name="loginform">
				<table width="400" border="0">
					<tr>
						<td><label for="login_input_username">Username</label></td>
						<td><input id="login_input_username" class="login_input"
							type="text" name="user_name" required /></td>
					</tr>
					<tr>
						<td><label for="login_input_password">Password</label></td>
						<td><input id="login_input_password" class="login_input"
							type="password" name="user_password" autocomplete="off" required /></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td><input type="submit" name="login" value="Log in" /></td>
					</tr>
				</table>
		
		</div>
	</div>
	<div class="bottomright">
		<div class="bottomrightitem"><a href="www.guitienvn.com/tyger" class="tygerlink">Tyger Chuyen Tien</a> &copy;&nbsp;2016</div>
	</div>
	<div class="errorpane">
<?php
// show potential errors / feedback (from login object)
if (isset($login)) {
    if ($login->errors) {
        foreach ($login->errors as $error) {
            echo $error;
        }
    }
    if ($login->messages) {
        foreach ($login->messages as $message) {
            echo $message;
        }
    }
}
?>
</div>
</body>
</html>




