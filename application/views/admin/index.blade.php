@layout('template')

@section('title')
Admin Index
@endsection

@section('content')
  <div class="well">
    <legend>Admin Index</legend>

    <table class="table table-bordered">
    	<th>Stat</th>
    	<th>Value</th>

    	<tr>
    		<td>Users</td>
    		<td>{{DB::table('users')->count()}}</td>
    	</tr>
    	<tr>
    		<td>Active Users</td>
    		<td>{{DB::table('users')->where('active', '=', '1')->count()}}</td>
    	</tr>
    	<tr>
    		<td>Mods</td>
    		<td>{{DB::table('mods')->where('active', '=', '1')->count()}}</td>
    	</tr>
        <tr>
            <td>Downloads</td>
            <td>{{DB::table('content')->sum('downloads');}} ({{DB::table('mods')->where('mods.type', '=', 2)->join('modContent', 'modContent.modid', '=', 'mods.id')->join('content', 'content.id', '=', 'modContent.contentid')->sum('content.downloads');}} Buried)</td>
        </tr>
    	<tr>
    		<td>Reports</td>
    		<td><a href="{{URL::to('admin/reports')}}">{{DB::table('reports')->count()}} ({{DB::table('reports')->where('closed', '=', '0')->count()}} open)</a></td>
    	</tr>
    </table>

  </div>


@endsection