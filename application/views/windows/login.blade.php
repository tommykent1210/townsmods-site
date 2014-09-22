{{ Form::open('user/login'); }}
  <fieldset>
    {{ Form::label('email', 'Email Address:'); }}
    {{ Form::text('email', '', array('class' =>'span4')); }}
    <!-- password field -->
    {{ Form::label('password', 'Password:'); }}
    {{ Form::password('password',array('class' =>'span4')); }}
	<label class="checkbox">Remember me on this computer? {{ Form::checkbox('remember', '0')}}</label>
    <br />
    {{ Form::submit('Login', $attributes = array('class' => 'btn btn-success')); }}
  </fieldset>
{{ Form::close(); }}
<p>Don't have an account? <a href="{{URL::to('user/register')}}"> Register now!</a> - <a href="{{URL::to('user/resetpassword')}}"> Lost Password</a></p>
