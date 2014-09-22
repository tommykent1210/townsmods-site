@layout('template')

@section('title')
View Report
@endsection

@section('content')
  <div class="well">
    <legend>Report</legend>

    <strong>Mod Name</strong>
    <p><a href="{{URL::to('projects/view/'.$report['modid'])}}">{{$report['modname']}}</a> - <small>{{$report['modstatus']}}</small></p>

    <legend></legend>
    <strong>Type:</strong>
    <p>{{$report['type']}}</p>
    <strong>Reporter:</strong>
    <p><a href="{{URL::to('profile/view/'.$report['reporterid'])}}">{{$report['reporter']}}</a></p>
    
    <legend></legend>
    <strong>Reason:</strong>
    <p>{{$report['message']}}</p>

    <legend></legend>
    <strong>Actions:</strong>
    <p><a href="{{URL::to('admin/disablemod/'.$report['modid'])}}" class="btn btn-warning">Disable Mod</a>
    @if($report['closed'] == 0)
    <a href="{{URL::to('admin/closereport/'.$report['reportid'])}}" class="btn btn-danger">Close Report</a>
    @endif
    </p>
  </div>


@endsection