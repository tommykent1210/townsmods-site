<div class="well sidebar-nav">
	<ul class="nav nav-list">
	  <li class="nav-header">Messages</li>
	  <li><a href="{{URL::to('user/messages/send')}}"><i class="icon-edit"> </i> New Message</a></li>
	  <li><a href="{{URL::to('user/messages')}}"><i class="icon-envelope"> </i> Inbox</a></li>
	  <li><a href="{{URL::to('user/messages/sent')}}"><i class="icon-reply"> </i> Sent Messages</a></li>

	  <li class="divider"></li>
	  <li class="nav-header">User Control Panel</li>
	  <li><a href="{{URL::to('user/ucp/options')}}"><i class="icon-cogs"> </i> Options</a></li>
	  <li><a href="{{URL::to('user/ucp/security')}}"><i class="icon-lock"> </i> Security</a></li>
	  <li><a href="{{URL::to('user/ucp/api')}}"><i class="icon-dashboard"> </i> API Keys <span class="label label-info">Beta!</span></a></li>
	  
	</ul>
</div>