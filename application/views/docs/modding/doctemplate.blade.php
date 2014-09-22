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
	@include('docs.modding.sidebar')->with('page', $page)
    </div>
    <div class="span9">
		<div class="well well-small">
			{{$content}}
		</div>
	</div>
</div>

@endsection