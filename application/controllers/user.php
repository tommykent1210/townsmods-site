<?php
// application/controllers/account.php
class User_Controller extends Base_Controller
{

    public $restful = true;
    
    public function get_index()
    {
        return Redirect::to('user/ucp');        
    }

    public function get_ucp($page = "main")
    {
        $breadcrumbs = array(
            array('Home', '/'),
            array('User Control Panel', 'user/ucp')
            );
        Session::put('location', 'user/'.$page);
        if (Auth::check()) {
            $content  = "";
            switch ($page) {
                case 'security':
                    //display main user info
                    array_push($breadcrumbs, array('Security', 'user/ucp/security'));
                    $content = View::make('user.ucp.security');
                    break;
                
                case 'options':
                    //display main info
                    array_push($breadcrumbs, array('Options', 'user/ucp/options'));
                    $content = View::make('user.ucp.options');
                    break;

                case 'api':
                    //display main info
                    array_push($breadcrumbs, array('API', 'user/ucp/api'));
                    $content = View::make('user.ucp.api');
                    break;

                default:
                    //display main info
                    
                    $content = View::make('user.ucp.security');
                    break;
            }
            //user is logged in
            return View::make('user.ucp')->with('content', $content)->with('bcArr', $breadcrumbs);

        } else {
            //user is not logged in, redirect to login
            return Redirect::to('user/login');
        }
        
    }

    public function post_ucp($page = "main")
    {
        $input = Input::get();
        $breadcrumbs = array(
            array('Home', '/'),
            array('User CP', 'user/ucp')
            );
        Session::put('location', 'user/ucp/'.$page);
        if (Auth::check()) {
            $content  = "";
            switch ($page) {
                case 'security':
                array_push($breadcrumbs, array('Security', 'user/ucp/security'));
                    //display main user info
                    
                    $rules = array(
                        'currentemail' => 'required|email',
                        'newemail' => 'email',
                        'newemail_confirmation' => 'email|same:newemail',
                        'currentpassword' => 'required',
                        'newpassword' => 'different:currentpassword',
                        'newpassword_confirmation' => 'same:newpassword'
                        );


                    $v = Validator::make($input, $rules);

                    if ($v->passes()) {
                        $userdata = array(
                            'username' => $input['currentemail'],
                            'password' => $input['currentpassword']);
                        if (Auth::attempt($userdata)) {
                            if (isset($input['newemail']) && $input['newemail'] != "") {
                                DB::table('users')->where('id', '=', Auth::user()->id)->update(array(
                                    'email' => $input['newemail']
                                    ));
                            }
                            if (isset($input['newpassword']) && $input['newpassword'] != "") {
                                DB::table('users')->where('id', '=', Auth::user()->id)->update(array(
                                    'password' => Hash::make($input['newpassword'])
                                    ));
                            }
                            return View::make('generic.error')->with(array(
                                'bcArr' => $breadcrumbs,
                                'title' => 'Done!',
                                'type' => 'success',
                                'message' => 'Successfully modified your information.'
                                ));
                        } else {
                            return Redirect::to('user/ucp/security')->with_input()->with('has_login_errors', true);
                        }
                    } else {
                        return Redirect::to('user/ucp/security')->with_input()->with('has_errors', true)->with_errors($v);
                    }

                    break;
                case 'options':
                array_push($breadcrumbs, array('Options', 'user/ucp/options'));
                    $rules = array(
                        'prefix' => 'required',
                        'suffix' => 'required',
                        );


                    $v = Validator::make($input, $rules);

                    if ($v->passes()) {
                        DB::table('users')->where('id','=', Auth::user()->id)->update(array('rank' => $input['prefix'].','.$input['suffix']));
                        return View::make('generic.error')->with(array(
                                'bcArr' => $breadcrumbs,
                                'title' => 'Done!',
                                'type' => 'success',
                                'message' => 'Successfully modified your information.'
                                ));
                        
                    } else {
                        return Redirect::to('user/ucp/options')->with_input()->with('has_errors', true)->with_errors($v);
                    }

                default:
                    //display main info
                    return Redirect::to('user.ucp');
                    break;
            }
            //user is logged in
            return View::make('user.ucp')->with('content', $content);

        } else {
            //user is not logged in, redirect to login
            return Redirect::to('user/login');
        }
        
    }



    public function get_login()
    {
        $breadcrumbs = array(
            array('Home', '/'),
            array('Login', 'user/login')
            );

        if (Auth::check()) {
            return Redirect::to('/');
        } else {
            return View::make('user.login')->with('bcArr', $breadcrumbs);
        }
    }

    public function post_login() 
    {
        $location = Session::get('location', '/');
        $input = Input::get();
        $rules = array(
            'email' => 'required|email',
            'password' => 'required|alpha_num'            
        );   

        $v = Validator::make($input, $rules);

        if($v->fails() ) {
            return Redirect::to('user/login')->with_errors($v);
        } else {
            if (isset($input['remember'])) {
                $userdata = array(
                    'username'      => $input['email'],
                    'password'      => $input['password'],
                    'remember'      => 'true'
                );
            } else {
                $userdata = array(
                    'username'      => $input['email'],
                    'password'      => $input['password']
                );
            }
            
            if ( Auth::attempt($userdata) )
            {
                // we are now logged in, go to last location set by session
                return Redirect::to($location);
            }
            else
            {
                // auth failure! lets go back to the login
                return Redirect::to('user/login')->with('login_errors', true);
            }    

        }
    }


    public function get_logout($previousPage = "/")
    {
        Auth::logout();
        return Redirect::to($previousPage);
    }

    public function get_resendverification() {
            if (Auth::check() && Auth::user()->active == 0) {
                $activationCode = Core::generateRandomString(64);

                $activationURL = URL::to('user/verify'). "/" . Auth::user()->id . "-" . $activationCode;

                DB::table('activationCodes')->insert(array(
                    'uid' => Auth::user()->id,
                    'code'  => $activationCode,
                    'expiry'  => Core::unix_time() + (7 * 24 * 60 * 60)
                ));

                Log::write('info', 'Created Activation Code');

                // Message::to($email)
                //     ->from(Config::get('townsmods.email_register'), 'TownsMods Accounts')
                //     ->subject('TownsMods - Email Verification')
                //     ->body('view: emails.registration', array('name' => $username, 'verify_link' => $activationURL ))
                //     ->html('true')
                //     ->send();

                Message::send(function($message) use($activationURL)
                {
                    $message->to(Auth::user()->email);
                    $message->from(Config::get('townsmods.email_register'), 'TownsMods Accounts');

                    $message->subject('TownsMods - Email Verification');
                    $message->body('view: emails.registration');

                    $message->body->name = Auth::user()->username;
                    $message->body->verify_link = $activationURL;

                    $message->html(true);
                });

                Log::write('info', 'Email Sent');

                

                Log::write('info', 'Logged in user');
                $breadcrumbs = array(
                    array('Home', '/'),
                    array('Resend Verification', 'user/resendverification')
                    );
                return View::make("user.register_success")->with('email', Auth::user()->email)->with('bcArr', $breadcrumbs);
        } else {
            return Redirect::to('/');
        }
    }

    public function get_register() 
    {
        $breadcrumbs = array(
            array('Home', '/'),
            array('Login', 'user/register')
            );
        return View::make("user.register")->with('bcArr', $breadcrumbs);
        

    }

    //authenticate registration
    public function post_register()
    {
        $input = Input::get();
        $rules = array( 
            'username' => 'required|min:6|max:32|alpha_dash|unique:users',
            'email' => 'required|email|confirmed',
            'password' => 'required|min:6|confirmed'
        );   

        $v = Validator::make($input, $rules);

        if ($v->fails() ) {
            //Oops there were errors! Redirect back to registration!
            return Redirect::to('user/register')->with_input()->with_errors($v);
        } else {
            //user registration is OK

            $username = $input['username'];
            $email = $input['email'];
            $password = $input['password'];
            $id = DB::table('users')->insert_get_id(array(
                'username' => $username,
                'email'  => $email,
                'password'  => Hash::make($password),
                'usergroup' => 1,
                'registrationIP' => Request::ip(),
                'registrationDate' => Core::timestamp(),
                'rank' => '',
                'xp' => 0,
                'active' => 0
            ));
            Log::write('info', 'Created user entry');

            $activationCode = Core::generateRandomString(64);

            $activationURL = URL::to('user/verify'). "/" . $id . "-" . $activationCode;

            DB::table('activationCodes')->insert(array(
                'uid' => $id,
                'code'  => $activationCode,
                'expiry'  => Core::unix_time() + (7 * 24 * 60 * 60)
            ));

            Log::write('info', 'Created Activation Code');

            // Message::to($email)
            //     ->from(Config::get('townsmods.email_register'), 'TownsMods Accounts')
            //     ->subject('TownsMods - Email Verification')
            //     ->body('view: emails.registration', array('name' => $username, 'verify_link' => $activationURL ))
            //     ->html('true')
            //     ->send();

            Message::send(function($message) use($email, $input, $activationURL)
            {
                $message->to($email);
                $message->from(Config::get('townsmods.email_register'), 'TownsMods Accounts');

                $message->subject('TownsMods - Email Verification');
                $message->body('view: emails.registration');

                $message->body->name = $input['username'];
                $message->body->verify_link = $activationURL;

                $message->html(true);
            });

            Log::write('info', 'Email Sent');

            Auth::login($id);

            Log::write('info', 'Logged in user');
            $breadcrumbs = array(
            array('Home', '/'),
            array('Login', 'user/register')
            );

            return View::make("user.register_success")->with('bcArr', $breadcrumbs)->with('email', $email);
        }
    }

    public function get_resetpassword() {
        $breadcrumbs = array(
            array('Home', '/'),
            array('Reset Password', 'user/resetpassword')
            );

        return View::make('user.resetpassword')->with('bcArr', $breadcrumbs);
    }

    public function post_resetpassword() {
        $breadcrumbs = array(
            array('Home', '/'),
            array('Reset Password', 'user/resetpassword')
            );

        $input = Input::get();
        $rules = array( 
            'email' => 'required|email'
        );   

        $v = Validator::make($input, $rules);

        if ($v->fails() ) {
            //Oops there were errors! Redirect back to registration!
            return Redirect::to('user/resetpassword')->with_input()->with_errors($v);
        } else {
            //user registration is OK
            $email = $input['email'];
            $tempPass = Core::generateRandomString(10);
            if (DB::table('users')->where('email', '=', $email)->count() > 0) {
                DB::table('users')->where('email', '=', $email)->update(array('password' => Hash::make($tempPass)));

                Message::send(function($message) use($email, $input, $tempPass)
                {
                    $message->to($email);
                    $message->from(Config::get('townsmods.email_register'), 'TownsMods Accounts');

                    $message->subject('TownsMods - Reset Password');
                    $message->body('view: emails.resetpassword');

                    $message->body->email = $input['email'];
                    $message->body->password = $tempPass;

                    $message->html(true);
                });

                Log::write('info', 'Email Sent');
                return View::make('generic.error')->with(array(
                'bcArr' => $breadcrumbs,
                'title' => 'Success!',
                'type' => 'success',
                'message' => 'An email has been sent to '.$email.' with a new password.'
                ));
            } else {
                return View::make('generic.error')->with(array(
                'bcArr' => $breadcrumbs,
                'title' => 'Oops!',
                'type' => 'error',
                'message' => 'Something there didn\'t work. That email address does not exist.'
                ));
            }
        }
    }

    public function get_verify($code = "null") 
    {
        $valid = false;
        $expired = false;
        $breadcrumbs = array(
            array('Home', '/'),
            array('Login', 'user/login')
            );

        Log::write('info', 'Code: '.$code);

        //no code was ACTUALLY given
        if ($code == "null") {
            $valid = false;
        } else {
            $parts = explode("-", $code);
            Log::write('info', count($parts));
            
            if (count($parts) == 2) {
                //there is a user ID and a activation code.
                $uid = $parts[0];
                $activationCode = $parts[1];

                Log::write('info', 'UID: '. $uid . ' Code: '. $activationCode);

               
                $getCode = DB::table('activationCodes')->where('uid', '=', $uid)->where('code', '=', $activationCode)->first();

                if ($getCode != null) {
                    Log::write('info', 'Code Expiry: '.$getCode->expiry);
                    if($getCode->expiry > time()) {
                        $valid = true;
                        //its valid, so tell the user after activating their account and removing the code
                        DB::table('activationCodes')->where('uid', '=', $uid)->where('code', '=', $activationCode)->delete();
                        //TODO move usergroup!
                        DB::table('users')->where('id', '=', $uid)->update(array('active' => 1, 'usergroup' => 2));
                    } else {
                        $expired = true;
                    }
                } else {
                    $valid = false;
                }
            } else {
                $valid = false;
            }

        }

        return View::make('user.register_verify')->with('valid', $valid)->with('expired', $expired)->with('bcArr', $breadcrumbs);
    }

    public function get_messages($action = "null", $id = 0) {
        $breadcrumbs = array(
            array('Home', '/'),
            array('Messages', 'user/messages')
            );

        if (Auth::guest()) {
            Session::put('location', 'user/messages/'.$action);
            if ($action == "view" && $id != 0) {
                Session::put('location', 'user/messages/view/'.$id);
            }
            return Redirect::to('user/login');
        }
         switch ($action) {
            case 'all':
                array_push($breadcrumbs, array('Inbox', 'user/messages/all'));
                //display all messages
                $messages = DB::table('messages')->where('uid','=', Auth::user()->id)->join('users', 'messages.sender', '=', 'users.id')->order_by('timesent', 'desc')->get();
                return View::make('user.messages_list')->with('messages', $messages)->with('bcArr', $breadcrumbs);
                break;

            case 'sent':
                array_push($breadcrumbs, array('Sent', 'user/messages/sent'));
                //display sent messages
                $messages = DB::table('messages')->where('sender','=', Auth::user()->id)->join('users', 'messages.uid', '=', 'users.id')->order_by('timesent', 'desc')->get();
                return View::make('user.messages_sentbox')->with('messages', $messages)->with('bcArr', $breadcrumbs);
                break;

            case 'delete':
                //delete messages
                $message = DB::table('messages')->where('mid','=', $id)->first();
                if(isset($message)) {
                    if($message->sender == Auth::user()->id || $message->uid == Auth::user()->id) {
                        DB::table('messages')->where('mid','=', $id)->delete();
                    }
                }
                return Redirect::to('user/messages');
                break;
            
            case 'view':

                $message = DB::table('messages')->where('mid', '=', $id)->join('users', 'messages.sender', '=', 'users.id')->first();
                //Log::info($message->content);
                //set message as read
                if ($message != array()) {
                    if ($message->unread == 1 && $message->uid == Auth::user()->id) {
                        DB::table('messages')
                            ->where('mid', '=', $id)
                            ->update(array('unread' => '0'));
                    }
                    if ($message->uid != Auth::user()->id) {
                        $message = array();
                    }
                }
                //check for permission

                array_push($breadcrumbs, array('View', 'user/messages/view'));
                array_push($breadcrumbs, array($message->title, 'user/messages/view/'.$id));
                
                if ($message == array()) {
                    return View::make('user.messages_notfound')->with('bcArr', $breadcrumbs);
                } else {
                    return View::make('user.messages_view')->with('message', $message)->with('sentrecline', 'Sent By:')->with('bcArr', $breadcrumbs);
                }
                
                break;
                
            case 'viewsent':

                $message = DB::table('messages')->where('mid', '=', $id)->join('users', 'messages.uid', '=', 'users.id')->first();
                //Log::info($message->content);
                //set message as read
                if ($message != array()) {
                    if  ($message->sender != Auth::user()->id) {
                        $message = array();
                    }
                }
                //check for permission
                array_push($breadcrumbs, array('View', 'user/messages/view'));
                array_push($breadcrumbs, array($message->title, 'user/messages/view/'.$id));

                if ($message == array()) {
                    return View::make('user.messages_notfound')->with('bcArr', $breadcrumbs);
                } else {
                    return View::make('user.messages_view')->with('message', $message)->with('sentrecline', 'Sent To:')->with('bcArr', $breadcrumbs);
                }
                
                break;
                
            case 'send':
                //send message to any user
                if ($id == 0) {
                    array_push($breadcrumbs, array('Send Message', 'user/messages/send'));
                    return View::make('user.messages_new')->with(array('recipient' => '', 'has_errors' => false, 'errors' => array()))->with('bcArr', $breadcrumbs);
                
                //send message to specific user
                } else {
                     array_push($breadcrumbs, array('Send Message', 'user/messages/send/'.$id));
                    $user = DB::table('users')->where('id', '=', $id)->first();
                    $username = "";
                    if ($user) {
                        $username = $user->username;
                    }
                    Log::write('info', 'Recipient: '. $username);
                    return View::make('user.messages_new')->with(array('recipient'=> $username, 'has_errors' => false, 'errors' => array()))->with('bcArr', $breadcrumbs);
                }

                
                break;

            default:
                # code...
                return Redirect::to('user/messages/all');
                break;
        }
    }

    public function post_sendmessage() {
        $breadcrumbs = array(
            array('Home', '/'),
            array('Messages', 'user/messages'),
            array('Send Message', 'user/messages/new')
            );
        $rules = array(
            'recipient' => 'required|exists:users,username',
            'title' => 'required|min:5|max:255',
            'message' => 'required|min:5'
            );
        $input = Input::get();

        $v = Validator::make($input, $rules);

        if ($v->passes()) {
            //replace [code] with [code=lua] for bbcode bug
            $message = str_replace('[code]', '[code=lua]', $input['message']);
            //yay! send et!
            $recipent_id = DB::table('users')->where('username', '=', $input['recipient'])->first();
            DB::table('messages')->insert(array('uid' => $recipent_id->id, 'title' => $input['title'], 'content' => $message, 'sender' => Auth::user()->id));
            return Redirect::to('user/messages/sent');
        } else {
            //oh shit.
            $errors = $v->errors->all('<li>:message</li>');
            return View::make('user.messages_new')->with(array('recipient'=> $input['recipient'], 'has_errors' => true, 'errors' => $errors, 'bcArr' => $breadcrumbs));
               
        }

    }
}

?>