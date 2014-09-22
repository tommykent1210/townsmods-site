<?php
// application/controllers/account.php
class Api_Controller extends Base_Controller
{

    public $restful = true;
    

    public function get_bury($num = 10) {
        $buried = DB::table('mods')->where('mods.type', '=', '2')->join('users', 'mods.authorID', '=', 'users.id')->order_by(DB::raw('RAND()'))->take($num)->get(array('mods.id AS id', 'mods.title AS title', 'users.username AS author'));
        $content = View::make('api.buried')->with('files', $buried);
        return Response::make($content, 200, array('content-type' => 'text/plain'));
    }

    public function get_getbury($id = 0) {
        if ($id > 0) {
            $mod = DB::table('mods')->where('id', '=', $id)->first();
            if ($mod) {
                $file = DB::table('content')->where('id', '=', $mod->maindownload)->first();
                if ($file) {
                    $url = path('public').'/cdn/'.$file->contenturl;
                    DB::table('content')->where('id', '=', $file->id)->increment('downloads');
                    return Response::download($url, $file->title);
                } else {
                    echo 'file not found: '. $mod->maindownload;
                }
            } else {
                echo 'Mod not found: '.$id;
            }
        } else {
            echo 'invalid request';
        }
    }

    //query data must be passed as JSON array, then encrypted using server's public enc key, 
    //so it can be decrypted using server's pprivate enc key. Server encrypts data using user's public enc key
    //so it can be decrypted using user's private key.
    //query format: http://townsmods.net/api/json/APIKEYHERE/ENCRYPTEDJSONARRAY

    //returns an XML doc of the api data
    public function get_xml($apikey = NULL, $query = NULL) {
        
        
        if ($apikey == NULL || API::validateAPIKey($apikey) == false) {
            return "Unauthorized access";
        } else {
            if ($query == NULL) {
                return "No query Defined";
            } else {
                return API::outputAPIAction(base64_decode($query), $apikey, 'xml');
            }
        }
    }

    //returns a JSON array of data
    public function get_json($apikey = NULL, $query = NULL) {
        if ($apikey == NULL || API::validateAPIKey($apikey) == false) {
            return "Unauthorized access";
        } else {
            if ($query == NULL) {
                return "No query Defined";
            } else {
                             
                return API::outputAPIAction(base64_decode($query), $apikey, 'json');
            }
        }
    }


    //generate user api key
    public function post_generate() {
        if (Auth::check()) {
            if (DB::table('api')->where('userid', '=', Auth::user()->id)->count() < Config::get('townsmods.maxapikeys')) {
                //generate a new key
                $input = Input::get();
                $nickname = '';
                
                
                if (Input::has('nickname')) {
                    $nickname = $input['nickname'];
                } else {
                    $nickname = Core::generateRandomString(20);
                }
                

                $apikey = '';
                while ($apikey == '' || DB::table('api')->where('apikey', '=', $apikey)->count() > 0) {
                    $apikey = Core::generateRandomString(32);
                }
                
                $enckey = Core::generateRandomString(32);

                DB::table('api')->insert(array(
                    'userid' => Auth::user()->id,
                    'nickname' => $nickname,
                    'apikey' => $apikey,
                    'encryptionkey' => $enckey
                    ));

                return Redirect::to('user/ucp/api');
            } else {
                //too many keys
                Redirect::to('user/ucp/api');
            }
        } else {
            Redirect::to('user/ucp/api');
        }
    }

    public function get_test($username, $password) {
        $url = 'http://townsmods.net/api/json';
        $apikey = "4NgM4ZHMEsG2NV9dJsJ20fhylAQo5XXx";
        $key = "IQGs6vehsaW7xwdjjhr76Lm5fsHM5rP9";

        

        $requestData = array(
            "action" => "auth_login",
            "data" => array(
                "username" => 'tomkent',
                "password" => $password
                )
            );

        $data_string = base64_encode(Encrypter::encrypt(json_encode($requestData), $key));                                                                                   


        $url .= '/'.$apikey.'/'.$data_string;
        $result = file_get_contents($url);

        echo $data_string;
        echo "<br />";
        echo $result;
 
    }
     

}

?>