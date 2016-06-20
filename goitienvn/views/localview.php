<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta http-equiv="REFRESH" content="1800" />
	<meta name="viewport"
		content="width=device-width, initial-scale=1.0, user-scalable=yes" />
	<title>Local Agent - &#272;&#7841;i L&#253;</title>
		<link rel="shortcut icon" href="/images/TygerXs.ico">
		<script src="js/jquery-1.11.1.min.js"></script>
		<script src="js/jquery-ui.js"></script>
		<script src="js/local.js"></script>
		<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
        <link rel="stylesheet" href="/resources/demos/style.css">


<style type="text/css">

body {
	font: normal 12px Verdana, Arial, Helvetica, sans-serif;
	background: #ccc;
	margin: 0;
	/*     it's good practice to zero the margin and padding of the body element to account for differing browser defaults */
	padding: 0;
	text-align: center;
	/* this centers the container in IE 5* browsers. The text is then set to the left aligned default in the #container selector */
	color: #000000;
}

.thrColEls #container {
	width: 880px;
	font: normal 14px Verdana, Arial, Helvetica, sans-serif;
	
	/* this width will create a container that will fit in an 800px browser window if text is left at browser default font sizes */
	background: #ffffff;
	margin: 0 auto;
	/* the auto margins (in conjunction with a width) center the page */
	border: 0px solid #000000;
	text-align: left;
	/* this overrides the text-align: center on the body element. */
	overflow: auto;
}

.thrColEls #mainpane {
	margin: 2px;
}

.thrColEls #secondpane {
	margin: 2px;
	display: block;
	overflow: auto;
}

.thrColEls #topmenu {
	width: 880px;
	margin: 0 auto;
	padding-top: 10px;
	padding-bottom: 5px;
	border-bottom: solid 1px #ccc;
	text-align: left;
	
}
/* Miscellaneous classes for reuse */
.fltrt {
	/* this class can be used to float an element right in your page. The floated element must precede the element it should be next to on the page. */
	float: right;
	margin-left: 8px;
}

.fltlft {
	/* this class can be used to float an element left in your page */
	float: left;
	margin-right: 8px;
}

.clearfloat {
	/* this class should be placed on a div or break element and should be the final element before the close of a container that should fully contain a float */
	clear: both;
	height: 0;
	font-size: 1px;
	line-height: 0px;
}

.inputtxtbox {
	font: normal 11px Verdana, Arial, Helvetica, sans-serif;
	width: 180px;
	border: solid 2px #ccc;
}

.inputbutton {
	font: normal 11px Verdana, Arial, Helvetica, sans-serif;
	width: 120px;
	text-align: center;
}

.bigbutton {
	font: bold 12px Verdana, Arial, Helvetica, sans-serif;
	width: 90px;
	text-align: center;
	height: 36px;
}

.searchbar {
	background: #fff;
	padding: 3px;
	border-bottom: solid 1px #000;
}

.infobar {
	height:12px;
	padding:0px;
	background-color: #CCCCCC;
	text-align: left;
	font:normal 10px Verdana, Arial, Helvetica, sans-serif;
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

tr,td,select,textarea {
	font: normal 12px Verdana, Arial, Helvetica, sans-serif;
	vertical-align: top;
	padding: 1px 0px 1px 2px;
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
	width: 150px;
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

.h, .htoggle {
	padding: 0px 4px 0px 5px;
	background-color: #CCCCCC;
	border-bottom: solid 1px #666666;
}

.buttonbox {
	padding: 2px 0px 2px 0px;
}

._button {
	width: 100px;
	font: bold 11px Verdana, Arial, Helvetica, sans-serif;
}

._s {
	width: 154px;
}

._ssmall {
	width: 60px;
}

.row, .row_c, .row_r {
	cursor: hand;
	cursor: pointer;
}

.entered {
	color: #990000;
	background-color: #f1f1f1;
}

.selected {
	color: #990000;
	/*color: #fff;
	background-color: #3A4061;
	color: #990000;
	background-color: #f1f1f1;*/
}
/* new ver 11 declaration */
.infopane {
	width: 400px;
	height: 250px;
	overflow: auto;
	box-shadow: 1px 1px 5px #888888;
	display: block;
	z-index: 10;
}

.toptabs {
	width:auto;
}
.htoggle{
	cursor: hand;
	cursor: pointer;
}
.ctoggle{
	/*display:block;*/
}
.ctoggle_hide{
	display:none;
}
.topdate{
	font:normal 10px verdana;
	padding:0px 0px 5px 5px;
}
.datebox{
	width:100px
}
table.banner {background-image: url(../images/Metal-Pattern30.jpg);
	background-repeat:repeat;}
table.txtbig { font: normal 14px Verdana, Arial, Helvetica, sans-serif;}
</style>
</head>
<body class="thrColEls">
	<div id="topmenu">
		<div class="searchbar">
			<table width="100%" border="0" cellspacing="0" cellpadding="2" class="banner">

				<tr>
				<td valign="baseline"><img src="views/logo.png" width="35" height="35" /></td>
					<td valign="baseline" width="100">Sender<br /> <input
						class="inputtxtbox" type="text" id="customersearch"
						name="customersearch" />
					</td>
					<td valign="baseline" width="100">Receiver<br /> <input
						class="inputtxtbox" type="text" id="receiversearch"
						name="receiversearch" />
					</td>
				<!---	<td valign="baseline" width="100">transaction Co.<br /> <input
						class="inputtxtbox" type="text" id="cosearch"
						name="cosearch" />
					</td>	---->
					<td valign="baseline" width="100"><input class="bigbutton"
						type="button" id="buttonsearch" name="buttonsearch"
						value="search" /></td>
					<td valign="baseline" width="100"><input class="bigbutton" type="button"
						id="logout" name="logout" onClick="location.href='index.php?logout'" value="logout" /></td>   
				</tr>
			</table>
		</div>
		<div class="infobar" id="infobar"></div>
	</div>
	<div id="container">
		<div id="tabs">
			<ul>
				<li class="toptabs"><a href="#tabs-forms" id="tab-form">New</a></li>
				<li class="toptabs"><a href="#tabs-transaction" id="tab-transaction">Transaction</a></li>
				<li class="toptabs"><a href="#tabs-report" id="tab-report">Report</a></li>
				<li class="toptabs"><a href="#tabs-training" id="tab-training">Training</a></li>
				<li class="toptabs"><a href="#tabs-customer" id="tab-customer">Sender</a></li>
				<li class="toptabs"><a href="#tabs-receiver" id="tab-receiver">Receiver</a></li>
				<li class="toptabs"><a href="#tabs-account" id="tab-account">Account</a></li>
				
			</ul>
			
			<div id="tabs-forms">
				<div id="mainpane">
					<table width="100%" border="0" cellspacing="1" cellpadding="1">
						<tr>
							<td valign="top" width="50%"><form id="customerfrm">
									<div class="htoggle" id="customer_toggle">Ng&#432;&#7901;i G&#7919;i - ! Kh&#244;ng c&#7847;n d&#7845;u:
													<span style="padding:3px;color:red;font:bold 11px Verdana, Arial, Helvetica, sans-serif;"> &#46; &#126; &#94; &#96; &#8217;</span></div>
                                    <div class="ctoggle" id="customerinfo"></div>									
									<input type="hidden" id="customerid" name="customerid" value="" />
									<table width="100%" border="0" cellspacing="0" cellpadding="2">
										<tr>
											<td width="80%" valign="top"><table width="100%" border="0"
													cellspacing="0" cellpadding="0">
													<tr>
														<td valign="top" nowrap>Phone</td>
														<td><input class="i" type="text" name="cphone"
															id="cphone" value="" /></td>
														<td>&nbsp;</td>
													</tr>
													<tr>
														<td width="100" valign="top" nowrap>Last name</td>
														<td width="140"><input class="toupper" type="text"
															name="clname" id="clname" value="" /></td>
														<td width="140">&nbsp;</td>
													</tr>
													<tr>
														<td valign="top" nowrap>First name</td>
														<td nowrap><input class="toupper" type="text"
															name="cfname" id="cfname" value="" /></td>
														<td>&nbsp;</td>
													</tr>
													<tr>
														<td valign="top" nowrap>Address</td>
														<td><input class="i" type="text" name="caddress"
															id="caddress" value="" /></td>
														<td>&nbsp;</td>
													</tr>
													<tr>
														<td valign="top" nowrap>City</td>
														<td><input class="toupper" type="text" name="ccity"
															id="ccity" value="MONTREAL" /></td>
														<td>&nbsp;</td>
													</tr>
													<tr>
														<td valign="top" nowrap>Province</td>
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
														<td>&nbsp;</td>
													</tr>
													<tr>
														<td valign="top" nowrap>zip/postal</td>
														<td><input class="toupper" type="text" name="czip"
															id="czip" value="" /></td>
														<td>&nbsp;</td>
													</tr>
													<tr>
														<td valign="top" nowrap>ID</td>
														<td><input class="i" type="text" name="cemail" id="cemail"
															value="" /></td>
														<td>&nbsp;</td>
													</tr>
												</table></td>
											<td width="20%" valign="top">
											<!--  
											<div class="buttonbox">
													<input type="button" class="_button" id="cnew" name="cnew"
														value="new">
												
												</div>
												<div class="buttonbox">
													<input type="button" class="_button" id="cedit"
														name="cedit" value="edit">
												
												</div>
												
												<div class="buttonbox"><input type="button" class="_button" id="aclearfrm" name="aclearfrm" value="New Order"></div>  -->
												<div class="buttonbox"><input type="button" class="_button" id="cclear"	name="cclear" value="Clear NG">	</input></div>

												</td>
										</tr>
									</table>
								</form></td>
							<td valign="top" width="50%"><form id="receiverfrm">
									<input type="hidden" id="receiverid" name="receiverid" value="" />
									<div class="htoggle" id="receiver_toggle">Ng&#432;&#7901;i Nh&#7853;n - ! Kh&#244;ng &#273;&#432;&#7907;c d&#7909;ng:
													<span style="padding:3px;color:red;font:bold 10px Verdana, Arial, Helvetica, sans-serif;"> &#46; &#35; &#40; &#41; &#47;</span></div>
									<div class="ctoggle" id="receiverinfo"></div>
									<div style="padding:3px;color:black;font:bold 12px Verdana, Arial, Helvetica, sans-serif;"></div>
									<table width="100%" border="0" cellspacing="1" cellpadding="2">
										<tr>
											<td width="80%" valign="top"><table width="100%" border="0"
													cellspacing="0" cellpadding="0">
													<tr>
														<td valign="top" nowrap>Phone</td>
														<td nowrap><input class="i" type="text" name="rphone"
															id="rphone" value="" /></td>
														<td>&nbsp;</td>
													</tr>
													<tr>
														<td width="100" valign="top" nowrap>Last name</td>
														<td width="140"><input class="toupper" type="text"
															name="rlname" id="rlname" value="" /></td>
														<td width="140">&nbsp;</td>
													</tr>
													<tr>
														<td valign="top" nowrap>First name</td>
														<td nowrap><input class="toupper" type="text"
															name="rfname" id="rfname" value="" /></td>
														<td>&nbsp;</td>
													</tr>
													<tr>
														<td valign="top" nowrap>Address</br><sub>&#272;ia chi</sub><br/><sub>&#272;ia phuong</sub>
														</td>
														<td><textarea style="width: 148px;" name="rdiachi"
																id="rdiachi" cols="" rows="2"></textarea></td>
														<td>&nbsp;</td>
													</tr>
													<tr>
														<td valign="top" nowrap>City/ Tinh</td>
														<td><select class="_s" name="rtptinh" id="rtptinh">
																<option value="0" selected>Ch&#7885;n t&#7881;nh/th&#224;nh</option>
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
														<td valign="top" nowrap>2<sup>nd</sup> phone</td>
														<td nowrap><input class="i" type="text" name="remail"
															id="remail" value="" /></td>
														<td>&nbsp;</td>
													</tr>
												</table></td>
											<td width="20%" valign="top">
											<!--  
											 <div class="buttonbox">
													<input type="button" class="_button" id="rnew" name="rnew"
														value="new">
												
												</div>
												<div class="buttonbox">
													<input type="button" class="_button" id="redit"
														name="redit" value="edit">
												<div style="padding:3px;color:black;font:bold 12px Verdana, Arial, Helvetica, sans-serif;">S&#7917; d&#7909;ng:
													<span style="padding:3px;color:Green;font:bold 14px Verdana, Arial, Helvetica, sans-serif;"> &#45;</span></div>
												</div>
												
												<div class="buttonbox"><input type="button" class="_button" id="aclearfrm" name="aclearfrm" value="New Order"> </input></div>  -->
												<div class="buttonbox"><input type="button" class="_button" id="rclear" name="rclear" value="Clear NN"> </input></div>
												
											</td>
										</tr>
									</table>
								</form></td>
						</tr>
						<tr>
							<td colspan="2">
								<div class="htoggle">Transaction - <span style="padding:3px;color:red;font:bold 11px Verdana, Arial, Helvetica, sans-serif;">
													* Automatic 1.5% < $950.00 > 2% v&#224; ID + $5,00</span></div>
								<form id="transactionfrm">
									<input type="hidden" id="transactionid" value="" />
									<div class="ctoggle" id="transactioninfo"></div>
									<table width="100%" border="0" cellspacing="0" cellpadding="2">
										<tr>
											<td width="450" valign="top">
												<table width="450" border="0" cellspacing="0"
													cellpadding="0">
													<tr>
														<td width="140" valign="top" nowrap>Co. number</td>
														<td width="140"><input class="i" type="text"
															name="trans_conumber" id="trans_conumber" value="" disabled/></td>
														<td width="100"></td>
													</tr>
													<tr>
														<td width="140" valign="top" nowrap>Local Amount</td>
														<td width="140"><input class="i" type="text"
															name="localamount" id="localamount" value="" /></td>
														<td width="100"><select class="_ssmall"
															id="selectlocaltype" name="selectlocaltype">
																<option value="0">CAD</option>
																<option value="1">USD</option>
																<option value="2">VND</option>
														</select></td>
													</tr>
													<tr>
														<td valign="top" nowrap>Delivery Amount</td>
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
														<td valign="top" nowrap>Service & Fee</td>
														<td><input class="i" type="text" name="fee" id="fee"
															value="" /></td>
														<td><div id="feepercent"></div>
														</td>
													</tr>
													<tr>
														<td valign="top" nowrap>Total Amount</td>
														<td><input class="i" type="text" name="totalamount"
															id="totalamount" value=""
															style="font-weight: bold; color: #990000;"
															disabled="disabled" /></td>
														<td><div class="buttonbox"><input type="button" class="_button" id="aclearfrm" name="aclearfrm" value="New Order"> </input></div></td>
													</tr>
													<tr>
														<td valign="top" nowrap>Delivery Method</td>
														<td><select class="_s" id="deliverymethod"
															name="deliverymethod">
																<option value="0">Home / T&#7841;i Nh&#224;</option>
																<option value="1">Pickup / T&#7841;i Qu&#7847;y</option>
																<option value="2">Transfer / Chuy&#7875;n Kho&#7843;n</option>
														</select></td>
														<td><div class="buttonbox"><input type="button" class="_button" id="tclear" name="tclear" value="Clear TrN"> </input></div></td>
													</tr>
													<tr>
														<td valign="top" nowrap>Note</td>
														<td><textarea name="tnote" id="tnote" cols="20" rows="4"></textarea></td>
														<td>
														  <div class="buttonbox">
																  <input type="button" class="_button" id="trans_print"
																	name="trans_print" value="Preview"> </input>
															</div>
															<div class="buttonbox">
																<input type="button" class="_button" id="trans_submit"
																	name="trans_submit" value="Submit"> </input>
															</div>
														</td>
													</tr>
												</table>
											</td>
											<td width="300">
											<table>
												<tr><td>attachment</td>
												</tr>
												<tr><td><input type="file" name="transactionattachment" id="transactionattachment" style="width:300px;"/></td>
												</tr>
												<tr><td>
														<style>
														.viewpanel{
															border:solid 1px #ccc;
															width:300px;height:150px;
															padding:5px;cursor:hand;cursor:pointer;
														}
														</style>
														<div class="viewpanel" id="viewattachment">
														view upload file, click here</br>
														view size 300x150</br>
														</div>
													</td>
												</tr>
											</table>
											</td>
										</tr>
									</table>
								</form>
							</td>
							
						</tr>
					</table>
					<!-- end #mainpane -->
				</div>
				<br class="clearfloat" />

			</div>
			<div id="tabs-transaction">
			<div class="topdate">
			From: <input class="datebox" type="text" id="transaction_fromdatepicker" name="transaction_fromdatepicker" 
					value="<?php $d=strtotime("-10 days"); echo date("m/d/Y", $d) ?>"></input> 
			To: <input class="datebox" type="text" id="transaction_todatepicker" name="transaction_todatepicker" 
				value="<?php $d=strtotime("tomorrow"); echo date("m/d/Y", $d) ?>"></input>
			<input type="button" id="transaction_datesubmit" value="search"></input>&nbsp;&nbsp;&nbsp;
			<input type="button" id="transaction_listall" value="list all transaction"></input></div>
			<div id="transactionpane"></div>
			</div>
			<div id="tabs-customer"></div>
			<div id="tabs-receiver"></div>
			<div id="tabs-account">
				<div class="maindiv">
					<div class="h">1. change username/password</div>
					<div id="changepasswordbox" class="hiddenbox">
						<form id="changepasswordfrm">
							<input type="hidden" id="changepasswordfrm_type" name="type"
								value="changepassword" />
							<table width="400" border="0" cellspacing="3" cellpadding="1">
								<tr>
									<td width="40%">old password</td>
									<td><input type="password" autocomplete="off"
										id="changepassword_oldpassword"
										name="changepassword_oldpassword" value="" /></td>
								</tr>
								<tr>
									<td>new password</td>
									<td><input type="password" autocomplete="off"
										id="changepassword_newpassword"
										name="changepassword_newpassword" value="" /></td>
								</tr>
								<tr>
									<td>confirm new password</td>
									<td><input type="password" autocomplete="off"
										id="changepassword_repeatnewpassword"
										name="changepassword_repeatnewpassword" value="" /> <span
										id="changepassword_error">&nbsp;</span></td>
								</tr>
								<tr>
									<td>&nbsp;</td>
									<td><input type="button" id="changepassword_submit"
										value="confirm change" /></td>
								</tr>
							</table>
						</form>
					</div>
					<div class="h">2. change personal information</div>
					<div id="changeinfobox" class="hiddenbox">
						<form id="changeinfofrm">
							<table width="400" border="0" cellspacing="3" cellpadding="1">
								<tr>
									<td width="40%">first name</td>
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
									<td>&nbsp;</td>
									<td><input type="button" id="changeinfo_submit"
										name="changeinfo_submit" value="confirm change" /></td>
								</tr>
							</table>
						</form>
					</div>
				</div>
			</div>
			<div id="tabs-training">
			<style>
			.font12 {padding:2px; font:12px verdana, Arial, Helvetica, sans-serif;}
			.bold {padding:3px; font:bold 12px Verdana, Arial, Helvetica, sans-serif;}
			.rcolor {color: red;}
			.gcolor {color: green; background-color:yellow;}
			</style>
				<table border="1" width="100%">
					<tr><td align="center"><big>ON GOING CONTRUCTION!</big></td></tr>
					<tr><td><div><span class="bold">&nbsp; Brief TY PC-TECH policy under the scope of FINTRAC</span><br/>
								1. Ensure Customer accurate info.<br/>
								2. Ensure Beneficiary accurate info.<br/>
								3. Determination for a legitemate Transaction<br/>
								3.1 Between 50$ to 950$, our fees as 1.5% + 5$ per Trans.<br/>
								3.2 Above 950$ are 2% + 5$, ID1 REQUIRED<br/>
								3.3 Above 2500$ ID2 REQUIRED<br/>
								3.4 Above 4500$ Transaction REFUSED<br>
								3.5 Transaction may report for suspicious AMF/ATF Act.<br/><br/>
								<span class="bold">&nbsp; Website Guideline</span><br/>
								- NO! special accent:<span class="rcolor"> &#46; &#126; &#94; &#96; &#8217;</span> or 
									<span class="rcolor"> abc &#46; &#35; &#40; &#41; &#47;</span><br/>
								- ONLY <span class="gcolor"> -&nbsp;</span><br/><br/>
								<span class="bold">&nbsp; Customer/Client</span><br/>
								1.1 Phone No. per Customer/Record <br/>
								1.2 Last Name and Date of Birth<br/>
								1.3 First Name and Middle Name<br/>
								1.4 Address, City, Postal Code<br/>
								1.5 ID Type, ID# and Expiration<br/><br/>
								<span class="bold">&nbsp; Beneficiary/Reciever</span><br/>
								2.1 Phone No. per Customer/Record <br/>
								2.2 Last Name and ID#<br/>
								2.3 First Nam and Middle Name<br/>
								2.4 Address/Account#, City, State<br/>
								2.5 Second Contact Number<br/><br/>
								
								<span class="bold">Finalize Transaction</span><br/>
								3.1 Send Amount and Currency Type <br/>
								3.2 Fee are automatic Generate, promoton may apply<br/>
								3.3 Transfer Method: Delivery, Pickup and Account Transfer<br/>
								3.4 Instruction/Message/Note for Beneficiary / Account #<br/>
								3.5 SUBMIT transaction, Print Receipt upon request<br/>
								
								</div>
								
						</td></tr>
				</table>
			
			</div>
			<div id="tabs-report">
			<div class="topdate">
			from <input class="datebox" type="text" id="report_fromdatepicker" name="report_fromdatepicker"></input> 
			to <input class="datebox" type="text" id="report_todatepicker" name="report_todatepicker"></input>
			&nbsp;&nbsp;&nbsp;
			<select class="s" id="report_showtype" name="report_showtype" style="padding:3px;">
						<option value="0">all transactions</option>
						<option value="1">new transactions</option>
						<option value="2">approved transactions</option>
						<option value="3">process transactions</option>
						<option value="4">received transactions</option>
						<option value="5">completed transactions</option>
						<option value="6">cancel transactions</option>
				</select>
			<input type="button" id="report_listall" value="show"></input></div>
			<div id="reportpane"></div></div>
		</div>
		<!-- end #container -->
	</div>
	<div class="bottomright">
		<div class="bottomrightitem">Copyright&copy;&nbsp;2016 TY PC-TECH INC</div>
	</div>

	<div class="errorpane">
		<input type="hidden" id="agentid" name="agentid"
			value="<?php echo ($_SESSION['user_id']);?>" />
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
	<div id="dialog-confirm" title="Transaction detail"></div>
</body>
</html>
