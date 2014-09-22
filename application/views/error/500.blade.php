@layout('template')

@section('title')
Oops, something went wrong!
@endsection

@section('content')
<div class="hero-unit">
	<?php $messages = array('Ouch.', 'Oh no!', 'Whoops!'); ?>

	<h1><i class="icon-warning-sign icon-3x pull-right"><?php echo $messages[mt_rand(0, 2)]; ?></h1>

	<h2>Server Error: 500 (Internal Server Error)</h2>

	<hr>

	<h3>What does this mean?</h3>

	<p>
		Something went wrong on our servers while we were processing your request.
		We're really sorry about this, and will work hard to get this resolved as
		soon as possible.
	</p>
	<p>
		<a class="btn btn-success btn-large" href="{{URL::to('/')}}"><i class="icon-home icon-white"> </i>Home</a>
	</p>
</div>
@endsection