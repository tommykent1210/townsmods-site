@layout('template')

@section('head')
{{HTML::style('css/custom-theme/jquery-ui-1.10.2.custom.min.css')}}
<script type="text/javascript">
jQuery(document).ready(function($){
	$('#author').autocomplete({source:'{{URL::to('data/user')}}', minLength:2});
});
</script>

<script type="text/javascript">
jQuery(document).ready(function($){
	$("#advancedSearch").click(function () {
	$("#advSearch").toggle("slow");
	});
}); 
	
</script>
@endsection

@section('title')
{{$title}}
@endsection

@section('content')
	<div class="well well-small">

		<legend>{{$title}}
			<div class="pull-right">
				@if (Auth::check() && (Auth::user()->usergroup == 2 ||Auth::user()->usergroup == 4 ))
				  <a href="{{URL::to('projects/upload')}}" class="btn btn-success">New Project</a>
				@endif
				<a id="advancedSearch" class="btn btn-success"><i class="icon-search icon-white"> </i> Search <i class="icon-double-angle-down icon-white"></i></a>
				
			</div>
		</legend>
		<div id="advSearch" style="display: none">
			{{Form::open('projects/search', 'POST', array('class' => 'form-horizontal'))}}
				{{ Form::label('keywords', 'Keywords:') }}
				{{ Form::text('keywords', Session::get('input_keywords'), array('class' => 'span8', 'placeholder' => 'Keywords')) }}
				<br />
				<br />
				{{ Form::label('author', 'Author:') }}
				{{ Form::text('author', Session::get('input_author'), array('class' => 'span8', 'placeholder' => 'Author')) }}
				<br />
				<br />
				{{ Form::label('type', 'Type:') }}
				{{ Form::select('type[]', array('0' => 'Mod', '1' => 'Save', '2' => 'Buried Town'), Session::get('input_type', '0'), array('multiple' => 'multiple')) }}
				<br />
				<br />
				<label class="checkbox" for="modloader">Modloader Only?
					{{ Form::checkbox('modloader', '1')}}
				</label>
				
				{{ Form::label('supportedversions[]', 'Supported Towns Version:') }}
				{{ Form::select('supportedversions[]', Config::get('townsmods.versions'), Session::get('input_supportedversions', '0'), array('multiple' => 'multiple')) }}
				<br />
				<br />
				{{ Form::label('sortby', 'Sort By:') }}
				{{ Form::select('sortby', array('title' => 'Title','author' => 'Author','uploadDate' => 'Upload Date','updatedDate' => 'Updated Date','views' => 'Views'), Session::get('input_sortby', '0')) }}
				<br />
				<br />
				{{ Form::label('sortorder', 'Sort Order:') }}
				{{ Form::select('sortorder', array('asc' => 'Ascending','desc' => 'Descending'), Session::get('input_sortorder', '0')) }}
				<br />
				<br />
				<button type="submit" class="btn btn-success"><i class="icon-search icon-white"> </i> Search</button>
			{{Form::close()}}


			<legend></legend>
		</div>
		@if($title == "All Buried Towns")
		<div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Looking for information?</strong> We have a page outlining the buried towns feature introduced in v12 of Towns, as well as download links to the official bundle here:<br />
            <a href="{{URL::to('about/buried')}}" class="btn btn-small btn-success">About: Buried Towns</a>
        </div>
		@endif

		@foreach ($projects->results as $project)
        <table>
        	<tr>
        		<td width="150px"><img alt="{{$project->title}}" src="{{URL::to('data/previewimage/'.$project->mainimage)}}.png" style="width:130px; height:130px;"></td>
        		@if($project->supportedversion == 0)
        		<td><h4><span class="muted">[All]</span> <a href="{{URL::to('projects/view/'.$project->modid)}}">{{$project->title}}</a> <small>- By: <a href="{{URL::to('profile/view/'.$project->id)}}">{{$project->username}}</a></small></h4>
	            @else
				<td><h4><span class="muted">[v{{$project->supportedversion}}]</span> <a href="{{URL::to('projects/view/'.$project->modid)}}">{{$project->title}}</a> <small>- By: <a href="{{URL::to('profile/view/'.$project->id)}}">{{$project->username}}</a></small></h4>
	            @endif
	            <p><small>{{Core::trimDescription(BBCode::parse($project->description), 300)}}</small></p>
	            <p><a href="{{URL::to('projects/view/'.$project->modid)}}" class="btn btn-primary btn-mini">View Project</a></p></td>
        	</tr>
        </table>
        <legend></legend>
        @endforeach
        {{ $projects->links() }}

	</div>
@endsection