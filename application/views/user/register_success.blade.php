@layout('template')

@section('title')
	Success!
@endsection

@section('content')
    <div class="alert alert-success alert-block">
	  <h4>Success!</h4>
	  You have successfully registered for a TownsMods account. To complete this process, please verify your email address by clicking the link sent to: "{{$email}}".

	  <br /><br />
	  <a href="{{URL::to('/')}}" class="btn btn-success"><i class="icon-home icon-white"> </i> Click here to return to the Homepage</a>
	</div>
@endsection