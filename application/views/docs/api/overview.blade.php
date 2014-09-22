<legend>Overview</legend>

<h4>Introduction</h4>
<p>The TownsMods API allows third party sites to integrate Townsmods.net features with their websites and applications. 
The aim is to provide an easy, reliable API for developers to connect to, and to increase the usefulness of TownsMods.net</p>

<h4>Planned Features</h4>
<p>The API is currently in very early development, with many features unimplemented. These include:
<ul class="icons-ul">
  <li><i class="icon-li icon-ok"></i>Authentication</li>
  <li><i class="icon-li icon-ok"></i>Remote File Upload</li>
  <li><i class="icon-li icon-ok"></i>Profile sharing</li>
  <li><i class="icon-li icon-ok"></i>&hellip;and much more!</li>
 </ul>
</p>


<h4>How does it work?</h4>
<p>The API utilises two major web technologies - XML and JSON. Requests to the API are made by forming a JSON array, 
	and then submitted to the API. From there, you may request either a JSON response or an XML response. To make requests
you require an API key (which can be obtained from <a href="{{URL::to('user/ucp/api')}}"><i class="icon-dropbox"></i> here</a>), 
and an encryption key.</p>

<h4>Encryption</h4>
<p>All requests and responses made and received from the API are encrypted. When you generate an API key, you will also be given 
	an encryption key. This MUST remain a secret. The use of encryption prevents prying eyes from intercepting data, such as user 
	passwords, as they are passed to the API to be checked. For more information, please see 
	the <a href="{{URL::to('docs/api/encryption')}}"><i class="icon-lock"></i> Encryption</a> section of the API documentation.</p>

