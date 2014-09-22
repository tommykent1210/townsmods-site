<legend>Samples</legend>

<p>The following are sample scripts for interfacing with the TownsMods API. You can read more about actions on the
<a href="{{URL::to('docs/api/actions')}}"><i class="icon-screenshot"></i> Actions</a> page.</p>

<div class="alert alert-success">
  <strong>NOTE:</strong> All of the samples here use the <a href="{{URL::to('docs/api/encryption#crypter')}}">Example Encrypter Class</a> for encryption.
</div>  
</div>

<div class="well well-small">
  <h4>Basic Request</h4>
  <p>This is just a basic request for user login. If the login is correct, the API should return the session variable.</p>
  <legend></legend>

  <pre class="prettyprint lang-php linenums">
    $api_url = "{{URL::to('/api/json')}}";
    $api_key = "4NgM4ZHMdfg2NV9dJsJ20fhylAQo5XXx";
    $api_encryption_key = "IQGs6vehsadfghdjjhr76Lm5fsHM5rP9";

    $requestData = array(
            "action" => "auth_login",
            "data" => array(
                "username" => 'testuser',
                "password" => 'MyPaSsWoRd'
                )
            );

    $data_string = base64_encode(Encrypter::encrypt(json_encode($requestData), $api_encryption_key));

    $api_url .= '/'.$api_key.'/'.$data_string;
    $result = file_get_contents($url); 

    echo $result;
  </pre>

  <br />
  <strong>Expected result:</strong>
  <pre class="prettyprint lang-js">{"result":"1","userid":"26","session":"20Q7jFh3kT1zeMdvHb0lCyDEUIQTS6D4"}</pre>

  <p>From there, the result would be passed through <a href="php.net/manual/en/function.json-decode.php">json_decode()</a> to be turned into a PHP array. Then the elements of
    that array could be used at will. This would usually include storing the session variable for later requests to the
    API that required authentication.</p>
</div>



