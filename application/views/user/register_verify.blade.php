@layout('template')

@section('title')
	Success!
@endsection

@section('content')
    @if ($valid == true)
    	@if ($expired == false)
		<div class="alert alert-success alert-block">
			<h4>Success!</h4>
				You have successfully verified your email address. You now have full access to all of the features provided by TownsMods.net
			<br />
			<br />
			@if (Auth::check())
				<a href="{{URL::to('/')}}" class="btn btn-success"><i class="icon-home icon-white"> </i> Click here to return to the Homepage</a>
			@else
				<a href="{{URL::to('user/login')}}" class="btn btn-success"><i class="icon-lock icon-white"> </i> Click here to login</a>
			@endif
		</div>
		@else
		<div class="alert alert-warning alert-block">
		  <h4>Error!</h4>
		  The verification link you clicked seems to be have expired! Please click the button below to resend your verificaiton email.
		  <br />
		  <br />
		  <a href="{{URL::to('ucp/resend_verify')}}" class="btn btn-warning"><i class="icon-home icon-white"> </i> Click here to get a new Verificaiton Email</a>
		</div>

		@endif
    @else
    <div class="alert alert-error alert-block">
	  <h4>Error!</h4>
	  The verification link you clicked seems to be incorrect! This may be because you typed the URL incorrectly, or the email address has already been verified.
	  <br />
	  <br />
	  <a href="{{URL::to('/')}}" class="btn btn-danger"><i class="icon-home icon-white"> </i> Click here to return to the Homepage</a>
	</div>

    @endif

@endsection