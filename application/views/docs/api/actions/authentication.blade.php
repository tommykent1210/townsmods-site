	<legend>Authentication Actions</legend>
	<p>The following actions regard authentication via the API for TownsMods.net. The main purpose of this is to allow users
		to authenticate remotely, but enjoy the benefits of having an account. Many other API functions require the user to be 
		authenticated first. So this action set is vital the the rest of the API.</p>

	<legend>Contents</legend>
	<ul>
		<li><a href="#login">Login (Username)</a></li>
		<li><a href="#login_email">Login (Email)</a></li>
		<li><a href="#logout">Logout</a></li>
	</ul>

</div>

<div class="well well-small">
	<a id="login"></a><h4>Login (Username) <small>- Action name: "auth_login"</small></h4>
	<p>Handles the login of the user, using their username and password. Returns a result and a session variable.</p>

	<strong>Request:</strong>
	<table class="table table-bordered table-striped">
		<tr>
			<th>Parameter</th>
			<th>Description</th>
			<th>Example</th>
		</tr>

		<tr>
			<td><em>username</em></td>
			<td>The username of the user</td>
			<td>testuser</td>
		</tr>
		<tr>
			<td><em>password</em></td>
			<td>The password of the user</td>
			<td>testpass</td>
		</tr>
	</table>


	<br />

	<strong>Response:</strong>
	<table class="table table-bordered table-striped">
		<tr>
			<th>Parameter</th>
			<th>Description</th>
			<th>Example</th>
		</tr>

		<tr>
			<td><em>result</em></td>
			<td>An integer value dictating the result. Currently, only the results "1" (accepted), and "0" (denied) are available.</td>
			<td>1</td>
		</tr>
		<tr>
			<td><em>userid</em></td>
			<td>An integer of up to 10 characters, the user id of the user</td>
			<td>12345</td>
		</tr>
		<tr>
			<td><em>session</em></td>
			<td>A 32 character session variable. This is <strong>vitally</strong> important for most other API functions 
				that require authentications as this is the variable that provides proof of login</td>
			<td>f7io3238ufj34t8u0fdgjer8ufgdfgiu4</td>
		</tr>
	</table>

</div>

<div class="well well-small">
	<a id="login_email"></a><h4>Login (Email) <small>- Action name: "auth_login_email"</small></h4>
	<p>Handles the login of the user, using their email and password. Returns a result and a session variable.</p>

	<strong>Request:</strong>
	<table class="table table-bordered table-striped">
		<tr>
			<th>Parameter</th>
			<th>Description</th>
			<th>Example</th>
		</tr>

		<tr>
			<td><em>email</em></td>
			<td>The email of the user</td>
			<td>testuser@test.com</td>
		</tr>
		<tr>
			<td><em>password</em></td>
			<td>The password of the user</td>
			<td>testpass</td>
		</tr>
	</table>


	<br />

	<strong>Response:</strong>
	<table class="table table-bordered table-striped">
		<tr>
			<th>Parameter</th>
			<th>Description</th>
			<th>Example</th>
		</tr>

		<tr>
			<td><em>result</em></td>
			<td>An integer value dictating the result. Currently, only the results "1" (accepted), and "0" (denied) are available.</td>
			<td>1</td>
		</tr>
		<tr>
			<td><em>userid</em></td>
			<td>An integer of up to 10 characters, the user id of the user</td>
			<td>12345</td>
		</tr>
		<tr>
			<td><em>session</em></td>
			<td>A 32 character session variable. This is <strong>vitally</strong> important for most other API functions 
				that require authentications as this is the variable that provides proof of login</td>
			<td>f7io3238ufj34t8u0fdgjer8ufgdfgiu4</td>
		</tr>
	</table>
</div>

<div class="well well-small">
	<a id="logout"></a><h4>Logout <small>- Action name: "auth_logout"</small></h4>
	<p>Handles the logout of a user, deleting their session.</p>

	<strong>Request:</strong>
	<table class="table table-bordered table-striped">
		<tr>
			<th>Parameter</th>
			<th>Description</th>
			<th>Example</th>
		</tr>

		<tr>
			<td><em>userid</em></td>
			<td>The user ID of the user</td>
			<td>12345</td>
		</tr>
		<tr>
			<td><em>session</em></td>
			<td>The 32 character session code, obtained upon login</td>
			<td>9xmOTrjJgrXkaoknLF0c40Spxhr0gUlz</td>
		</tr>
	</table>


	<br />

	<strong>Response:</strong>
	<table class="table table-bordered table-striped">
		<tr>
			<th>Parameter</th>
			<th>Description</th>
			<th>Example</th>
		</tr>

		<tr>
			<td><em>result</em></td>
			<td>A boolean result, taking the value of 1 for successful logout, and 0 for unsuccessful logout</td>
			<td>1</td>
		</tr>
	</table>
</div>