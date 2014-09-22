{{ Form::open('user/ucp/security', 'POST') }}
	<fieldset>
		@if (Session::get('has_errors') == true)
		<div class="alert alert-error">
 			<strong>Oops!</strong> Something went wrong there:
 			<ul>
		@foreach ($errors->all() as $error)
			<li>{{$error}}</li>
		@endforeach
			</ul>
		</div>
		<br />
		@endif

		@if(Session::get('has_login_errors') == true)
		<div class="alert alert-error">
 			<strong>Oops!</strong> Something went wrong there:
 			<ul>
				<li>The email and password combination do not match our records</li>
			</ul>
		</div>
		<br />
		@endif
		
		<legend>Security Settings</legend>
		<label>Current email (required):</label>
		<input type="text" id="currentemail" name="currentemail" required>
		<span class="help-inline">Please enter your current email address</span>
		<label>New email:</label>
		<input type="text" name="newemail">
		<span class="help-inline">Please enter a new email address if desired</span>
		<label>Confirm New email:</label>
		<input type="text" name="newemail_confirmation">
		<span class="help-inline">If you are changing your email address, please confirm it here</span>
		<legend></legend>
		<label>Current password (required):</label>
		<input type="password" name="currentpassword" required>
		<span class="help-inline">Please enter your current password for verification</span>
		<label>New Password:</label>
		<input type="password" name="newpassword">
		<span class="help-inline">Please enter a new password</span>
		<label>Confirm New Password:</label>
		<input type="password" name="newpassword_confirmation">
		<span class="help-inline">If you entered a new password, please confirm it here</span>
		<br />
		<button type="submit" class="btn">Submit</button>
	</fieldset>
{{ Form::close() }}