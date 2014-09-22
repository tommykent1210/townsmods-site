@layout('template')

@section('head')
@endsection

@section('title')
Edit Files
@endsection

@section('content')
	<div class="well well-small">

		<legend>Edit Project</legend>
		
		<h4>Images:</h4>
		<table class="table table-bordered">
			<tr>
				<th width="70%">Preview</th>
				<th width="30%">Actions</th>
			</tr>

			@foreach($images as $image)
			<tr>
				<td>
					<div class="thumbnail" style="width: 200px;">
						<img width="200px" src="{{URL::to('data/previewimage/'.$image->id)}}">
					</div>
				</td>
				<td>
					<a href="{{URL::to('projects/deletefile/'.$image->id)}}" class="btn btn-danger"><i class="icon-trash"> </i> Delete</a>
					@if ($image->id != $project->mainimage)
					<a href="{{URL::to('projects/makedefault/'.$image->id)}}" class="btn btn-success"><i class="icon-globe"> </i> Make Default</a>
					@endif
				</td>
			</tr>
			@endforeach
		</table>


		<h4>Files:</h4>
		<table class="table table-bordered">
			<tr>
				<th width="70%">Preview</th>
				<th width="30%">Actions</th>
			</tr>

			@foreach($downloads as $download)
			<tr>
				<td>
					<a href="{{URL::to('download/get/'.$download->id)}}">{{$download->title}}</a>
				</td>
				<td>
					<a href="{{URL::to('projects/deletefile/'.$download->id)}}" class="btn btn-danger"><i class="icon-trash"> </i> Delete</a>
					@if ($download->id != $project->maindownload)
					<a href="{{URL::to('projects/makedefault/'.$download->id)}}" class="btn btn-success"><i class="icon-globe"> </i> Make Default</a>
					@endif
				</td>
			</tr>
			@endforeach
		</table>
		
		<br />

		{{ Form::open_for_files('projects/editfiles', 'POST')}}
		<input type="hidden" name="modid" id="modid" value="{{$modid}}">
		{{ Form::label('file', 'Upload a new file') }}
		<div class="fileupload fileupload-new" data-provides="fileupload">
		  <div class="input-append">
		    <div class="uneditable-input span3"><i class="icon-file fileupload-exists"></i> <span class="fileupload-preview"></span></div><span class="btn btn-file"><span class="fileupload-new">Select file</span><span class="fileupload-exists">Change</span><input type="file" id="file" name="file"/></span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
		  </div>
		</div>
		{{ Form::submit('Upload!', array('class' => 'btn btn-success')) }}
		{{ Form::close() }}
	</div>
@endsection