@layout('template')

@section('head')
<script type="text/javascript">
! function ($) {
    $(function () {
        window.prettyPrint && prettyPrint()
    })
}(window.jQuery)
</script>
@endsection

@section('title')
API Docs
@endsection

@section('content')


<div class="row">
	<div class="span3">
	@include('docs.api.sidebar')->with('page', $page)
    </div>
    <div class="span9">
		<div class="well well-small">
			<div class="alert alert-info">
				<strong>Welcome!</strong> Welcome to the API documentation! It is currently a work in progress. 
				Although most API functions are working, bugs may be experienced. Also, some functions may not function identically
				to the way described in the Docs, as they may have changed since the last documentation update.
			</div>
			{{$content}}
		</div>
	</div>
</div>

@endsection