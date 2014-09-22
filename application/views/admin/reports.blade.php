@layout('template')

@section('title')
Reports
@endsection

@section('content')
  <div class="well">
    <legend>Reports</legend>

    <table class="table table-bordered">
    	<thead>
            <th>Mod</th>
        	<th>Message</th>
            <th>Reporter</th>
            <th>Action</th>
        </thead>
        <tbody>
            @foreach($reports as $report)
            @if($report->closed == 0)
            <tr class="error">
            @else
            <tr class="info">
            @endif
                <td>{{$report->modname}}</td>
                <td>{{Core::trimDescription($report->message,100)}}</td>
                <td>{{$report->reporter}}</td>
                <td><a href="{{URL::to('admin/viewreport/'.$report->id)}}" class="btn">View Report</a></td>
            </tr>
            @endforeach
        </tbody>
    	
    </table>

  </div>


@endsection