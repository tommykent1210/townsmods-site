@layout('template')

@section('head')
{{ Editor::loadEditorJS() }}
@endsection

@section('title')
Edit Project
@endsection

@section('content')
	<div class="alert alert-warning">
 			<strong>Looking to edit files?</strong> Please click the following button to edit files. Warning: no changes on this page will be saved! <a href="{{URL::to('projects/editfiles/'.$modid)}}" class="btn btn-warning">Edit Files</a>
	</div>
	
	<div class="well well-small">

		<legend>Edit Project</legend>
		
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
		{{ Form::open_for_files('projects/edit', 'POST')}}
		<input type="hidden" name="modid" id="modid" value="{{$modid}}">
		{{ Form::label('projecttitle', 'Project Title:') }}
		{{ Form::text('projecttitle', Input::old('projecttitle', $old->title), array('id' => 'projecttitle', 'name' => 'projecttitle', 'class' => 'input-block-level')) }}


		{{ Form::label('message', 'Description (You may use BBCode):') }}
		{{ Editor::outputEditor() }}
		<br />
		{{ Form::textarea('message', Input::old('message', $old->description), array('id' => 'message', 'name' => 'Description', 'class' => 'input-block-level')) }}

		{{ Form::label('changelog', 'Changelog (old version information):') }}
		{{ Form::textarea('changelog', Input::old('changelog', $old->changelog), array('id' => 'changelog', 'name' => 'Changelog', 'class' => 'input-block-level')) }}

		{{ Form::label('type', 'Upload Type:') }}
		{{ Form::select('type', array('0' => 'Mod', '1' => 'Save', '2' => 'Buried Town'), Input::old('type', $old->type)) }}


		<label class="checkbox" for="modloadercompatible">Modloader Compatible?
		{{ Form::checkbox('modloadercompatible', '1')}}
		</label>
		
		{{ Form::label('version', 'Project Version (EG: "1.0.3"):') }}
		{{ Form::text('version', Input::old('version', $old->version)) }}

		{{ Form::label('supporturl', 'Support URL (forum or website):') }}
		{{ Form::text('supporturl', $supportURL) }}

		{{ Form::label('supportedversions', 'Supported Towns Version:') }}
		{{ Form::select('supportedversions', Config::get('townsmods.versions')) }}

		<br />
		<br />
		{{ Form::submit('Edit!', array('class' => 'btn btn-success')) }}
		{{ Form::close() }}
	</div>
@endsection