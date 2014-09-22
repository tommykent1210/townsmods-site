<?php

class Download_Controller extends Base_Controller {

	public function action_index() {
		return Redirect::to('download/get/0');
	}

	public function action_get($id = 0)
	{
		$breadcrumbs = array(
            array('Home', '/'),
            array('Downloads', 'projects')
            );

		if ($id > 0) {
			if (DB::table('content')->where('id', '=', $id)->count() == 1) {
				$file = DB::table('content')->where('id', '=', $id)->first();
				$dlhash = Core::generateRandomString(32);
				Session::put('dlinit', time());
				Session::put('dlhash', $dlhash);

				//get project ID:
				$modid = DB::table('modContent')->where('contentid', '=', $id)->first();
				$project = DB::table('mods')->where('id', '=', $modid->modid)->first();
				return View::make('download.adpage')->with(array(
					'bcArr' => $breadcrumbs,
					'hash' => $dlhash,
					'id' => $id,
					'file' => $file,
					'project' => $project));
			} else {

			}
		} else {

		}
		
		
		
	}

	public function action_complete($id = 0, $hash = "null") {
		if ($id > 0 && $hash != "null") {
			if (Session::get('dlhash', 'null') == $hash) {
				Log::info(Session::get('dlinit') );
				Log::info(Config::get('townsmods.dlwaittime'));
				Log::info(time());
				if (Session::get('dlinit', 0) + Config::get('townsmods.dlwaittime') <= time() ) {
					$file = DB::table('content')->where('id','=',$id)->first();
					if($file) {
						$url = path('public').'/cdn/'.$file->contenturl;
						Log::info($url);
						if(file_exists($url)) {
							DB::table('content')->where('id', '=', $id)->increment('downloads');
							return Response::download($url, $file->title);
						} else {
							return Redirect::to('download/missing');
						}
						
					} else {
						return Redirect::to('download/missing');
					}
				} else {
					return Redirect::to('download/missing');
				}
			} else {
				return Redirect::to('download/missing');
			}
		} else {
			return Redirect::to('download/missing');
		}
	}

	public function action_missing() {
		$breadcrumbs = array(
            array('Home', '/'),
            array('Missing Download', 'download/missing')
            );
		return View::make('download.missing')->with('bcArr', $breadcrumbs);
	}

}