@layout('template')

@section('head')
@endsection

@section('title')
Register
@endsection

@section('content')

    <div class="row">
		<div class="span6 offset3">
			<div class="well">
				
				<?php echo Form::open('user/resetpassword'); ?>
					<fieldset>
						<legend class="h3">Reset Password</legend>

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
						
						<!-- email field -->
						<div class="control-group {{ $errors->has('email') ? 'error' : '' }}">
						  <label class="control-label" for="email">Email Address:</label>
						  <div class="controls">
						    <input type="text" name="email" id="email">
						  </div>
						</div>

						<br />
						<!-- Register button -->
						<?php echo Form::submit('Send Email', $attributes = array('class' => 'btn btn-success')); ?>
					</fieldset>
				<?php echo Form::close(); ?>
			</div>
		</div>
	</div>
@endsection
