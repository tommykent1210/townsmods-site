@layout('template')

@section('head')
{{HTML::style('css/custom-theme/jquery-ui-1.10.2.custom.min.css')}}
<script type="text/javascript">
jQuery(document).ready(function($){
	$('#recipient').autocomplete({source:'{{URL::to('data/user')}}', minLength:2});
});
</script>
{{ Editor::loadEditorJS() }}
@endsection

@section('title')
New Message
@endsection

@section('content')

<div class="row">
	<div class="span3">
	@include('user.sidebar')
    </div>
    <div class="span9">
		<div class="well well-small">
			<h4>New Message:</h4>
			<hr />
			@if ($has_errors == true)
				<div class="alert alert-error">
					<strong>There were errors when sending this!</strong>
					<ul>
					@foreach($errors as $error)
						{{ $error }}
					@endforeach
					</ul>
				</div>
			@endif
			{{ Form::open('user/sendmessage') }}
				{{ Form::label('recipient', 'Recipient:') }}
				{{ Form::text('recipient', $recipient, array('id' => 'recipient', 'name' => 'recipient')) }}
				<br />
				{{ Form::label('title', 'Title:') }}
				{{ Form::text('recipient', '', array('id' => 'title', 'name' => 'title', 'class' => 'input-block-level')) }}
				<br />
				{{ Form::label('message', 'Message:') }}
				<!-- editor shiz -->
				{{ Editor::outputEditor() }}
				{{ Form::textarea('message', '', array('id' => 'message', 'name' => 'message', 'class' => 'input-block-level')) }}
				<br />
				{{ Form::submit('send') }}
			{{ Form::close() }}
		</div>
	</div>
</div>
@endsection