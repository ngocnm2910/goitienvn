
<div class="mainpane">
	<form method="post" action="register.php" name="registerform">
		<table width="400" border="0">
			<tr>
				<td><label for="login_input_accesscode">Access Level</label></td>
				<td><select class="login_input" name="user_accesslevel">
						<option value="3">Admin</option>
						<option value="2">Local</option>
						<option value="1">Foreigner</option>
						<option value="0">Guest</option>
				</select></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td><label for="login_input_accesscode">Commission Level</label></td>
				<td><select class="login_input" id="user_acommissionlevel" name="user_acommissionlevel">
							<option value="30">level 1 - 30%</option>
							<option value="35">level 2 - 35%</option>
							<option value="40">level 3 - 40%</option>
							<option value="45">level 4 - 45%</option>
							<option value="50">VIP - 50%</option>
					</select></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td><label for="login_input_username">Username</label></td>
				<td><input id="login_input_username" class="login_input" type="text"
					pattern="[a-zA-Z0-9]{2,64}" name="user_name" required /></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td><label for="login_input_email">User's email</label></td>
				<td><input id="login_input_email" class="login_input" type="email"
					name="user_email" required /></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td><label for="login_input_password_new">Password (min 6 char)</label></td>
				<td><input id="login_input_password_new" class="login_input"
					type="password" name="user_password_new" pattern=".{6,}" required
					autocomplete="off" /></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td><label for="login_input_password_repeat">Repeat password</label></td>
				<td><input id="login_input_password_repeat" class="login_input"
					type="password" name="user_password_repeat" pattern=".{6,}"
					required autocomplete="off" /></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td><input type="submit" name="register" value="Register" /></td>
				<td>&nbsp;</td>
			</tr>
		</table>
	</form>
</div>