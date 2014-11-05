<!-- Form to get keyword and phone number -->
<table width="300" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
	<tr>
		<form name="form1" method="post" action="validate_customer.php">
			<td>
				<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF">
					<tr>
						<td colspan="3"><strong>Your keywork and phone number, please:</strong></td>
					</tr>
						<tr>
						<td width="78">Keyword</td>
						<td width="6">:</td>
						<td width="294"><input name="keyword" type="text" id="keyword"></td>
					</tr>
					<tr>
						<td>Phone number</td>
						<td>:</td>
						<td><input name="phone" type="text" id="phone"></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td><input type="submit" name="Submit" value="Search"></td>
					</tr>
				</table>
			</td>
		</form>
	</tr>
</table>
<br>

<!-- Provide user a link to see all orders in database -->
<table width="300" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
	<tr>
		<td>
			<a href="order_show.php">Show all orders in database</a>
		</td>
	</tr>
</table>