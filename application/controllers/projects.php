<?php
// application/controllers/account.php
class Projects_Controller extends Base_Controller
{

    public $restful = true;
    


    public function get_index()
    {
        return Redirect::to('projects/all');    
    }

    public function get_all() {
        Session::put('location', 'projects/all');
        //get all projects
        $breadcrumbs = array(
            array('Home', '/'),
            array('Projects', 'projects/all')
            );
        $projects = DB::table('mods')->join('users', 'users.id', '=', 'mods.authorid')->where('mods.active', '=', 1)->order_by('updatedDate', 'desc')->order_by('uploadedDate', 'desc')->paginate(10, array('users.id', 'users.username', 'mods.id as modid', 'mods.title', 'mods.description', 'mods.mainimage','mods.supportedversion'));
        return View::make('projects.all')->with('bcArr', $breadcrumbs)->with('projects', $projects)->with('title', 'All Projects');
    }

    public function get_mods() {
        Session::put('location', 'projects/mods');
        //get all projects
        $breadcrumbs = array(
            array('Home', '/'),
            array('Mods', 'projects/mods')
            );
        $projects = DB::table('mods')->join('users', 'users.id', '=', 'mods.authorid')->where('type', '=', 0)->where('mods.active', '=', 1)->order_by('updatedDate', 'desc')->order_by('uploadedDate', 'desc')->paginate(10, array('users.id', 'users.username', 'mods.id as modid', 'mods.title', 'mods.description', 'mods.mainimage','mods.supportedversion'));
        return View::make('projects.all')->with('bcArr', $breadcrumbs)->with('projects', $projects)->with('title', 'All Mods');
    }

    public function get_saves() {
        Session::put('location', 'projects/saves');
        //get all projects
        $breadcrumbs = array(
            array('Home', '/'),
            array('Saves', 'projects/saves')
            );
        $projects = DB::table('mods')->join('users', 'users.id', '=', 'mods.authorid')->where('type', '=', 1)->where('mods.active', '=', 1)->order_by('updatedDate', 'desc')->order_by('uploadedDate', 'desc')->paginate(10, array('users.id', 'users.username', 'mods.id as modid', 'mods.title', 'mods.description', 'mods.mainimage','mods.supportedversion'));
        return View::make('projects.all')->with('bcArr', $breadcrumbs)->with('projects', $projects)->with('title', 'All Saves');
    }

    public function get_buried() {
        Session::put('location', 'projects/buried');
         //get all projects
        $breadcrumbs = array(
            array('Home', '/'),
            array('Buried Towns', 'projects/buried')
            );
        $projects = DB::table('mods')->join('users', 'users.id', '=', 'mods.authorid')->where('type', '=', 2)->where('mods.active', '=', 1)->order_by('updatedDate', 'desc')->order_by('uploadedDate', 'desc')->paginate(10, array('users.id', 'users.username', 'mods.id as modid', 'mods.title', 'mods.description', 'mods.mainimage','mods.supportedversion'));
        return View::make('projects.all')->with('bcArr', $breadcrumbs)->with('projects', $projects)->with('title', 'All Buried Towns');

    }

    public function get_view($id = 1) {

        Session::put('location', 'projects/view/'.$id);
        $project = DB::table('mods')->where('active', '=', 1)->where('id', '=', $id)->first();

        if (Auth::check()) {
            if (Auth::user()->usergroup == 4) {
                $project = DB::table('mods')->where('id', '=', $id)->first();
            }
        }
        if ($project != null) {
            DB::table('mods')->where('id', '=', $id)->increment('views');
            $breadcrumbs = array(
                array('Home', '/'),
                array('Projects', 'projects/all'),
                array(Core::trimDescription($project->title, 50), 'projects/view/'.$id),
                );
            $previewImages = DB::table('modContent')->join('content', 'modContent.contentID', '=', 'content.id')->where('modContent.modID', '=', $id)->where('content.type', '=', '2')->get();
            $user = DB::table('users')->where('id', '=', $project->authorid)->first();
            $downloadStats = DB::table('modContent')->join('content', 'modContent.contentID', '=', 'content.id')->where('modContent.modID', '=', $id)->where('content.type', '=', '1')->get();
            $downloads = '0';
            foreach ($downloadStats as $dl) {
                $downloads += intval($dl->downloads);
            }

            $typename = "";
            switch ($project->type) {
                case '0':
                    $typename = "mod";
                    break;
                case '1':
                    $typename = "save";
                    break;
                case '2':
                    $typename = "buried town";
                    break;

                default:
                    $typename = "mod";
                    break;
            }
            return View::make('projects.view')->with('bcArr', $breadcrumbs)->with('project', $project)->with('previewImages', $previewImages)->with('user', $user)->with('typename', $typename)->with('totalDownloads', $downloads);
        } else {
            $breadcrumbs = array(
                array('Home', '/'),
                array('Projects', 'projects/all'),
                array('Missing Project', 'projects/view/'.$id),
                );
            return View::make('generic.error')->with(array(
                    'bcArr' => $breadcrumbs,
                    'title' => 'Error',
                    'type' => 'error',
                    'message' => 'That project doesn\'t seem to exist any more. Please try another.'
                    ));
        }
    }

    public function get_downloads($id = 0) {
        $project = DB::table('mods')->where('active', '=', 1)->where('id', '=', $id)->first();

        if ($project != null) {
            $breadcrumbs = array(
                array('Home', '/'),
                array('Projects', 'projects/all'),
                array(Core::trimDescription($project->title, 50), 'projects/view/'.$id),
                );
            $downloads = DB::table('modContent')->join('content', 'modContent.contentID', '=', 'content.id')->where('modContent.modID', '=', $id)->where('content.type', '=', '1')->get();
            
            return View::make('projects.downloads')->with('bcArr', $breadcrumbs)->with('project', $project)->with('downloads', $downloads);
        } else {
            $breadcrumbs = array(
                array('Home', '/'),
                array('Projects', 'projects/all'),
                array('Missing Project', 'projects/view/'.$id),
                );
            return View::make('generic.error')->with(array(
                    'bcArr' => $breadcrumbs,
                    'title' => 'Error',
                    'type' => 'error',
                    'message' => 'That project doesn\'t seem to exist any more. Please try another.'
                    ));
        }
    }


    public function get_like($id = 0) {
        if ($id > 0) {
            if (DB::table('likes')->where('uid', '=', Auth::user()->id)->where('modid', '=', $id)->count() == 0) {
                DB::table('likes')->insert(array(
                    'uid' => Auth::user()->id,
                    'modid' => $id));
                $modid = DB::table('mods')->where('id', '=', $id)->first();
                Core::recalculateXP($modid->authorid);
                Core::recalculateXP(Auth::user()->id);

            } 
        }

        //recalculate both Users XP

        return Redirect::to('projects/view/'.$id);
    }

    public function get_unlike($id = 0) {
        if ($id > 0) {
            if (DB::table('likes')->where('uid', '=', Auth::user()->id)->where('modid', '=', $id)->count() == 1) {
                DB::table('likes')->where('uid', '=', Auth::user()->id)->where('modid', '=', $id)->delete();
                $modid = DB::table('mods')->where('id', '=', $id)->first();
                Core::recalculateXP($modid->authorid);
                Core::recalculateXP(Auth::user()->id);
            } 
        }
        return Redirect::to('projects/view/'.$id);
    }

    public function get_upload() {
        $breadcrumbs = array(
            array('Home', '/'),
            array('Projects', 'projects/all'),
            array('Upload', 'projects/upload')
            );

        if (Auth::check() && Auth::user()->active == 1 && (Auth::user()->usergroup == 2 || Auth::user()->usergroup == 4)) {
            return View::make('projects.upload')->with('bcArr', $breadcrumbs);
        } else {
            return Redirect::to('/');
        }
    }

    public function post_upload() {
        $input = Input::all();
        //var_dump($input);
        //exit;

        $rules = array(
            'projecttitle' => 'required|min:5|max:255',
            'message' => 'required|min:10',
            'type' => 'required',
            'previewimage' => 'required|mimes:png,jpg',
            'maindownload' => 'required|mimes:zip|max:5000',
            'version' => 'required',
            'supportedversions' => 'required',
           
            );

        $v = Validator::make($input, $rules);
        //change the language, so it works with message = project description
        $v->speaks('tr');


        if ($v->fails()) {
            //oops, shit went down boi.
            return Redirect::to('projects/upload')->with_input()->with('has_errors', true)->with_errors($v);
        } else {
            //yay!
            $modloaderCompatible = 0;
            if (isset($input['modloadercompatible'])) {
                $modloaderCompatible = 1;
            }

            $supportURL = "";
            if (isset($input['supporturl'])) {
                $supportURL = $input['supporturl'];
            }

            $changelog = "";
            if (isset($input['changelog'])) {
                $changelog = $input['changelog'];
            }

            //save the data, getting the ID
            $modID = DB::table('mods')->insert_get_id(array(
                'authorID' => Auth::user()->id,
                'active' => '1',
                'title' => $input['projecttitle'],
                'description' => $input['message'],
                'version' => $input['version'],
                'supportedVersion' => $input['supportedversions'],
                'mainimage' => '0',
                'type' => $input['type'],
                'modloadercompatible' => $modloaderCompatible,
                'supportURL' => $supportURL,
                'changelog' => $changelog,
                'uploadedDate' => Core::timestamp(),
                'updatedDate' => Core::timestamp()
                ));

            //now we have the ID, we can begin uploading the files, using the ID as a prefix
            //get the unique name for the preview image
            $name = $modID.'-'.Core::generateRandomString(16).".".File::extension(Input::file('previewimage.name'));
            Input::upload('previewimage', 'public/cdn/img/', $name);
            $mainImageID = DB::table('content')->insert_get_id(array(
                'contentURL' => 'img/'.$name,
                'active' => '1',
                'type' => 2,
                'title' => Input::file('previewimage.name')
                ));

            //after inputting, create a link between the project and the image
            DB::table('modContent')->insert(array(
                'modID' => $modID,
                'contentID' => $mainImageID,
                'active' => 1));

            //now, for the main file, do the same
            $name = $modID.'-'.Core::generateRandomString(16).".".File::extension(Input::file('maindownload.name'));
            Input::upload('maindownload', 'public/cdn/zip/', $name);
            $mainDLID = DB::table('content')->insert_get_id(array(
                'contentURL' => 'zip/'.$name,
                'active' => '1',
                'type' => 1,
                'title' => Input::file('maindownload.name')
                ));

            //after inputting, create a link between the project and the image
            DB::table('modContent')->insert(array(
                'modID' => $modID,
                'contentID' => $mainDLID,
                'active' => 1));

            //finally, update the original mod entry for the main preview image
            DB::table('mods')->where('id', '=', $modID)->update(array(
                'mainImage' => $mainImageID,
                'mainDownload' => $mainDLID));

            return Redirect::to('projects/view/'.$modID);


        }
    }

    public function get_edit($id = 0) {
        Session::put('location', 'projects/edit/'.$id);
        $breadcrumbs = array(
            array('Home', '/'),
            array('Projects', 'projects/all'),
            array('Edit', 'projects/edit/'.$id)
            );
        if (DB::table('mods')->where('id', '=', $id)->count() > 0) {
            $old = DB::table('mods')->where('id','=', $id)->first();
            
            $supportURL = "";
            if (isset($old->supporturl)) {
                $supportURL = $old->supporturl;
            }
            
            if (Auth::check() && Auth::user()->active == 1 && ((Auth::user()->usergroup == 2 && $old->authorid == Auth::user()->id) || Auth::user()->usergroup == 4)) {
                return View::make('projects.edit')->with('bcArr', $breadcrumbs)->with('old', $old)->with('supportURL', $supportURL)->with('modid', $id);
            } else {
                return View::make('generic.error')->with(array(
                'bcArr' => $breadcrumbs,
                'title' => 'Oops!',
                'type' => 'error',
                'message' => 'Something there didn\'t work. You may not have permission to edit that mod.'
                ));
            }
        } else {
            return View::make('generic.error')->with(array(
                'bcArr' => $breadcrumbs,
                'title' => 'Oops!',
                'type' => 'error',
                'message' => 'Something there didn\'t work. No mod with that ID exists.'
                ));
        }
        
    }

    public function post_edit() {
 

        $input = Input::all();
        //var_dump($input);
        //exit;

        $rules = array(
            'projecttitle' => 'required|min:5|max:255',
            'message' => 'required|min:10',
            'type' => 'required',
            'version' => 'required',
            'supportedversions' => 'required',
            'modid' => 'required'
            );

        $v = Validator::make($input, $rules);
        //change the language, so it works with message = project description
        $v->speaks('tr');


        if ($v->fails()) {
            //oops, shit went down boi.
            return Redirect::to('projects/edit')->with_input()->with('has_errors', true)->with_errors($v);
        } else {
            $breadcrumbs = array(
                array('Home', '/'),
                array('Projects', 'projects/all'),
                array('Edit', 'projects/edit'.$input['modid'])
                );
            //yay!
            $modloaderCompatible = 0;
            if (isset($input['modloadercompatible'])) {
                $modloaderCompatible = 1;
            }
            $supportURL = "";
            if (isset($input['supporturl'])) {
                $supportURL = $input['supporturl'];
            }

            $changelog = "";
            if (isset($input['changelog'])) {
                $changelog = $input['changelog'];
            }

            if(DB::table('mods')->where('id', '=', $input['modid'])->count() > 0) {
                $author = DB::table('mods')->where('id', '=', $input['modid'])->first();
                if (($author->authorid == Auth::user()->id) || Auth::user()->usergroup == 4 ) {
                    //they have permission

                    DB::table('mods')->where('id', '=', $input['modid'])->update(
                        array(
                            'title' => $input['projecttitle'],
                            'description' => $input['message'],
                            'version' => $input['version'],
                            'supportedVersion' => $input['supportedversions'],
                            'type' => $input['type'],
                            'modloadercompatible' => $modloaderCompatible,
                            'supportURL' => $supportURL,
                            'changelog' => $changelog,
                            'updatedDate' => Core::timestamp()
                            )
                        );
                    return Redirect::to('projects/view/'.$input['modid']);
                } else {

                    return View::make('generic.error')->with(array(
                        'bcArr' => $breadcrumbs,
                        'title' => 'Oops!',
                        'type' => 'error',
                        'message' => 'Something there didn\'t work. You may not have permission to edit that mod.'
                        ));
                }


            } else {
                return View::make('generic.error')->with(array(
                    'bcArr' => $breadcrumbs,
                    'title' => 'Oops!',
                    'type' => 'error',
                    'message' => 'Something there didn\'t work. No mod with that ID exists.'
                    ));
            }


        }
    }

    public function get_editfiles($id = 0) {
        Session::put('location', 'projects/editfiles/'.$id);
        $breadcrumbs = array(
            array('Home', '/'),
            array('Projects', 'projects/all'),
            array('Edit Project', 'projects/edit/'.$id),
            array('Edit Files', 'projects/editfiles/'.$id)
            );
        if (DB::table('mods')->where('id', '=', $id)->count() > 0) {
            $old = DB::table('mods')->where('id','=', $id)->first();

            if (Auth::check() && Auth::user()->active == 1 && ((Auth::user()->usergroup == 2 && $old->authorid == Auth::user()->id) || Auth::user()->usergroup == 4))  {
                //get the current images, and current downloads
                $images = DB::table('modContent')->where('modid', '=', $id)->join('content', 'modContent.contentid', '=', 'content.id')->where('content.type', '=', '2')->get();
                $downloads = DB::table('modContent')->where('modid', '=', $id)->join('content', 'modContent.contentid', '=', 'content.id')->where('content.type', '=', '1')->get();
                $projectinfo = DB::table('mods')->where('id', '=', $id)->first();

                return View::make('projects.editfiles')->with(array(
                    'bcArr' => $breadcrumbs,
                    'images' => $images,
                    'downloads' => $downloads,
                    'project' => $projectinfo,
                    'modid' => $id
                    ));
            } else {
                return View::make('generic.error')->with(array(
                'bcArr' => $breadcrumbs,
                'title' => 'Oops!',
                'type' => 'error',
                'message' => 'Something there didn\'t work. You may not have permission to edit that mod.'
                ));
            }
        } else {
            return View::make('generic.error')->with(array(
                'bcArr' => $breadcrumbs,
                'title' => 'Oops!',
                'type' => 'error',
                'message' => 'Something there didn\'t work. No mod with that ID exists.'
                ));
        }
    }

    public function post_editfiles() {
        $input = Input::all();
        //var_dump($input);
        //exit;

        $rules = array(
            'modid' => 'required',
            'file' => 'required|mimes:zip,jpg,png|max:10000'
        );

        $v = Validator::make($input, $rules);
        //change the language, so it works with message = project description
        $v->speaks('tr');

        $modid = 0;
        if (isset($input['modid'])) {
            $modid = $input['modid'];
        }
        
        if ($v->fails()) {
            //oops, shit went down boi.
            return Redirect::to('projects/editfiles/'.$modid)->with_input()->with('has_errors', true)->with_errors($v);
        } else {
            $breadcrumbs = array(
                array('Home', '/'),
                array('Projects', 'projects/all'),
                array('Edit', 'projects/editfiles/'.$input['modid'])
                );
            //yay!
           
            if(DB::table('mods')->where('id', '=', $input['modid'])->count() > 0) {
                $author = DB::table('mods')->where('id', '=', $input['modid'])->first();
                if ($author->authorid == Auth::user()->id) {
                    //they have permission
                    $name = $input['modid'].'-'.Core::generateRandomString(16).".".File::extension(Input::file('file.name'));
                    $type = 'img';
                    $typeid = 2;
                    if (File::extension(Input::file('file.name')) == 'zip') {
                        $type  = 'zip';
                        $typeid = 1;
                    }

                    Input::upload('file', 'public/cdn/'.$type.'/', $name);

                    $fileid = DB::table('content')->insert_get_id(array(
                        'contentURL' => $type.'/'.$name,
                        'active' => '1',
                        'type' => $typeid,
                        'title' => Input::file('file.name')
                        ));

                    DB::table('modContent')->insert(array(
                        'modid' => $input['modid'],
                        'contentid' => $fileid
                        ));
                    return Redirect::to('projects/editfiles/'.$input['modid']);
                } else {

                    return View::make('generic.error')->with(array(
                        'bcArr' => $breadcrumbs,
                        'title' => 'Oops!',
                        'type' => 'error',
                        'message' => 'Something there didn\'t work. You may not have permission to edit that mod.'
                        ));
                }


            } else {
                return View::make('generic.error')->with(array(
                    'bcArr' => $breadcrumbs,
                    'title' => 'Oops!',
                    'type' => 'error',
                    'message' => 'Something there didn\'t work. No mod with that ID exists.'
                    ));
            }


        }
    }

    public function get_deletefile($id = 0) {
        if(DB::table('content')->where('id', '=', $id)->count() > 0) {
            $contentInfo = DB::table('modContent')->join('mods', 'mods.id', '=', 'modContent.modid')->where('modContent.contentid', '=', $id)->first();
            
            //var_dump($contentInfo);
            //exit;

            if (Auth::user()->id == $contentInfo->authorid) {
                if (($id != $contentInfo->mainimage) && ($id != $contentInfo->maindownload)) {
                    //the image/file can be freely deleted, as it's not a default
                    DB::table('content')->where('id', '=', $id)->delete();
                    DB::table('modContent')->where('contentid', '=', $id)->where('modid', '=', $contentInfo->modid)->delete();
                    return Redirect::back();
                } else {
                    $files = DB::table('modContent')->join('content', 'content.id', '=', 'modContent.contentid')->where('modid', '=', $contentInfo->modid)->get(array('content.type AS type', 'content.id AS id'));
                    if($files != array()) {
                        if ($id == $contentInfo->mainimage) {
                            $newdefault = 0;
                            foreach ($files as $file) {
                                if($file->type == 2 && $file->id != $contentInfo->mainimage) {
                                    $newdefault = $file->id;
                                    break;
                                }
                            }
                            if ($newdefault == 0) {
                                //redirect back! No other images

                                return Redirect::back();
                            } else {

                                DB::table('mods')->where('id', '=', $contentInfo->modid)->update(array(
                                        'mainImage' => $newdefault
                                        ));

                                DB::table('content')->where('id', '=', $id)->delete();
                                DB::table('modContent')->where('contentid', '=', $id)->where('modid', '=', $contentInfo->modid)->delete();
                                return Redirect::back();
                            }
                        }

                        if ($id == $contentInfo->maindownload) {
                            $newdefault = 0;
                            foreach ($files as $file) {
                                if($file->type == 1) {
                                    $newdefault = $file->id;
                                    break;
                                }
                            }
                            if ($newdefault == 0) {
                                //redirect back! No other downlaods
                                return Redirect::back();
                            } else {
                                DB::table('mods')->where('id', '=', $contentInfo->modid)->update(array(
                                        'mainDownload' => $newdefault
                                        ));
                                DB::table('content')->where('id', '=', $id)->delete();
                                DB::table('modContent')->where('contentid', '=', $id)->where('modid', '=', $contentInfo->modid)->delete();
                                return Redirect::back();
                            }
                        }
                    } else {
                        //redirect back...
                        return Redirect::back();
                    }
                    
                }
            }
        }
    }

    public function get_makedefault($id = 0) {
        if(DB::table('content')->where('id', '=', $id)->count() > 0) {
            $info = DB::table('content')->where('id', '=', $id)->first();
            $modinfo = DB::table('modContent')->where('contentid' ,'=', $id)->join('mods', 'mods.id', '=', 'modContent.modid')->first('mods.id AS modid');

            if ($info->type == 1) {
                DB::table('mods')->where('id', '=', $modinfo->modid)->update(array(
                    'mainDownload' => $id
                    ));
            } else {
                DB::table('mods')->where('id', '=', $modinfo->modid)->update(array(
                    'mainImage' => $id
                    ));
            }
            return Redirect::back();
        } else {
            return Redirect::back();
        }
         
    }

    public function get_search() {
        return Redirect::to('projects/all');
    }

    public function post_search() {
        $input = Input::all();
        
        if (Auth::check()) {
            if (Auth::user()->usergroup == 4) {
             
                //var_dump($input);
                //exit;
            }
        }

        $results = DB::table('mods')->join('users', 'users.id','=','mods.authorid')->where('mods.active', '=', '1');

        if (isset($input['keywords'])) {
            if ($input['keywords'] != "") {
                $keywords = explode(' ', $input['keywords']);
                foreach ($keywords as $key => $value) {
                    $keywords[$key] = "%".$keywords[$key]."%";
                    $results = $results->where('mods.title', 'LIKE', $keywords[$key]);
                    $results = $results->or_where('mods.description', 'LIKE', $keywords[$key]);
                }    
            }
            Session::flash('input_keywords', $input['keywords']);
        }

        if (isset($input['author'])) {

            
            if (DB::table('users')->where('username', '=', $input['author'])->count() > 0) {
                $results = $results->where('users.username', '=', $input['author']);
            } else {
                $results = $results->where('users.username', 'LIKE', '%'.$input['author'].'%');
            }
            
            Session::flash('input_author', $input['author']);
        }

        if (isset($input['type'])) {
            if (is_array($input['type'])) {
                $results = $results->where_in('mods.type', $input['type']);
            } else {
                $results = $results->where('mods.type', 'LIKE', '%'.$input['type'].'%');
            }
            Session::flash('input_type', $input['type']);
        }

        if (isset($input['modloader'])) {
            $results = $results->where('mods.modloadercompatible', '=', $input['modloader']);
            Session::flash('input_modloader', $input['modloader']);
        }

        if (isset($input['supportedversions'])) {
            if (is_array($input['supportedversions'])) {
                $results = $results->where_in('mods.supportedversion', $input['supportedversions']);
            } else {
                if ($input['supportedversions'] != "0") {             
                    $results = $results->where('mods.supportedversion', '=', $input['supportedversions']);
                }
            }
            Session::flash('input_supportedversions', $input['supportedversions']);
        }

        $orderDirection = "desc";
        if (isset($input['sortorder'])) {
            $orderDirection = $input['sortorder'];
            Session::flash('input_sortorder', $input['sortorder']);
        }

        if (isset($input['sortby'])) {
            Session::flash('input_sortby', $input['sortby']);
            switch ($input['sortby']) {
                case 'title':
                    $results = $results->order_by('mods.title', $orderDirection);
                    break;
                case 'author':
                    $results = $results->order_by('users.username', $orderDirection);
                    break;
                case 'uploadDate':
                    $results = $results->order_by('mods.updateddate', $orderDirection);
                    break;
                case 'updatedDate':
                    $results = $results->order_by('mods.updateddate', $orderDirection);
                    break;
                case 'views':
                    $results = $results->order_by('mods.views', $orderDirection);
                    break;

                
                default:
                    $results = $results->order_by('mods.updatedDate', 'desc');
                    break;
            }
        } else {
            //sort by updated Date
            $results = $results->order_by('mods.updatedDate', 'desc');
        }

        if ($results) {
            
            $breadcrumbs = array(
                array('Home', '/'),
                array('Projects', 'projects/all'),
                array('Search', 'projects/search')
                );
            $numprojects = $results->count();
            $projects = $results->paginate($numprojects, array('users.id', 'users.username', 'mods.id as modid', 'mods.title', 'mods.description', 'mods.mainimage','mods.supportedversion'));
            if($numprojects == 0) {
                return Redirect::to('projects/all');
            }
            return View::make('projects.all')->with('bcArr', $breadcrumbs)->with('projects', $projects)->with('title', 'Search');
        
        } else {
           
            return Redirect::to('projects/all');
        }

    }

    public function get_report($id = 0) {
        return Redirect::to('projects/all');
    }

    public function post_report() {
        $breadcrumbs = array(
                array('Home', '/'),
                array('Report Project', 'projects/report')
                );
        $input = Input::all();
        //var_dump($input);
        //exit;

        $rules = array(
            'type' => 'required',
            'message' => 'required|min:10',
            'modID' => 'required|integer'
            );

        $v = Validator::make($input, $rules);
        //change the language, so it works with message = project description
        
        if ($v->fails()) {
            return View::make('generic.error')->with(array(
                'bcArr' => $breadcrumbs,
                'title' => 'Invalid Report',
                'type' => 'error',
                'message' => 'That report didn\'t seem to work right! Please view the mod and try again.'
                ));
        } else {
            DB::table('reports')->insert(array(
                'modID' => $input['modID'],
                'type' => $input['type'],
                'uid' => Auth::user()->id,
                'message' => $input['message']));

            return View::make('generic.error')->with(array(
                'bcArr' => $breadcrumbs,
                'title' => 'Thanks!',
                'type' => 'success',
                'message' => 'Thank you for reporting your issue. A member of the admin team will review your report and take appropriate action.'
                ));

        }

    }

    public function get_delete($id = 0) {
        $breadcrumbs = array(
                array('Home', '/'),
                array('Delete Project', 'projects/delete')
                );

        if (DB::table('mods')->where('id', '=', $id)->count() == 1) {
            $project = DB::table('mods')->where('id', '=', $id)->first();
            if ($project->authorid == Auth::user()->id) {
                DB::table('mods')->where('id', '=', $id)->delete();
                return View::make('generic.error')->with(array(
                    'bcArr' => $breadcrumbs,
                    'title' => 'Done',
                    'type' => 'success',
                    'message' => 'Project successfully deleted.'
                    ));
            } else {
                return View::make('generic.error')->with(array(
                    'bcArr' => $breadcrumbs,
                    'title' => 'Error',
                    'type' => 'error',
                    'message' => 'You do not have permission to delete this project.'
                    ));
            }
        } else {
            return View::make('generic.error')->with(array(
                    'bcArr' => $breadcrumbs,
                    'title' => 'Error',
                    'type' => 'error',
                    'message' => 'This project does not exist.'
                    ));
        }
    }
}

?>