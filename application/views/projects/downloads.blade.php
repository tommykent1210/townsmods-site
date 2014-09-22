@layout('template')

@section('head')
@endsection

@section('title')
{{$project->title}} - Downloads
@endsection

@section('content')
	<div class="well well-small">

		<legend>{{$project->title}} - Downloads</legend>
		

		<table class="table table-bordered">
			<tr>
				<th width="40%">File</th>
				<th width="30%">Downloads</th>
				<th width="30%">Action</th>
			</tr>

			@foreach($downloads as $download)
			@if ($download->id == $project->maindownload)
			<tr class="info">
			@else
			<tr>
			@endif
				<td>
					<strong>{{$download->title}}</strong>
				</td>
				<td>
					<p>{{$download->downloads}}</p>
				</td>
				<td>
					<a href="{{URL::to('download/get/'.$download->id)}}" class="btn btn-info"><i class="icon-arrow-down"> </i> Download</a>
				</td>
			</tr>
			@endforeach
		</table>
	</div>
@endsection