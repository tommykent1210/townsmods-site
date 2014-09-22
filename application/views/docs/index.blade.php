@layout('template')

@section('title')
Documentation
@endsection

@section('content')
<div>
	<div class="span9 offset1">
		<div class="hero-unit">
			<h1>Welcome!</h1>
			<p>Welcome to the Documentation site for TownsMods.net. Here you can find documentation on the TownsMods 
			API (for developers only!) and also the game itself. You can also view modding documentation!</p>

		</div>
		<ul class="thumbnails">
			<li class="span3">
				<div class="thumbnail">
					<img data-src="holder.js/300x200" alt="">
					
					<p>
						<a href="#" class="btn btn-block btn-success disabled"><i class="icon-gamepad"></i> Game Docs</a>
					</p>
				</div>
			</li>
			<li class="span3">
				<div class="thumbnail">
					<img data-src="holder.js/300x200" alt="">
					
					<p>
						<a href="#" class="btn btn-block btn-success disabled"><i class="icon-edit"></i> Modding Docs</a>
					</p>
				</div>
			</li>
			<li class="span3">
				<div class="thumbnail">
					<img data-src="holder.js/300x200" alt="">
					
					<p>
						<a href="{{URL::to('docs/api')}}" class="btn btn-block btn-success"><i class="icon-dashboard"></i> API Docs</a>
					</p>
				</div>
			</li>
		</ul>

		<div class="alert alert-info">
			<strong>Want to help improve these Docs?</strong> You can help us add new pages and maintain the current ones by visiting our <a href="https://github.com/tommykent1210/townsmods" class="btn btn-info btn-small"><i class="icon-github"></i> GitHub</a>
		</div>
	</div>
	
</div>
@endsection