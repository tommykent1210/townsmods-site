@layout('template')

@section('head')
@endsection

@section('title')
{{$userData->username}}'s Profile
@endsection

@section('content')
<div class="well">
	<legend>{{$userData->username}}'s Profile</legend>
	<table class="table table-bordered">
		<tr>
			<td width="40%"><strong>Username:</strong></td>
			<td>{{$userData->username}}</td>
		</tr>
		<tr>
			<td width="40%"><strong>Registration Date:</strong></td>
			<td>{{date('l jS \of F Y h:i:s A', $userData->registrationdate)}}</td>
		</tr>
		<tr>
			<td width="40%"><strong>Rank:</strong></td>
			<td>{{Core::formatRank($userData->rank)}}</td>
		</tr>
		<tr>
			<td width="40%"><strong>XP:</strong></td>
			<td>{{$userData->xp}}</td>
		</tr>

		<tr>
			<td colspan="2">
				<a href="{{URL::to('user/messages/send/'.$userData->id)}}" class="btn btn-info"><i class="icon-envelope"></i> PM User</a>
		
				@if (DB::table('mods')->where('authorid', '=', $userData->id)->count() > 0)
				<br />
				<br />
				{{Form::open('projects/search', 'POST')}}
					<input type="hidden" id="author" name="author" value="{{$userData->username}}" /> 
					<button type="submit" class="btn btn-info"><i class="icon-search icon-white"> </i> User Mods</button>
				{{Form::close()}}
				@endif
			</td>
		</tr>

	</table>
</div>
@endsection