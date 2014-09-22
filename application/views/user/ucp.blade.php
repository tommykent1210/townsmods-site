@layout('template')

@section('head')
@endsection

@section('title')
Users Control Panel
@endsection

@section('content')

<div class="row">
	<div class="span3">
	@include('user.sidebar')
    </div>
    <div class="span9">
		<div class="well well-small">
			{{$content}}
		</div>
	</div>
</div>
@endsection