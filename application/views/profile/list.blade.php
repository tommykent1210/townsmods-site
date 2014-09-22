@layout('template')

@section('head')
@endsection

@section('title')
Profiles: Page {{$users->page}}
@endsection

@section('content')
	<div class="well well-small">

		<legend>Users
			<div class="pull-right">
				{{Form::open('profile/list', 'POST', array('class' => 'form-inline'))}}
				  {{ Form::text('search', '', array('class' => 'input-small', 'placeholder' => 'Search...')) }}
				  <button type="submit" class="btn">Search</button>
				{{Form::close()}}
			</div>
		</legend>
		<table class="table table-bordered" width="100%">
			<thead>
				<tr>
					<th width="40%">Username</th>
					<th width="30%">Join Date</th>
					<th width="30%">Actions</th>
				</tr>
			</thead>
			<tbody>
		@foreach ($users->results as $user)
        		<tr>
	        		<td>{{$user->username}}</td>
	        		<td>{{date("F j, Y, g:i a", $user->registrationdate)}}</td>
	        		<td>
	        			@if(Auth::check())
	        			<a href="{{URL::to('user/messages/send/'.$user->id)}}" class="btn btn-info"><i class="icon-envelope"></i> PM User</a>
	        			@endif
	        			<a href="{{URL::to('profile/view/'.$user->id)}}" class="btn btn-info"><i class="icon-user"></i> View Profile</a>
	        			
	        		</td>
	        	</tr>
        @endforeach	        	
        	<tbody>
        </table>
        {{ $users->links() }}

	</div>
@endsection