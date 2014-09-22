@layout('template')

@section('title')
Oops, the page doesn't exist!
@endsection

@section('content')
<div class="hero-unit">
	<?php $messages = array('We need a map.', 'I think we\'re lost.', 'We took a wrong turn.'); ?>
	<h1><i class="icon-warning-sign icon-3x pull-right"></i><?php echo $messages[mt_rand(0, 2)]; ?></h1>
	
	<p>Something didn't work quite right there. An error report has been generated and the administrators have been informed. We apologise for any inconvenience.</p>
	<p>
		<a class="btn btn-success" href="{{URL::to('/')}}"><i class="icon-home icon-white"> </i>Home</a>
	</p>
</div>
@endsection