@layout('template')

@section('head')
@endsection

@section('title')
Messages - Sent
@endsection

@section('content')

<div class="row">
	<div class="span3">
	@include('user.sidebar')
    </div>
    <div class="span9">
		<div class="well well-small">
			<table class="table table-bordered table-hover">
			  <legend>Sent Messages</legend>
			  <thead>
			    <tr>
			      <th width="60%">Title</th>
			      <th width="20%">Recipent</th>
			      <th width="20%">Sent</th>
			    </tr>
			  </thead>
			  <tbody>
			  	@if ($messages == array())
			  	<tr>
			  		<td colspan="3" style="text-align: center;">No messages to show</td>
			  	<tr>
			  	@else
			    @foreach ($messages as $message)
			    @if($message->sender == 0)
			    <tr class="error">
			    @else
			    <tr>
			    @endif
			      @if ($message->unread == 1)
			      	<td><strong><a href="{{ URL::to('user/messages/viewsent/') }}{{ $message->mid }}">{{ $message->title }}</a></strong></td>
			      @else
					<td><a href="{{ URL::to('user/messages/viewsent/') }}{{ $message->mid }}">{{ $message->title }}</a></td>
			      @endif
			      <td>{{ $message->username }}</td>
			      <td>{{ $message->timesent }}</td>
			    </tr>
			    @endforeach
			    @endif
			  </tbody>
			</table>
		</div>
	</div>
</div>
@endsection