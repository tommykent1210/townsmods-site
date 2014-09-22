<?php
// application/controllers/account.php
class Profile_Controller extends Base_Controller
{

    public $restful = true;

    public function get_index($username = "_null_")
    {

    	Log::write('info', ''.$username);
    	if ($username == "_null_") {
    		if (Auth::check() == false) {
    			Session::put('location', 'profile');
    			return Redirect::to('user/login');
			} else {
				$username = Auth::user()->username;
			}
        }
        //redirect to user control panel
    	return Redirect::to('user/cp');	
    	
    	
        
    }

    public function get_list($query = "__all__") {
        if ($query == "__all__") {
            $breadcrumbs = array(
                array('Home', '/'),
                array('Profile', 'profile/list'),
                );
            $numprofiles = DB::table('users')->where('users.active', '=', 1)->count();
            $profiles = DB::table('users')->where('users.active', '=', 1)->order_by('username', 'asc')->paginate(10);
            if($numprofiles == 0) {
                return Redirect::to('profile/list');
            }
            return View::make('profile.list')->with('bcArr', $breadcrumbs)->with('users', $profiles)->with('query', 'null');
        } else {
            $breadcrumbs = array(
                array('Home', '/'),
                array('Profile', 'profile/list'),
                array('Search: '.$query, 'profile/list/'.$query)
                );
            $numprofiles = DB::table('users')->where('users.active', '=', 1)->where('username', 'LIKE', '%'.$query.'%')->count();
            $profiles = DB::table('users')->where('users.active', '=', 1)->where('username', 'LIKE', '%'.$query.'%')->order_by('username', 'asc')->paginate(10);
            if($numprofiles == 0) {
                return Redirect::to('profile/list');
            }
            return View::make('profile.list')->with('bcArr', $breadcrumbs)->with('users', $profiles)->with('query', $query);
        }
    }

    public function post_list() {
        $input = Input::get('search');
        return Redirect::to('profile/list/'.$input);
    }

    public function get_view($username = "_null_") {

        $breadcrumbs = array(
                array('Home', '/'),
                array('Profile', 'profile/list/'),         
                );

        Log::write('info', ''.$username);
         Session::put('location', 'profile/view/'.$username);
        if ($username == "_null_") {
            if (Auth::check() == false) {
                Session::put('location', 'profile/');
                return Redirect::to('user/login');
            } else {
                $username = Auth::user()->username;
                Session::put('location', 'profile/view/'.$username);
            }  
        } 
        if (DB::table('users')->where('id', '=', $username)->count() == 1) {
            $user = DB::table('users')->where('id', '=', $username)->first();
                $breadcrumbs = array(
                    array('Home', '/'),
                    array('Profile', 'profile/list/'),
                    array($user->username, 'profile/view/'.$username),
                    
                );
            

            return View::make('profile.user_profile')->with('userData', $user)->with('bcArr', $breadcrumbs);
        } else {
            return View::make('profile.not_found')->with('bcArr', $breadcrumbs);
        }
        
        Session::put('location', 'profile/view/'.$username);

        
    }

}

?>