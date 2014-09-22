@layout('template')

@section('title')
Buried Towns
@endsection

@section('content')
  <div class="well">
    <legend>Buried Towns</legend>

    <h4>What is this system all about?</h4>
	<p>	The bury system is a feature that enables players to indirectly interact with each other by burying their town at any stage of their game and letting other players explore and conquer those buried towns.
		As a new player starts a game (any of the maps) the buried town from other player is "injected" into the dungeons and with a few become an integral and challenging part of the dungeon.</p>
 	
 	<legend></legend>
	<h4>How do I share or get other people buried map?</h4>
	<p>Right now, the players will have to swap buried maps files between themselves manualy, but, in the near future the developers may implement a way to make that a seamless process thus further increasing the unexplored atmosphere of this feature.</p>
 
 	<legend></legend>
 	<h4>Where do I get buried towns?</h4>
 	<p>Getting buried towns is easy. You have three options:</p>

 	<ul class="inline">
	  <li><a href="{{URL::to('projects/buried')}}" class="btn btn-mini">View user uploaded buried towns</a></li>
	  <li><a href="{{URL::to('download/get/1')}}" class="btn btn-mini btn-success">Download the official default bundle</a></li>
	  <li><a href="#bury" class="btn btn-mini">Bury your own towns!</a></li>
	</ul>

	<legend></legend>
 	<h4>How do I set Townsmods.net to be my server in towns v13+?</h4>
 	<p>Setting Townsmods.net as your server in towns is very easy. It allows the game to automatically download a random town from our buried town list, giving you a surprise every time! To set it as your main server simply click "Servers" > "Add server" and type: <code>townsmods.net/api/bury</code>. When you next start a map, you will be given the option of choosing townsmods.net as your server! Simple!</p>

	<legend></legend>
 	<h4><a id="bury" style="text-decoration: none;">How do I bury towns?</a></h4>
 	<p>You can bury any of your own towns at any point. Simply hit ESCAPE and click "Bury this town". This will generate a zip file for your buried town.</p>

	<legend></legend>
 	<h4>Where do I find my buried town zips?</h4>
 	<p>You can find you zips in the following locations:</p>
 	<ul>
 		<li>Windows XP - C:\Documents and Settings\{USERNAME}\.towns\bury</li>
 		<li>Windows Vista/7/8 - C:\Users\{USERNAME}\.towns\bury</li>
 		<li>Mac OSX - /Users/{USERNAME}/.towns/bury</li>
 	</ul>
 	<p><strong>Note:</strong> You will need to click "Go" <i class="icon-angle-right"></i> "Go To Folder...", then type the path in Finder in OSX as the .towns folder is hidden.</p>
  </div>


@endsection