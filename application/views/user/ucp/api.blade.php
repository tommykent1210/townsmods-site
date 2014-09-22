<legend>API</legend>

<div class="alert alert-info">
	<strong>Notice:</strong> This is a BETA feature of TownsMods. 
	Please refer to the <a href="{{URL::to('docs/api')}}"><i class="icon-book"></i> API Documentation</a> for 
	more information.
</div>

@if (DB::table('api')->where('userid', '=', Auth::user()->id)->count() < Config::get('townsmods.maxapikeys'))
<div class="pull-right">
{{ Form::open('api/generate', 'POST', array('class' => 'form-inline'))}}
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

	{{ Form::text('nickname', '', array('placeholder' => 'API Key Nickname')) }}

	{{ Form::submit('Generate!', array('class' => 'btn btn-success')) }}
{{ Form::close() }}
</div>
@else

<div class="btn btn-danger disabled pull-right">Max Keys Generated</div><br /><br />
@endif

<div>
	
	<table class="table table-bordered table-striped">
		<tr>
			<th>Key Name</th>
			<th>API Key</th>
			<th>Encryption Key</th>
		</tr>

		@if (DB::table('api')->where('userid', '=', Auth::user()->id)->count() > 0)
		
		@foreach (DB::table('api')->where('userid', '=', Auth::user()->id)->get() as $key)
		<tr>
			<td><em>{{$key->nickname}}</em></td>
			<td>{{$key->apikey}}</td>
			<td>{{$key->encryptionkey}}</td>
		</tr>
		@endforeach
		@else 
		<tr>
			<td colspan="3" style="text-align: center;"><em>No API Key's Generated. Generate one above!</em></td>
		</tr>
		@endif
	</table>
</div>