@layout('template')

@section('head')
{{ Editor::loadEditorJS() }}
@endsection

@section('title')
Upload
@endsection

@section('content')
	<div class="well well-small">

		<legend>Upload Project</legend>
		
		@if (Session::get('has_errors') == true)
		<div class="alert alert-error">
 			<strong>Oops!</strong> Something went wrong there:
 			<ul>
		@foreach ($errors->all() as $error)
			<li>{{$error}}</li>
		@endforeach
			</li>
		</div>
		<br />
		@endif
		{{ Form::open_for_files('projects/upload', 'POST')}}
		{{ Form::label('projecttitle', 'Project Title:') }}
		{{ Form::text('projecttitle', Input::old('projecttitle'), array('id' => 'projecttitle', 'name' => 'projecttitle', 'class' => 'input-block-level')) }}


		{{ Form::label('message', 'Description (You may use BBCode):') }}
		{{ Editor::outputEditor() }}
		<br />
		{{ Form::textarea('message', Input::old('message'), array('id' => 'message', 'name' => 'Description', 'class' => 'input-block-level')) }}


		{{ Form::label('changelog', 'Changelog (old version information):') }}
		{{ Form::textarea('changelog', Input::old('changelog'), array('id' => 'changelog', 'name' => 'Changelog', 'class' => 'input-block-level')) }}

		{{ Form::label('type', 'Upload Type:') }}
		{{ Form::select('type', array('0' => 'Mod', '1' => 'Save', '2' => 'Buried Town'), '0') }}


		<label class="checkbox" for="modloadercompatible">Modloader Compatible?
		{{ Form::checkbox('modloadercompatible', '1')}}
		</label>
		
		{{ Form::label('version', 'Project Version (EG: "1.0.3"):') }}
		{{ Form::text('version', Input::old('version')) }}

		{{ Form::label('supporturl', 'Support URL (forum or website):') }}
		{{ Form::text('supporturl', Input::old('supporturl')) }}

		{{ Form::label('supportedversions', 'Supported Towns Version:') }}
		{{ Form::select('supportedversions', Config::get('townsmods.versions')) }}


		{{ Form::label('previewimage', 'Main preview Image (You can add more later!):') }}
		<div class="fileupload fileupload-new" data-provides="fileupload">
		  <div class="fileupload-preview thumbnail" style="width: 200px; height: 150px;"></div>
		  <div>
		    <span class="btn btn-file"><span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span><input type="file" id="previewimage" name="previewimage" /></span>
		    <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
		  </div>
		</div>

		{{ Form::label('maindownload', 'Main download (Must be a .zip):') }}
		<div class="fileupload fileupload-new" data-provides="fileupload">
		  <div class="input-append">
		    <div class="uneditable-input span3"><i class="icon-file fileupload-exists"></i> <span class="fileupload-preview"></span></div><span class="btn btn-file"><span class="fileupload-new">Select file</span><span class="fileupload-exists">Change</span><input type="file" id="maindownload" name="maindownload"/></span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
		  </div>
		</div>

		{{ Form::submit('Upload!', array('class' => 'btn btn-success')) }}
		{{ Form::close() }}
	</div>
@endsection