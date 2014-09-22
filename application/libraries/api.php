<?php

/**
* 
*/
class API
{
	
	public static function validateAPIKey($apikey = "") {
		if ($apikey != "" && DB::table('api')->where('apikey', '=', $apikey)->count() > 0) {
			return true;
		} else {
			return false;
		}
	}



	public static function outputAPIAction($query = NULL, $apikey = NULL, $format = 'json') {
		if ($query == NULL) {
			return "invalid query";
		} else if ($apikey == NULL || API::validateAPIKey($apikey) == false) {
			return "Unauthorized Accesss";
		} else {
			//decrypt the query
			$APIData = DB::table('api')->where('apikey', '=', $apikey)->first();
			$encryptionKey = $APIData->encryptionkey;
			//TODO encryption/decryption
			

			try {
				$queryData = json_decode(Encrypter::decrypt($query, $encryptionKey), true);
				API::removeExpiredSessions();
				$res = array();
				switch ($queryData['action']) {

						//authentication api functions
						case 'auth_login':

							$username = $queryData['data']['username'];
							$password = $queryData['data']['password'];

							if (DB::table('users')->where('username', '=', $username)->count() > 0) {
								$email = DB::table('users')->where('username', '=', $username)->first();
								$userdata = array(
									'username' => $email->email,
									'password' => $password
									);

								if (Auth::attempt($userdata)) {
									$user = DB::table('users')->where('email', '=', $username)->or_where('username', '=', $username)->first();
									$sessionCode = Core::generateRandomString(32);
									$expiry = Core::unix_time() + (15 * 60);
									DB::table('sessions')->insert(array('userid' => $user->id, 'sessioncode' => $sessionCode, 'expirydate' => $expiry));
									$res = array('result' => '1', 'userid' => $user->id, 'session' => $sessionCode);
								} else {
									$res = array('result' => '0', 'userid' => '0', 'session' => '0');
								}
								
							} else {
								$res = array('result' => '0', 'userid' => '0', 'session' => '0');
							}
							break;

						case 'auth_login_email':
							$email = $queryData['data']['email'];
							$password = $queryData['data']['password'];
							$userdata = array(
								'email' => $email,
								'password' => $password
								);

							if (Auth::attempt($userdata)) {
								$user = DB::table('users')->where('email', '=', $email)->first();
								$sessionCode = Core::generateRandomString(32);
								$expiry = Core::unix_time() + (15 * 60);
								DB::table('sessions')->insert(array('userid' => $user->id, 'sessioncode' => $sessionCode, 'expirydate' => $expiry));
								$res = array('result' => '1', 'userid' => $user->id, 'session' => $sessionCode);
							} else {
								$res = array('result' => '0', 'userid' => '0', 'session' => '0');
							}
							break;

						case 'auth_logout':

							$session = $queryData['data']['session'];
							$userid = $queryData['data']['userid'];

							if (DB::table('sessions')->where('userid', '=', $userid)->where('sessioncode', '=', $session)->count() > 0) {
								DB::table('sessions')->where('userid', '=', $userid)->where('sessioncode', '=', $session)->delete();
								$res = array('result' => '1');								
							} else {
								$res = array('result' => '0');
							}
							break;

						//profile api functions
						case 'profile_get':
							$userid = $queryData['data']['userid'];
							if (DB::table('users')->where('id', '=', $userid)->count() > 0) {
								$userInfo = DB::table('users')->where('id', '=', $userid)->first(array('username', 'registrationdate', 'rank', 'xp'));
								$res = array('username' => $userInfo->username, 'registration_date' => $userInfo->registrationdate, 'rank' => Core::formatRank($userInfo->rank), 'xp' => $userInfo->xp);
							} else {
								$res = array('username' => 'NULL', 'registration_date' => '0', 'rank' => 'NULL', 'xp' => '0');
							}
							break;

						case 'profile_get_id':
							$username = $queryData['data']['username'];
							if (DB::table('users')->where('username', '=', $userid)->count() > 0) {
								$userInfo = DB::table('users')->where('username', '=', $username)->first(array('id'));
								$res = array('id' => $userInfo->id);
							} else {
								$res = array('id' => '0');
							}
							break;						

						case 'profile_get_likes':
							$userid = intval($queryData['data']['userid']);
							$count = intval($queryData['data']['num']);
							if (DB::table('users')->where('id', '=', $userid)->count() > 0) {
								$likes = array();
								if ($count == 0) {
									$likeData = DB::table('likes')->where('uid', '=', $userid)->get();
								} else {
									$likeData = DB::table('likes')->where('uid', '=', $userid)->take($count)->get();
								}
								
								if (isset($likeData) && $likeData != array()) {
									foreach ($likeData as $like) {
										array_push($likes, $like->modid);
									}
								} else {
									$likes = array('0');
								}

								$res = array('likes' => $likes);
							} else {
								$res = array('likes' => '0');
							}
							break;



						//project api functions
						case 'project_info':
							$projectid = $queryData['data']['id'];

							if (DB::table('mods')->where('id', '=', $projectid)->where('active', '=', '1')->count() > 0) {
								$projectinfo = DB::table('mods')->where('id', '=', $projectid)->where('active', '=', '1')->first();
								$res = array(
									'author' => $projectinfo->authorid,
									'title' => $projectinfo->title,
									'description' => $projectinfo->description,
									'changelog' => $projectinfo->changelog,
									'version' => $projectinfo->version,
									'supportedVersion' => $projectinfo->supportedversion,
									'type' => $projectinfo->type,
									'updatedDate' => $projectinfo->updateddate,
									'uploadedDate' => $projectinfo->uploadeddate,
									'modloaderCompatible' =>$projectinfo->modloadercompatible,
									'views' => $projectinfo->views,
									'supportURL' => $projectinfo->supporturl
									);
							} else {
								$res = array(
									'author' => '0',
									'title' => 'null',
									'description' => 'null',
									'changelog' => 'null',
									'version' => '0',
									'supportedVersion' => 'null',
									'type' => 'null',
									'updatedDate' => '0',
									'uploadedDate' => '0',
									'modloaderCompatible' => 'null',
									'views' => '0',
									'supportURL' => 'null'
									);
							}																			
							break;

						default:
							$res = array('test' => 'ok');
							# code...
							break;
					}	

				if ($format == "json") {
					return Response::json($res);
				} else {
					return API::outputXML($res);
				}
			} catch (Exception $e) {
				Log::info($e);
				return 'error <br />'.var_dump($e);
			}
		}
	}

	public static function removeExpiredSessions() {
		$time = time();
		DB::table('sessions')->where('expirydate', '<', $time)->delete();
	}


	public static function outputXML($arr) {

		// creating object of SimpleXMLElement
		$xml_init = new SimpleXMLElement("<?xml version=\"1.0\"?><response></response>");

		// function call to convert array to xml
		API::array_to_xml($arr,$xml_init);


		//saving generated xml file
		return Response::make($xml_init->asXML(), 200, array('content-type' => 'text/plain'));

	}

	// function defination to convert array to xml
	public static function array_to_xml($arr, &$xml_init) {
	    foreach($arr as $key => $value) {
	        if(is_array($value)) {
	            if(!is_numeric($key)){
	                $subnode = $xml_init->addChild("$key");
	                API::array_to_xml($value, $subnode);
	            }
	            else{
	                API::array_to_xml($value, $xml_init);
	            }
	        }
	        else {
	            $xml_init->addChild("$key","$value");
	        }
	    }
	}




	

}

?>