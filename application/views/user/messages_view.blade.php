@layout('template')

@section('head')
<script type="text/javascript">
	$(document).ready(function() {
		$("#deleteMessage").click(function() {
			if ($("#deleteMessage").hasClass('disabled') == false) {
				$("#deleteConfirm").html('<br /><div class="alert alert-error"><button name="deleteDismiss" id="deleteDismiss" type="button" class="close" data-dismiss="alert" onclick="resetDeleteButton();">&times;</button><strong>Warning!</strong> Clicking the Delete button will permanently delete this message. <br />  			<a class="btn btn-danger" href="{{ URL::to('user/messages/delete') }}/{{ $message->mid }}"><i class="icon-trash"> </i> Delete</a></div>');   
				$("#deleteMessage").addClass('disabled');
			}
		});

		
	});
    function resetDeleteButton() {
			$("#deleteMessage").removeClass('disabled');
	}
</script>
@endsection

@section('title')
Message - {{$message->title}}
@endsection

@section('content')

<div class="row">
	<div class="span3">
	@include('user.sidebar')
    </div>
    <div class="span9">
		<div class="well well-small">
			<table class="table table-bordered table-hover">
			  <thead>
			    <tr>
			      <th><strong>Message: {{$message->title}}</strong></th>
			    </tr>
			  </thead>
			  <tbody>
			  	<tr >
			  		<td>{{$sentrecline}} <a href="{{ URL::to('profile/view') }}/{{$message->sender}}">{{$message->username}}</a> at {{$message->timesent}}</td>
			  	</tr>
			    
			   	<tr>
			      <td>{{ BBCode::parse($message->content) }}</td>
			    </tr>
			    
			  </tbody>
			</table>

			@if($message->sender != 0)
			<a class="btn" href="{{ URL::to('user/messages/send') }}/{{ $message->sender }}"><i class="icon-edit"> </i> Reply</a>
			@endif
			<a class="btn btn-danger" id="deleteMessage" name="deleteMessage"><i class="icon-trash"> </i> Delete</a>
			<div id="deleteConfirm" name="deleteConfirm"></div>

		</div>
	</div>
</div>

@endsection
