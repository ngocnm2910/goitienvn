<style>
tr, td, input {
	font:normal 11px Verdana, Arial, Helvetica, sans-serif;
}
.header {
	font:bold 11px verdana;
	cursor:hand;
	cursor:pointer;
	padding:5px 0px 5px 0px;
	text-transform:uppercase;
	border-bottom:solid 1px #333;
}
.maindiv {
	margin: 5px 0px 0px 10px;
	width:380px;
}
.hiddenbox {
	padding: 5px 0px 5px 0px;
	display:block;
}
</style>
<script>
$(document).ready(function() {
	//load data to changeinfofrm
	var aid=$("#agentid").val();
	$.ajax({
			type : "POST",
			url : "libraries/changeinfo_get.php",
			data : {type:'loadinfo',aid:aid},
			cache : false,
			success : function(result) {
				$("#infobar").html(result);
				}
			});
			
	$("#changepassword_repeatnewpassword").change(function(){
		checkpassword();
	});
	$("#changepassword_submit").click(function(){
		if(checkpassword()){
			var dataString = getinputfrmdata('changepasswordfrm');
			dataString = dataString+"&aid="+$("#agentid").val();
			//alert(dataString);
			$.ajax({
			type : "POST",
			url : "libraries/changeinfo_get.php",
			data : dataString,
			cache : false,
			success : function(result) {
				//alert(result);
				var temp=result.split('|');
				$("#infobar").append(temp[0]);
				resetinput();
				}
			});
		}
	});
	
	$("#changeinfo_submit").click(function(){
			var dataString = getinputfrmdata('changeinfofrm');
			dataString = dataString+"&aid="+$("#agentid").val()+"&type=changeinfo_update";
			//alert(dataString);
			$.ajax({
			type : "POST",
			url : "libraries/changeinfo_get.php",
			data : dataString,
			cache : false,
			success : function(result) {
				//alert(result);
				var temp=result.split('|');
				$("#infobar").append(temp[0]);
				resetinput();
				}
			});
	});
	$("#changeinfo_phone").change(function(){
		var temp = phone_format($(this).val());
		$(this).val(temp);
	});
	

	$("#changeinfo_zip").change(function(){
		var temp = zip_format($(this).val());
		$(this).val(temp);
	});


function resetinput(){
	$("#changepassword_username").val('');
	$("#changepassword_oldpassword").val('');
	$("#changepassword_newpassword").val('');
	$("#changepassword_repeatnewpassword").val('');
	return false;
}
function checkpassword(){
	var p1 = $("#changepassword_newpassword").val();
	var p2 = $("#changepassword_repeatnewpassword").val();
		if(p1!=p2){
			alert('password not same');
			return false
		}	
	return true;	
}
});

</script>
<div class="maindiv">
  <div class="header" id="h_password">1. change username/password</div>
  <div id="changepasswordbox" class="hiddenbox">
    <form id="changepasswordfrm">
      <input type="hidden" id="changepasswordfrm_type" name="type" value="changepassword"  />
      <table width="400" border="0" cellspacing="3" cellpadding="1">
        <tr>
          <td width="40%">old password</td>
          <td><input type="password" autocomplete="off" id="changepassword_oldpassword" name="changepassword_oldpassword" value="" /></td>
        </tr>
        <tr>
          <td>new password</td>
          <td><input type="password" autocomplete="off" id="changepassword_newpassword" name="changepassword_newpassword" value="" /></td>
        </tr>
        <tr>
          <td>confirm new password</td>
          <td><input type="password" autocomplete="off" id="changepassword_repeatnewpassword" name="changepassword_repeatnewpassword" value=""/>
            <span id="changepassword_error">&nbsp;</span></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td><input type="button" id="changepassword_submit" value="confirm change"/></td>
        </tr>
      </table>
    </form>
  </div>
  <div class="header" id="h_info">2. change personal information</div>
  <div id="changeinfobox" class="hiddenbox">
    <form id="changeinfofrm">
      <table width="400" border="0" cellspacing="3" cellpadding="1">
        <tr>
          <td width="40%">first name</td>
          <td><input type="text" required id="changeinfo_firstname" name="changeinfo_firstname" class="toupper"/></td>
        </tr>
        <tr>
          <td>last name</td>
          <td><input type="text" required id="changeinfo_lastname" name="changeinfo_lastname" class="toupper"/></td>
        </tr>
        <tr>
          <td>address</td>
          <td><input type="text" required id="changeinfo_address" name="changeinfo_address" class="i"/></td>
        </tr>
        <tr>
          <td>city</td>
          <td><input type="text" required id="changeinfo_city" name="changeinfo_city" class="toupper"/></td>
        </tr>
        <tr>
          <td>province</td>
          <td><input type="text" required id="changeinfo_province" name="changeinfo_province" class="toupper"/></td>
        </tr>
        <tr>
          <td>zip</td>
          <td><input type="text" required id="changeinfo_zip" name="changeinfo_zip" class="i"/></td>
        </tr>
        <tr>
          <td>phone</td>
          <td><input type="text" required id="changeinfo_phone" name="changeinfo_phone" class="i"/></td>
        </tr>
        <tr>
          <td>email</td>
          <td><input type="email" required id="changeinfo_email" name="changeinfo_email" class="i"/></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td><input type="button" id="changeinfo_submit" name="changeinfo_submit" value="confirm change"/></td>
        </tr>
      </table>
    </form>
  </div>
</div>
