<legend>Getting Started</legend>

<h3>Requirements</h3>
<p>To use the API you must have the following:</p>
<ul>
	<li>An API Key (Which can be obtained <a href="{{URL::to('user/ucp/api')}}">here</a>)</li>
	<li>An Encryption key (You'll get one when you generate an API key)</li>
	<li>An application, whether it be web or dekstop based capable of interfacing using JSON</li>
</ul>

<legend></legend>

<div class="alert alert-success">
	<strong>NOTE:</strong> This documentation is written using PHP as the client side language. 
	Most modern programming languages support JSON, but you'll need to use external resources to 
	find out how to use them. We simply cannot document every single language!
</div>

<h3>Initial Setup</h3>

<h4>API Key and Encryption Key Generation</h4>
<p>When you visit the API section of your UCP, you will be given the option to generate a new API key. 
	Currently, there is a limit of 5 API keys per user account. </p>

<br />
<p>You can generate an API key on the following page: <a href="{{URL::to('user/ucp/api')}}">{{URL::to('user/ucp/api')}}</a> </p>
<p>The page will look similar to the following:
<ul class="thumbnails">
  <li class="span4">
  	<div class="thumbnail">
	    <a href="#" class="thumbnail">
	      <img src="{{URL::to('/static/img/ucp_api.png')}}" alt="API Keys">
	    </a>
	    <small><strong>Above:</strong> Your API key list and generate button</small>
	   </div>
  </li>
</ul>

<p>You will see a list of your currently generated API keys (if you have any), and the number of key generations remaining.
To generate a key, click the generate key button. From there you will be given a new <strong>API key</strong>, and <strong>Encryption Key</strong>.</p>