@layout('template')

@section('head')

<script type="text/javascript">
$(document).ready(function() {
    $(".imgLiquid").imgLiquid();
});
</script>

<script type="text/javascript">
$(function ()  
{ $("#stats").popover();  
});
</script>

<meta name="Description" content="{{Core::trimDescription($project->description, 150)}}">

@endsection

@section('title')
Project: {{$project->title}}
@endsection

@section('content')
    <div id="ReportModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="ReportModalLabel" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="ReportModalLabel">Report Mod</h3>
        </div>
        <div class="modal-body">
            <p>We take every report seriously. Please give us more information regarding the nature of the report.</p>
            {{ Form::open('projects/report') }}

                {{ Form::label('type', 'Report Reason:') }}
                {{ Form::select('type', array('0' => 'Mod is spam', '1' => 'DMCA/Copyright Violation'), '0') }}

                {{ Form::label('message', 'Any other information (Crucial for DMCA/Copyright claims)') }}
                {{ Form::textarea('message', Input::old('message'), array('id' => 'message', 'name' => 'Description', 'class' => 'input-block-level')) }}
                
        </div>
        <div class="modal-footer">
            <input type="hidden" name="modID" value="{{$project->id}}">
                {{ Form::submit('Report!', array('class' => 'btn btn-danger')) }}
            {{ Form::close() }}
            <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        </div>
    </div>
    @if ($project->active == 0)
    <div class="alert alert-danger">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <strong>Warning!</strong> This mod has been disabled by an admin.</div>

    @endif
	<div class="well well-small">
            <legend>{{$project->title}} - v{{$project->version}}
                <div class="pull-right">
                        @if (Auth::check()) 
                                <a href="#ReportModal" role="button" class="btn btn-danger" data-toggle="modal"><i class="icon-flag"></i> Report</a>
                                @if($project->authorid == Auth::user()->id || Auth::user()->usergroup == 4)
                                <a href="{{URL::to('projects/edit/'.$project->id)}}" class="btn btn-warning"><i class="icon-pencil"></i> Edit Project</a>
                                <a href="{{URL::to('projects/delete/'.$project->id)}}" class="btn btn-danger"><i class="icon-trash"></i> Delete Project</a>
                                @endif
                                @if($project->authorid != Auth::user()->id)
                                @if(DB::table('likes')->where('uid', '=', Auth::user()->id)->where('modid', '=', $project->id)->count() > 0)
                                <a href="{{URL::to('projects/unlike/'.$project->id)}}" class="btn btn-info"><i class="icon-star" style="color: #E0E01B"> </i> Liked</a>
                                @else
                                <a href="{{URL::to('projects/like/'.$project->id)}}" class="btn btn-info"><i class="icon-star"> </i> Like</a>
                                @endif

                                @endif
                        @endif
                </div>
            </legend>

                <div id="preview" class="carousel slide" style="min-height: 300px; background-color:#000000;">
                        
                        <!-- Carousel items -->
                        <div class="carousel-inner" id="carousel-inner" name="carousel-inner">
                        @for ($i = 0; $i < count($previewImages); $i++)
                                @if($i == 0)
                                <div class="item active imgLiquid" style="width:100%; height:600px;"data-imgLiquid-fill="false" data-imgLiquid-horizontalAlign="center" data-imgLiquid-verticalAlign="center">
                                @else
                                <div class="item imgLiquid" style="width:100%; height:600px;"data-imgLiquid-fill="false" data-imgLiquid-horizontalAlign="center" data-imgLiquid-verticalAlign="center">
                                @endif
                                        <img  src="{{URL::to('cdn/'.$previewImages[$i]->contenturl)}}" alt="">
                                </div>
                        @endfor
                        </div>
                        <!-- Carousel nav -->
                        <a class="carousel-control left" href="#preview" data-slide="prev">&lsaquo;</a>
                        <a class="carousel-control right" href="#preview" data-slide="next">&rsaquo;</a>
                </div>
                @if ($project->supportedversion != Config::get('townsmods.currenttownsversion') && intval(substr($project->supportedversion,0 ,2)) < 12 && $project->supportedversion != 0)
                <div class="alert alert-danger">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                  <strong>Warning!</strong> We aren't sure if this mod will be fully compatible with the current version of Towns. Use this mod at your own risk.
                </div>

                @endif
                @if ($project->modloadercompatible != 1 && $project->type == 0 )
                <div class="alert">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                  <strong>Warning!</strong> The mod author has stated that this mod is not compatible with the Integrated modloader introduced in v12 of Towns. 
                  You may have to manually edit some files, or use another type of modloader to install this mod. 
                  The author should have left instuctions for this in the mod file.
                </div>

                @endif
                <div class="alert alert-info">
                    @if($project->supportedversion == 0)
                    This {{$typename}} is built for all versions of Towns: 
                    @else
                    This {{$typename}} is built for v{{$project->supportedversion}} of Towns: 
                    @endif
                    
                    <a href="{{URL::to('projects/downloads/'.$project->id)}}" class="btn btn-info"><i class="icon-arrow-down"></i> Downloads</a>
                    <a id="stats" name="stats" class="btn btn-info" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="<small>Project Views: {{$project->views}}<br />Project Downloads: {{$totalDownloads}}<br />Project Likes: {{DB::table('likes')->where('modid', '=', $project->id)->count()}}<br />Upload Date: {{$project->uploadeddate}}<br />Last Updated: {{$project->updateddate}}</small>" title="" data-original-title="Stats"><i class="icon-bar-chart"></i> Stats</a>  
                    @if($project->supporturl != "")
                    <a href="{{$project->supporturl}}" target="_blank" class="btn btn-info"><i class="icon-question-sign"></i> Get Support</a>
                    @endif
                </div>
                <table class="table table-condensed">
                        <tr>
                                <td>Uploaded by <a href="{{URL::to('profile/view/'.$user->id)}}">{{$user->username}}</a></td>
                        </tr>
                        <tr>
                                <td>
                                        <br />
                                        <p>{{BBCode::parse($project->description)}}</p>

                                        <br />
                                        @if ($project->changelog != "") 
                                        <legend><small>Changelog:</small></legend>
                                        <p>{{BBCode::parse($project->changelog)}}</p>
                                        @endif
                                </td>
                        </tr>
                </table>



	</div>
@endsection