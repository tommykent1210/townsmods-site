@layout('template')

@section('head')
	<script type="text/javascript">
		$('#myTab a').click(function (e) {
		  e.preventDefault();
		  $(this).tab('show');
		})
	</script>
@endsection

@section('title')
Register
@endsection

@section('content')

	<!-- Button to trigger modal -->
	

	<!-- Modal -->
	<div id="TOSModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="TOSModalLabel" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="TOSModalLabel">TownsMods Terms Of Service & Privacy Policy</h3>
		</div>
		<div class="modal-body">
			<div class="terms-switcher">
				<ul id="myTab" class="nav nav-tabs">
					<li class="active"><a href="#TOStab" data-toggle="tab">Terms of Service</a></li>
					<li class=""><a href="#PPtab" data-toggle="tab">Privacy Policy</a></li>
				</ul>
				<div id="myTabContent" class="tab-content">
					<div class="tab-pane fade active in" id="TOStab">
						<p>{{View::make('generic.terms_of_service')}}</p>
					</div>
					<div class="tab-pane fade" id="PPtab">
						<p>{{View::make('generic.privacy_policy')}}</p>
					</div>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Close</button>
		</div>
	</div>

    <div class="row">
		<div class="span6 offset3">
			<div class="well">
				
				<?php echo Form::open('user/register'); ?>
					<fieldset>
						<legend class="h3">Register</legend>

						@if ($errors->has())
						<div class="alert alert-error">
							<h4>Oops! That didn't work!</h4>
							<ul>
								@foreach ($errors->all() as $message)
									<li>{{$message}}</li>
								@endforeach
							</ul>
						</div>
						@endif
						<!-- username field -->
						<div class="control-group {{ $errors->has('username') ? 'error' : '' }}">
						  <label class="control-label" for="username">Username:</label>
						  <div class="controls">
						    <input type="text" name="username" id="username">
						  </div>
						</div>

						<!-- email field -->
						<div class="control-group {{ $errors->has('email') ? 'error' : '' }}">
						  <label class="control-label" for="email">Email Address:</label>
						  <div class="controls">
						    <input type="text" name="email" id="email">
						  </div>
						  <label class="control-label" for="email_confirmation">Confirm Email:</label>
						  <div class="controls">
						    <input type="text" name="email_confirmation" id="email_confirmation">
						  </div>
						</div>

						<!-- password field -->
						<div class="control-group {{ $errors->has('password') ? 'error' : '' }}">
						  <label class="control-label" for="password">Password:</label>
						  <div class="controls">
						    <input type="password" name="password" id="password">
						  </div>
						  <label class="control-label" for="password_confirmation">Confirm Password:</label>
						  <div class="controls">
						    <input type="password" name="password_confirmation" id="password_confirmation">
						  </div>
						</div>

						<p> By clicking "Register" you are agreeing to the following <a href="#TOSModal" role="button" class="" data-toggle="modal">Terms of Service and Privacy Policy</a>
						
						<br />
						<!-- Register button -->
						<?php echo Form::submit('Register', $attributes = array('class' => 'btn btn-success')); ?>
					</fieldset>
				<?php echo Form::close(); ?>
			</div>
		</div>
	</div>
@endsection
