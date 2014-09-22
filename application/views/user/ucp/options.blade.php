<legend>User Options</legend>
{{ Form::open('user/ucp/options', 'POST')}}
	@if (Session::get('has_errors') == true)
		<div class="alert alert-error">
 			<strong>Oops!</strong> Something went wrong there:
 			<ul>
		@foreach ($errors->all() as $error)
			<li>{{$error}}</li>
		@endforeach
			</li>
		</div>
		<br />
	@endif
	
	{{ Form::label('prefix', 'Title Prefix:') }}
	{{ Form::select('prefix', Core::getRanks(1), '0') }}

	{{ Form::label('suffix', 'Title Suffix:') }}
	{{ Form::select('suffix', Core::getRanks(2), '0') }}

	<br />
	<hr />
	{{ Form::submit('Save!', array('class' => 'btn btn-success')) }}
{{ Form::close() }}
