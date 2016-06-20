<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Admin</title>

<link rel="stylesheet"	href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<link rel="stylesheet" href="libraries/jquery-ui.css">
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery-ui.js"></script>
<script src="js/admin.js"></script>
<style>
body {
	font: normal 11px Verdana, Arial, Helvetica, sans-serif;
	background-color: #666666;
}

.toppane {
	height: 80px;
	width: 100%;
}

.maincontent {
	margin: -25px auto;
	height: auto;
	width: 100%;
	background: #fff;
	border-top: solid 1px #999999;
	border-bottom: solid 1px #999999;
	overflow: auto;
}

.topright {
	position: absolute;
	top: 50px;
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
	top: 50px;
	left: 30px;
	color: #FFFFFF;
	font: bold 10px Georgia, "Times New Roman", Times, serif;
}

.topleftitem {
	cursor: hand;
	cursor: pointer;
	float: left;
	padding: 0px 10px 0px 0px;
	text-transform: uppercase;
}

.bottomleft {
	position: absolute;
	bottom: 20px;
	left: 20px;
	color: #FFFFFF;
	font: bold 10px Verdana, Arial, Helvetica, sans-serif;
}

.floatnone {
	float: none;
}

.leftinfo {
	position: absolute;
	top: 10px;
	left: 10px;
	width: none;
	height: none;
	border: solid 1px #ccc;
	padding: 8px;
	z-index: 10;
	background-color: #f4f4f4;
	box-shadow: 1px 1px 5px #000;
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
	width: 300px;
}

.errorpane {
	position: absolute;
	top: 5px;
	left: 5px;
	width: 200px;
	color: #f1f1f1;
}

a {
	text-decoration: none;
	color: white;
}

a:hover {
	color: red;
}

.logpanel {
	font: normal 10px verdana;
	position: absolute;
	right: 10px;
	bottom: 10px;
	width: 400px;
	height: 100px;
	border: solid 1px #ccc;
	padding: 4px;
	overflow: auto;
	background-color: #f4f4f4;
	box-shadow: 1px 1px 5px #000;
}

.activesession {
	position: absolute;
	right: 10px;
	top: 10px;
	font-size: 10px;
}

input,text,td,tr,select,textarea {
	font: normal 11px Verdana, Arial, Helvetica, sans-serif;
}

td,tr {
	vertical-align: top;
	padding: 2px 0px 2px 2px;
}

.inputboxsmall {
	font: normal 11px Verdana, Arial, Helvetica, sans-serif;
	padding: 1px 0px 1px 1px;
	border: none;
	border: solid 1px #ccc;
	width: 60px;
}

._h {
	text-transform: uppercase;
	font-weight: bold;
	padding: 4px 0px 3px 5px;
	border-bottom: solid 1px #ccc;
	color: #009900
}

._hfrm {
	font-weight: bold;
	background: #f1f1f1;
	padding: 5px 4px 3px 10px;
	border-bottom: solid 1px #ccc;
}

tr,td,select {
	font: normal 11px Verdana, Arial, Helvetica, sans-serif;
}

.i {
	font: normal 11px Verdana, Arial, Helvetica, sans-serif;
	padding: 1px;
	width: 150px;
}

.toupper {
	font: normal 11px Verdana, Arial, Helvetica, sans-serif;
	padding: 1px;
	width: 150px;
	text-transform: uppercase;
}

.is {
	font: normal 11px Verdana, Arial, Helvetica, sans-serif;
	padding: 1px;
	width: 148px;
	border: solid 2px #990000;
}

.ifile {
	font: normal 11px Verdana, Arial, Helvetica, sans-serif;
	padding: 1px;
	width: 200px;
}

td {
	padding: 1px 0px 1px 0px;
}

.h {
	padding: 0px 4px 0px 5px;
	background-color: #CCCCCC;
	border-bottom: solid 1px #666666;
}

.buttonbox {
	padding: 2px 0px 2px 0px;
}

._button {
	width: 80px;
	font: normal 11px Verdana, Arial, Helvetica, sans-serif;
}

._s {
	width: 154px;
}

._ssmall {
	width: 60px;
}

.row {
	cursor: hand;
	cursor: pointer;
}

.entered {
	color: #990000;
	background-color: #f1f1f1;
}

.selected {
	color: #fff;
	background-color: #3A4061;
}

.mainright {
	border-left: solid 1px #ccc;
	height: 400px;
	padding: 3px;
	overflow: auto;
}

.topright_dailytransaction {
	position: absolute;
	top: 15px;
	right: 20px;
	color: #FFFFFF;
	text-transform: uppercase;
	font: bold 10px Georgia, "Times New Roman", Times, serif;
	box-shadow: 1px 1px 5px #000;
	padding: 2px 10px 2px 10px;
}

.datebox {
	width: 70px;
	cursor: hand;
	cursor: pointer;
	font: normal 10px verdana;
}
.divider{
	border_bottom:solid #ccc 1px;
	height:10px;
}
</style>

</head>
<body>
	<div class="topright_dailytransaction">
		From: <input class="datebox" type="text"	id="transaction_fromdatepicker" name="transaction_fromdatepicker"
				value="<?php $d=strtotime("-10 days"); echo date("m/d/Y", $d) ?>"></input>
		To: <input class="datebox" type="text" id="transaction_todatepicker" name="transaction_todatepicker"
				value="<?php $d=strtotime("tomorrow"); echo date("m/d/Y", $d) ?>"></input> <select
			style="font: normal 11px Verdana, Arial, Helvetica, sans-serif; padding: 1px;"
			id="report_showtype" name="report_showtype" style="padding:3px;">
			<option value="3">Process Status</option>
			<option value="4">Received Status</option>
			<option value="0">All Status</option>
			<option value="1">New Status</option>
			<option value="2">Approved Status</option>
			<option value="5">Completed Status</option>
			<option value="6">Cancel Status</option>
		</select> <input type="button" value="SHOW" id="fromtotransaction"> <input
			type="button" value="QUICK NEW" id="quicknewtransaction"> 
			<input type="button" value="CONFIRM" id="sendreport">
			
	
	</div>
	<div class="toppane">
		<div class="topright">
			<div class="toprightitem">|</div>
			<div class="toprightitem">
				<div id="report">REPORT</div>
			</div>
			<div class="toprightitem">|</div>
			<div class="toprightitem">
				<div id="register">REGISTER</div>
			</div>
			<div class="toprightitem">|</div>
			<div class="toprightitem">
				<a href="index.php?logout">logout</a>
			</div>
			<div class="floatnone">&nbsp;</div>
		</div>
		<div class="topleft">
			<div class="topleftitem" id="topmenulistagent">agent</div>
			<div class="topleftitem">|</div>
			<div class="topleftitem" id="topmenulistcustomer">customer</div>
			<div class="topleftitem">|</div>
			<div class="topleftitem" id="topmenulistreceiver">receiver</div>
			<div class="topleftitem">|</div>
			<div class="topleftitem" id="topmenulisttransaction">transaction</div>

			<div class="floatnone">&nbsp;</div>
		</div>
	</div>
	<div id="leftinfo" class="leftinfo">
		Welcome back <label
			style="font-weight: bold; text-transform: uppercase;"><?php echo $_SESSION['user_name'];?></label>
		<div id="leftinfotop"></div>
		<div id="leftinfosub"></div>
	</div>
	<div class="maincontent" id="maincontent">
		<table width="100%" border="0">
			<tr>
				<td width="700" valign="top">
					<table width="700" border="0" cellspacing="2" cellpadding="0">
						<tr>
							<td width="50%" valign="top">
								<form id="customerfrm">
									<div class="h">customer</div>
									<input type="hidden" id="customerid" name="customerid" value="" />
									<table width="100%" border="0" cellspacing="1" cellpadding="2">
										<tr>
											<td width="80%" valign="top">
												<table width="100%" border="0" cellspacing="0"
													cellpadding="0">
													<tr>
														<td valign="top" nowrap>phone</td>
														<td><input class="is" type="text" name="cphone"
															id="cphone" value="" /></td>
													</tr>
													<tr>
														<td width="100" valign="top" nowrap>last name</td>
														<td><input class="toupper" type="text" name="clname"
															id="clname" value="" /></td>
													</tr>
													<tr>
														<td valign="top" nowrap>first name</td>
														<td nowrap><input class="toupper" type="text"
															name="cfname" id="cfname" value="" /></td>
													</tr>
													<tr>
														<td valign="top" nowrap>address</td>
														<td><input class="i" type="text" name="caddress"
															id="caddress" value="" /></td>
													</tr>
													<tr>
														<td valign="top" nowrap>city</td>
														<td><input class="toupper" type="text" name="ccity"
															id="ccity" value="" /></td>
													</tr>
													<tr>
														<td valign="top" nowrap>province</td>
														<td><select class="_s" id="cprovince" name="cprovince">
																<option value="qc">Quebec</option>
																<option value="on">Ontario</option>
																<option value="mb">Manitoba</option>
																<option value="sk">Saskatchewan</option>
																<option value="ab">Alberta</option>
																<option value="bc">British Columbia</option>
																<option value="nf">Newfoundland</option>
																<option value="pe">Prince Edward Island</option>
																<option value="nb">New Brunswick</option>
																<option value="ns">Nova Scotia</option>
																<option value="nt">Northwest Territories</option>
														</select></td>
													</tr>
													<tr>
														<td valign="top" nowrap>zip/postal</td>
														<td><input class="toupper" type="text" name="czip"
															id="czip" value="" /></td>
													</tr>

													<tr>
														<td valign="top" nowrap>email/2<sup>nd</sup> #
														</td>
														<td><input class="i" type="text" name="cemail" id="cemail"
															value="" /></td>
													</tr>
												</table>
											</td>
											<td width="20%" valign="top"><div class="buttonbox">
													<input type="button" class="_button" id="csearch"
														name="csearch" value="search"
														style="font-weight: bold; color: #990000;">
												
												</div>
												<div class="buttonbox">
													<input type="button" class="_button" id="cnew" name="cnew"
														value="new">
												
												</div>

												<div class="buttonbox">
													<input type="button" class="_button" id="cedit"
														name="cedit" value="edit">
												
												</div>
												<div class="buttonbox">
													<input type="button" class="_button" id="cdelete"
														name="cdelete" value="delete">
												
												</div>
												<div class="buttonbox">
													<input type="button" class="_button" id="cclear"
														name="cclear" value="clear">
												
												</div></td>
										</tr>
									</table>
								</form>
							</td>
							<td width="50%" valign="top"><div class="h">transaction</div>
								<form id="transactionfrm">
									<input type="hidden" id="transactionid" value="" />
									<table width="100%" border="0" cellspacing="1" cellpadding="2">
										<tr>
											<td width="90%" valign="top"><table width="100%" border="0"
													cellspacing="2" cellpadding="0">
													<tr>
														<td width="100" valign="top" nowrap>Co. number</td>
														<td><input class="is" type="text" name="trans_conumber"
															id="trans_conumber" value="" /></td>

														<td><input type="button" class="_button"
															id="trans_co_search" name="trans_co_search"
															value="search" style="font-weight: bold; color: #990000;"></td>
													</tr>
													<tr>
														<td valign="top" nowrap>local amount</td>
														<td><input class="i" type="text" name="localamount"
															id="localamount" value="" /></td>
														<td><select class="_ssmall" id="selectlocaltype"
															name="selectlocaltype">
																<option value="0">CAD</option>
																<option value="1">USD</option>
																<option value="2">VND</option>
														</select></td>
													</tr>
													<tr>
														<td valign="top" nowrap>delivery amount</td>
														<td nowrap><input class="i" type="text"
															name="deliveryamount" id="deliveryamount" value=""
															style="font-weight: bold;" disabled="disabled" /></td>
														<td><select class="_ssmall" id="selectdeliverytype"
															name="selectdeliverytype">
																<option value="0">CAD</option>
																<option value="1">USD</option>
																<option value="2">VND</option>
														</select></td>
													</tr>
													<tr>
														<td valign="top" nowrap>service & fee</td>
														<td><input class="i" type="text" name="fee" id="fee"
															value="" /></td>
														<td><span
															alt="under $1000.00 service charge as 1.5% plus $5,00. For over $1000.00, ID required and service charge as 2.00$ plus $5.00"></span></td>
													</tr>
													<tr>
														<td valign="top" nowrap>total amount</td>
														<td><input class="i" type="text" name="totalamount"
															id="totalamount" value=""
															style="font-weight: bold; color: #990000;"
															disabled="disabled" /></td>
														<td>&nbsp;</td>
													</tr>
													<tr>
														<td valign="top" nowrap>delivery method</td>
														<td><select class="_s" id="deliverymethod"
															name="deliverymethod">
																<option value="0">Home / T&#7841;i Nh&#224;</option>
																<option value="1">Pickup / T&#7841;i Qu&#7847;y</option>
																<option value="2">Transfer / Chuy&#7875;n Kho&#7843;n</option>
														</select></td>
														<td><input type="button" class="_button" id="trans_edit"
															name="trans_edit" value="Edit"
															style="font-weight: bold; color: #990000;"></td>
													</tr>
													<tr>
														<td valign="top" nowrap>note</td>
														<td><textarea style="width: 150px;" name="tnote"
																id="tnote" cols="0" rows="2"></textarea></td>
														<td>
															<div class="buttonbox">
																<input type="button" class="_button" id="tclear"
																	name="tclear" value="clear"></input>
															</div> <!-- <div class="buttonbox"><input type="button" class="_button" id="trans_submit" name="trans_submit" value="submit"></input> -->
															</div>
														</td>
													</tr>
												</table></td>
										</tr>
									</table>
								</form></td>
						</tr>
						<tr>
							<td width="50%" valign="top"><div class="h">receiver</div></td>
							<td width="50%" valign="top"><div class="h">admin</div></td>
						</tr>
						<tr>
							<td valign="top">
								<form id="receiverfrm">
									<input type="hidden" id="receiverid" value="" />
									<table width="100%" border="0" cellspacing="1" cellpadding="2">
										<tr>
											<td width="80%" valign="top"><table width="100%" border="0"
													cellspacing="0" cellpadding="0">
													<tr>
														<td valign="top" nowrap>phone</td>
														<td nowrap><input class="is" type="text" name="rphone"
															id="rphone" value="" /></td>
														<td>&nbsp;</td>
													</tr>
													<tr>
														<td width="100" valign="top" nowrap>last name</td>
														<td><input class="toupper" type="text" name="rlname"
															id="rlname" value="" /></td>
														<td>&nbsp;</td>
													</tr>
													<tr>
														<td valign="top" nowrap>first name</td>
														<td nowrap><input class="toupper" type="text"
															name="rfname" id="rfname" value="" /></td>
														<td>&nbsp;</td>
													</tr>
													<tr>
														<td valign="top" nowrap>address</br>diachi
														</td>
														<td><textarea style="width: 150px;" name="rdiachi"
																id="rdiachi" cols="" rows="5"></textarea></td>
														<td>&nbsp;</td>
													</tr>
													<tr>
														<td valign="top" nowrap>city/tp-tinh</td>
														<td><select class="_s" name="rtptinh" id="rtptinh">
																<option value="0" selected>Ch&#7885;n
																	t&#7881;nh/th&#224;nh</option>
																<option value="1">TP. H&#7891; Ch&#237; Minh</option>
																<option value="2">TP. H&#224; N&#7897;i</option>
																<option value="3">TP. &#272;&#224; N&#7859;ng</option>
																<option value="4">TP. Hu&#7871;</option>
																<option value="5">TP. H&#7843;i Ph&#242;ng</option>
																<option value="6">TP. Bi&#234;n Ho&#224;</option>
																<option value="7">TP. Nha Trang</option>
																<option value="8">TP. C&#7847;n Th&#417;</option>
																<option value="9">TP. C&#224; Mau</option>
																<option value="10">TP. H&#7841; Long</option>
																<option value="11">TP. Long Xuy&#234;n</option>
																<option value="12">TP. Nam &#272;&#7883;nh</option>
																<option value="13">TP. Quy Nh&#417;n</option>
																<option value="14">TP. R&#7841;ch Gi&#225;</option>
																<option value="15">TP. Phan Thi&#7871;t</option>
																<option value="16">TP. Th&#225;i Nguy&#234;n</option>
																<option value="17">TP. Vinh</option>
																<option value="18">TP. V&#361;ng T&#224;u</option>
																<option value="19">An Giang</option>
																<option value="20">B&#224; R&#7883;a - V&#361;ng
																	T&#224;u</option>
																<option value="21">B&#7855;c Giang</option>
																<option value="22">B&#7855;c K&#7841;n</option>
																<option value="23">B&#7841;c Li&#234;u</option>
																<option value="24">B&#7855;c Ninh</option>
																<option value="25">B&#7871;n Tre</option>
																<option value="26">B&#236;nh &#272;&#7883;nh</option>
																<option value="27">B&#236;nh D&#432;&#417;ng</option>
																<option value="28">B&#236;nh Ph&#432;&#7899;c</option>
																<option value="29">B&#236;nh Thu&#7853;n</option>
																<option value="30">Bu&#244;n Ma Thu&#7897;t</option>
																<option value="31">Cao B&#7857;ng</option>
																<option value="32">&#272;&#7855;c L&#7855;k</option>
																<option value="33">&#272;&#7855;c N&#244;ng</option>
																<option value="34">&#272;i&#7879;n Bi&#234;n</option>
																<option value="35">&#272;&#7891;ng Nai</option>
																<option value="36">&#272;&#7891;ng Th&#225;p</option>
																<option value="37">Gia Lai</option>
																<option value="38">H&#224; Giang</option>
																<option value="39">H&#224; Nam</option>
																<option value="40">H&#224; T&#297;nh</option>
																<option value="41">H&#7843;i D&#432;&#417;ng</option>
																<option value="42">H&#7853;u Giang</option>
																<option value="43">Ho&#224; B&#236;nh</option>
																<option value="44">H&#432;ng Y&#234;n</option>
																<option value="45">Kh&#225;nh Ho&#224;</option>
																<option value="46">Ki&#234;n Giang</option>
																<option value="47">Kon Tum</option>
																<option value="48">Lai Ch&#226;u</option>
																<option value="49">L&#226;m &#272;&#7891;ng</option>
																<option value="50">L&#7841;ng S&#417;n</option>
																<option value="51">L&#224;o Cai</option>
																<option value="52">Long An</option>
																<option value="53">Ngh&#7879; An</option>
																<option value="54">Ninh B&#236;nh</option>
																<option value="55">Ninh Thu&#7853;n</option>
																<option value="56">Ph&#250; Th&#7885;</option>
																<option value="57">Ph&#250; Y&#234;n</option>
																<option value="58">Qu&#7843;ng B&#236;nh</option>
																<option value="59">Qu&#7843;ng Nam</option>
																<option value="60">Qu&#7843;ng Ng&#227;i</option>
																<option value="61">Qu&#7843;ng Ninh</option>
																<option value="62">Qu&#7843;ng Tr&#7883;</option>
																<option value="63">S&#243;c Tr&#259;ng</option>
																<option value="64">S&#417;n La</option>
																<option value="65">T&#226;y Ninh</option>
																<option value="66">Th&#225;i B&#236;nh</option>
																<option value="67">Thanh Ho&#225;</option>
																<option value="68">Th&#7911; D&#7847;u M&#7897;t</option>
																<option value="69">Th&#7915;a Thi&#234;n Hu&#7871;</option>
																<option value="70">Ti&#7873;n Giang</option>
																<option value="71">Tr&#224; Vinh</option>
																<option value="72">Tuy&#234;n Quang</option>
																<option value="73">V&#297;nh Long</option>
																<option value="74">V&#297;nh Ph&#432;&#7899;c</option>
																<option value="75">Y&#234;n B&#225;i</option>
														</select></td>
														<td>&nbsp;</td>
													</tr>

													<tr>
														<td valign="top" nowrap>email/2<sup>nd</sup> #
														</td>
														<td nowrap><input class="i" type="text" name="remail"
															id="remail" value="" /></td>
														<td>&nbsp;</td>
													</tr>
												</table></td>
											<td width="20%" valign="top"><div class="buttonbox">
													<input type="button" class="_button" id="rsearch"
														name="rsearch" value="search"
														style="font-weight: bold; color: #990000;">
												
												</div>
												<div class="buttonbox">
													<input type="button" class="_button" id="rnew" name="rnew"
														value="new">
												
												</div>
												<div class="buttonbox">
													<input type="button" class="_button" id="redit"
														name="redit" value="edit">
												
												</div>
												<div class="buttonbox">
													<input type="button" class="_button" id="rdelete"
														name="rdelete" value="delete">
												
												</div>
												<div class="buttonbox">
													<input type="button" class="_button" id="rclear"
														name="rclear" value="clear">
												
												</div></td>
										</tr>
									</table>
								</form>
							</td>
							<td valign="top">
								<form id="adminfrm">
									<input type="hidden" id="adminid" value="" />
									<table width="100%" border="0" cellspacing="2" cellpadding="0">
										<tr>
											<td valign="top">status</td>
											<td><select class="_s" name="adstatus" id="adstatus">
													<option value="1">new</option>
													<option value="2">approved</option>
													<option value="3">process</option>
													<option value="4">received</option>
													<option value="5">completed</option>
													<option value="6">cancel</option>
											</select></td>
											<td>
												<!--  <input type="button" class="_button" id="adnew" name="adnew" value="new" style="font-weight:bold;color:#990000;">-->
											</td>
										</tr>
										<tr>
											<td valign="top" nowrap>confirmation by</td>
											<td><select class="_s" name="adconfirmationby"
												id="adconfirmationby">
													<option value="0">by email</option>
													<option value="1">by phone</option>
											</select></td>
											<td><input type="button" class="_button" id="adupdate"
												name="adupdate" value="update"></td>
										</tr>
										<tr>
											<td valign="top">note</td>
											<td><textarea style="width: 150px" name="adnote" id="adnote"
													cols="0" rows="2"></textarea></td>
											<td><input type="button" class="_button" id="adprint"
												name="adprint" value="print"></td>
										</tr>
										<tr>
											<td valign="top">attachment</td>
											<td><input class="ifile" type="file" name="adattachment"
												id="adattachment"></td>
											<td>
												<div class="buttonbox">
													<input type="button" class="_button" id="aclearfrm"
														name="aclearfrm" value="clear all">
												
												</div>
												<div class="buttonbox">
													<input type="button" class="_button" id="closelog"
														name="closelog" value="close log">
												
												</div>
											</td>
										</tr>

									</table>
								</form>
							</td>
						</tr>
					</table>
				</td>
				<td width="100%" valign="top">
					<div class="mainright" id="mainright"></div>
				</td>
			</tr>
		</table>



	</div>
	<div class="bottomleft">
		<div class="bottomleftitem">&copy;&nbsp;2015</div>
		<input type="hidden" id="agentid" name="agentid"
			value="<?php echo $_SESSION['user_id'];?>" />
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
	<style>
.reportside {
	padding: 2px;
}

.reportmain {
	padding-left: 5px;
	border-left: solid 1px #ccc;
}

.reportselect {
	width: 190px;
}

.reportselectdate {
	width: 184px;
	cursor: hand;
	cursor: pointer;
}

.reportbutton {
	width: 190px;
}

.reportagentinfo {
	border: solid 1px #f1f1f1;
	padding: 3px;
	width: 183px;
}
</style>
	<div id="dialog_adminreport" title="admin - REPORT">
		<div id="tabs">
			<ul>
				<li class="toptabs"><a href="#tabs-agent" id="tab-form">Agent</a></li>
				<li class="toptabs"><a href="#tabs-transaction" id="tab-transaction">Transaction</a></li>
				<li class="toptabs"><a href="#tabs-accounting" id="tab-report">Revenue TAX Report</a></li>
			</ul>
			<div id="tabs-agent">
				<table width="100%" border="0" cellspacing="2" cellpadding="2">
					<tr>
						<td width="200">
							<table>
								<tr>
									<td><select class="reportselect" id="reportagent_selectagent"
										name="reportagent_selectagent">
									</select></td>
								</tr>
								<tr>
									<td><input class="reportselectdate" type="text"
										id="reportagent_fromdatepicker"
										name="reportagent_fromdatepicker" value="<?php $d=strtotime("-10 days"); echo date("m/d/Y", $d) ?>"></input></td>
								</tr>
								<tr>
									<td><input class="reportselectdate" type="text"	id="reportagent_todatepicker" name="reportagent_todatepicker"
										value="<?php $d=strtotime("tomorrow"); echo date("m/d/Y", $d) ?>"></input></td>
								</tr>
								<tr>
									<td><select class="reportselect"
										id="reportagent_selecttransaction"
										name="reportagent_selecttransaction">
											<option value="0">show all transactions</option>
											<option value="1">new transactions</option>
											<option value="2">approved transactions</option>
											<option value="3">process transactions</option>
											<option value="4">received transactions</option>
											<option value="5">completed transactions</option>
											<option value="6">cancel transactions</option>
											
									</select></td>
								</tr>
								<tr>
									<td><select class="reportselect" id="reportagent_sortby"
										name="reportagent_sortby">
											<option value="0">sort by</option>
											<option value="1">status</option>
											<option value="2">date</option>
											<option value="3">amount</option>
											<option value="4">tp-tinh</option>
									</select></td>
								</tr>
								<tr>
									<td><input class="reportbutton" type="button"
										id="reportagent_buttonsubmit" value="show"</input></td>
								</tr>
								<tr>
									<td><input class="reportbutton" type="button"
										id="report_Agent_buttonExcel" value="Inv. Excel"</input></td>
								</tr>
								<tr>
									<td><div class="reportagentinfo">
											<div>
						<?php echo date("Y-m-d H:i:s");?></div>
											<div id="reportagentinfo_detail"></div>
											<div class="divider"></div>
											<div id="reportagentinfo_detail_sub"></div>
										</div></td>
								</tr>

							</table>
						</td>
						<td valign="top">
							<div id="reportagent_main" class="reportmain"></div>
						</td>
					</tr>

				</table>
			</div>
			<div id="tabs-transaction">
				<table width="100%" border="0" cellspacing="2" cellpadding="2">
					<tr>
						<td width="200" valign="top">
							<table>
								<tr>
									<td><input class="reportselectdate" type="text"
										id="reporttransaction_fromdatepicker"
										name="reporttransaction_fromdatepicker" 
										value="<?php $d=strtotime("-40 days"); echo date("m/d/Y", $d) ?>"></input></td>
								</tr>
								<tr>
									<td><input class="reportselectdate" type="text"	id="reporttransaction_todatepicker"	
									name="reporttransaction_todatepicker" 
									value="<?php $d=strtotime("tomorrow"); echo date("m/d/Y", $d) ?>"></input></td>
								</tr>
								<tr>
									<td><select class="reportselect"
										id="reporttransaction_selecttransaction"
										name="reporttransaction_selecttransaction">
											<option value="0">show all transactions</option>
											<option value="1">new transactions</option>
											<option value="2">approved transactions</option>
											<option value="3">process transactions</option>
											<option value="4">received transactions</option>
											<option value="5">completed transactions</option>
											<option value="6">cancel transactions</option>
									</select></td>
								</tr>
								<tr>
									<td><select class="reportselect" id="reporttransaction_sortby"
										name="reporttransaction_sortby">
											<option value="0">sort by</option>
											<option value="2">date</option>
											<option value="3">amount</option>
											<option value="4">tp-tinh</option>
									</select></td>
								</tr>
								<tr>
									<td><input class="reportbutton" type="button"
										id="reporttransaction_buttonsubmit" value="show"</input></td>
								</tr>
								<tr>
									<td><input class="reportbutton" type="button"
										id="reporttransaction_buttonprint" value="Excel"</input></td>

								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
							</table>
						</td>
						<td valign="top">
							<div class="reportmain" id="transactionmain"></div>
						</td>
					</tr>

				</table>
			</div>
			<div id="tabs-accounting">
			<table width="100%" border="0" cellspacing="2" cellpadding="2">
					<tr>
						<td width="200" valign="top">
							<table>
								<tr>
									<td><input class="reportselectdate" type="text"
										id="reportaccounting_fromdatepicker"
										name="reportaccounting_fromdatepicker" value="from date"></input></td>
								</tr>
								<tr>
									<td><input class="reportselectdate" type="text"
										id="reportaccounting_todatepicker"
										name="reportaccounting_todatepicker" value="to date"></input></td>
								</tr>
								<tr>
									<td><select class="reportselect"
										id="reportaccounting_selecttransaction"
										name="reportaccounting_selecttransaction">
											<option value="0">show all transactions</option>
											<option value="1">new transactions</option>
											<option value="2">approved transactions</option>
											<option value="3">process transactions</option>
											<option value="4">received transactions</option>
											<option value="5">completed transactions</option>
											<option value="6">cancel transactions</option>
											<option value="7">over $1000</option>
											<option value="8">over $3000</option>
									</select></td>
								</tr>
								<tr>
									<td><select class="reportselect" id="reportaccounting_sortby"
										name="reportaccounting_sortby">
											<option value="0">sort by</option>
											<option value="2">date</option>
											<option value="3">amount</option>
											<option value="4">tp-tinh</option>
									</select></td>
								</tr>
								<tr>
									<td><input class="reportbutton" type="button"
										id="reportaccounting_buttonsubmit" value="show"</input></td>
								</tr>
								<tr>
									<td><input class="reportbutton" type="button"
										id="reportaccounting_buttonprint" value="print"</input></td>

								</tr>
								<tr>
									<td><input class="reportbutton" type="button"
										id="reportaccounting_buttonexportexcel" value="Export Excel"></input></td>

								</tr>
								<tr>
									<td><div><?php echo date("Y-m-d H:i:s");?></div>
											<div class="divider"></div>
											<style>
								            .boldtxt{
								            	font:bold 12px verdana;
								            }
								            </style>
											<div class="boldtxt" id="reportaccounting_detail_sub"></div></td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
							</table>
						</td>
						<td valign="top">
							<div class="reportmain" id="accountingmain"></div>
						</td>
					</tr>

				</table></div>
		</div>
	</div>
	<div id="dialog_reportsendfrm" title="Send transactions"></div>
	<div id="dialog_confirm" title="confirmation info"></div>
	<div id="dialog_account" title="acount info">
		<form id="changeinfofrm">
			<input type="hidden" id="agentid" name="agentid" value="" />
			<table width="100%" border="0" cellspacing="3" cellpadding="1">
				<tr>
					<td>first name</td>
					<td><input type="text" required id="changeinfo_firstname"
						name="changeinfo_firstname" class="toupper" /></td>
				</tr>
				<tr>
					<td>last name</td>
					<td><input type="text" required id="changeinfo_lastname"
						name="changeinfo_lastname" class="toupper" /></td>
				</tr>
				<tr>
					<td>address</td>
					<td><input type="text" required id="changeinfo_address"
						name="changeinfo_address" class="i" /></td>
				</tr>
				<tr>
					<td>city</td>
					<td><input type="text" required id="changeinfo_city"
						name="changeinfo_city" class="toupper" /></td>
				</tr>
				<tr>
					<td>province</td>
					<td><input type="text" required id="changeinfo_province"
						name="changeinfo_province" class="toupper" /></td>
				</tr>
				<tr>
					<td>zip</td>
					<td><input type="text" required id="changeinfo_zip"
						name="changeinfo_zip" class="i" /></td>
				</tr>
				<tr>
					<td>phone</td>
					<td><input type="text" required id="changeinfo_phone"
						name="changeinfo_phone" class="i" /></td>
				</tr>
				<tr>
					<td>email</td>
					<td><input type="email" required id="changeinfo_email"
						name="changeinfo_email" class="i" /></td>
				</tr>
				<tr>
					<td>level</td>
					<td><select class="_s" id="changeinfo_level"
						name="changeinfo_level">
							<option value="0">select level</option>
							<option value="30">level 1 - 30%</option>
							<option value="35">level 2 - 35%</option>
							<option value="40">level 3 - 40%</option>
							<option value="45">level 4 - 45%</option>
							<option value="50">VIP - 50%</option>
					</select></td>
				</tr>
			</table>
		</form>
	</div>
	<div class="logpanel" id="logpanel">
		<div id="logstart"></div>
	</div>
</body>
</html>




