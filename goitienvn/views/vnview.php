<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Vietnam Agent</title>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery-ui.js"></script>
<script src="js/vietnam.js"></script>
<style>
body {
	font: normal 11px Verdana, Arial, Helvetica, sans-serif;
	background-color: #69230C;
}
td, textarea, input {
	font: normal 11px Verdana, Arial, Helvetica, sans-serif;
}
.toppane {
	height: 80px;
	width: 100%;
}
.mainpane {
	margin: auto;
	height: 400px;
	width: 100%;
	background: #fff;
	border-top: solid 1px #999999;
	border-bottom: solid 1px #999999;
	overflow:auto;
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
	position: absolute;
	top: 73px;
	left: 30px;
	color: #FFFFFF;
	font: bold 12px Georgia, "Times New Roman", Times, serif;
}
.topleftitem {
	cursor: hand;
	cursor: pointer;
	float: left;
	padding: 0px 10px 0px 0px;
	text-transform: uppercase;
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
.leftinfo {
	position: absolute;
	top: 100px;
	right: 20px;
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
a {
	text-decoration:none;
	color:white;
}
a:hover {
	color:red;
}
</style>
</head>
<body>
<input type="hidden" id="selected_transactionid" value="0">
<input type="hidden" id="selected_transaction_co_no" value="0">
<div class="toppane">
  <div class="topleft">
    <div class="topleftitem" id="vnview_mophieu">Mỡ Phiếu</div>
    <div class="topleftitem">|</div>
    <div class="topleftitem" id="vnview_dongphieu">Đóng Phiếu</div>
    <div class="topleftitem">|</div>
    <div class="topleftitem" id="vnview_doiphieu">Thay đổi Phiếu</div>
    <div class="topleftitem">|</div>
    <div class="topleftitem" id="vnview_thanhtoan">Thanh Toán</div>
    <div class="floatnone">&nbsp;</div>
  </div>
  <div class="topright">
    <div class="toprightitem"><a href="index.php?logout">logout</a></div>
    <div class="toprightitem">info</div>
    <div class="floatnone">&nbsp;</div>
  </div>
</div>
<div class="leftinfo" id="leftinfo"> Welcome back
  <label style="font-weight:bold;text-transform:uppercase;" ><?php echo $_SESSION['user_name'];?></label>
</div>
<div class="mainpane" id="mainpane"> </div>
<div class="bottomright">
  <div class="bottomrightitem">&copy;&nbsp;2015 </div>
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
<div id="dialog_guiphieu" title="gui"></div>
<div id="dialog_dongphieu" title="dong">
  <style>
.dongphieu_detail{
	border:solid 1px #ccc;
}
</style>
  <table width="100%" border="0" cellspacing="2" cellpadding="1">
    <tr>
      <td colspan="2" valign="top"><div class="dongphieu_detail" id="dongphieu_detail"></div></td>
    </tr>
    <tr>
      <td  valign="top"><div>notes</div><div><textarea name="" cols="20" rows="5"></textarea></div></td>
      <td  valign="top"><div>Attached file</div><div><input name="" type="file"></div></td>
    </tr>
  </table>
</div>
</body>
</html>
