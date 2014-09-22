<legend>Actions</legend>

<p>Actions are separate functions of the API. These functions are what developers call to retrieve information. 
	Some require data to be passed some do not. For example, 
	the <a href="{{URL::to('docs/api/action_authentication')}}"><i class="icon-lock"></i> Authentication</a> functions
	require you to pass a username and password, but retrieving a list of projects does not.</p>

<legend></legend><h4>Request Format</h4>
<p>
Requests are made by doing the following:
<ol>
	<li>Creating an array of request data</li>
	<li>Encoding that array into a JSON format</li>
  <li>Encrypting the data and converting to Base64 (IE: <a href="http://www.php.net/manual/en/function.base64-encode.php">base64_encode()</a> in PHP)</li>
  <li>Encoding the encrypted string into Base64 once again to make the data safe for URL passing</li>
	<li>Submitting that to the API</li>
</ol>
</p>

<legend></legend><h4>URL Scheme</h4>
<p>
When submitting a request ot the API, you must conform to a URL scheme. Depending on whether you want an XML 
or JSON response, the scheme is slightly different
<pre class="prettyprint">{{URL::to('api/{RESPONSE_TYPE}/{API_KEY}/{REQUEST_DATA}')}}</pre>

<dl class="dl-horizontal">
  <dt>RESPONSE_TYPE</dt>
  <dd>This is the type of data format you wish to receive back. The currently accepted parameters are "xml" or "json"</dd>
  <dt>API_KEY</dt>
  <dd>Your API key (See <a href="{{URL::to('docs/api/encryption')}}"><i class="icon-lock"></i> Encryption</a>)</dd>
  <dt>REQUEST_DATA</dt>
  <dd>The encrypted JSON data you are passing to the API. It should be encrypted with your <strong>encryption key</strong>
  	given to you when you requested an API key.</dd>
</dl>

</p>

<legend></legend><h4>Request Data</h4>

When sending request data, it should be structured as follows (in JSON):

<pre class="prettyprint lang-js">
{
   "action":"login",
   "data":{
      "username":"test",
      "password":"pass"
   }
}
</pre>

<p>The request consists of 2 main parts, the "action" and the "data". The "action" is the name of the functions 
	in the API to be called (See <a href="{{URL::to('docs/api/actions-home')}}"><i class="icon-globe"></i> Actions Overview</a> 
	for a list of all actions). The "data" section is any parameters that are to be passed to that action.
</p>

<p>
In the above example, you can see the "login" action is called, and it requires 2 parameters, the "username" and "password".
From there, the API will return it's data.
</p>


