<?php

class Admin_Controller extends Base_Controller {

	public function action_index() {
		if (!Auth::check() || Auth::user()->usergroup != 4) {
			return Response::error('404');
			//echo Auth::user()->usergroup;
		}

		$breadcrumbs = array(
                array('Home', '/'),
                array('Admin', '/admin'),
                
                );

		return View::make('admin.index')->with('bcArr', $breadcrumbs);
	}

	public function action_reports() {
		if (!Auth::check() || Auth::user()->usergroup != 4) {
			return Response::error('404');
			//echo Auth::user()->usergroup;
		}

		$breadcrumbs = array(
                array('Home', '/'),
                array('Admin', '/admin'),
                array('Reports', '/admin/reports'),
                );
		$reports = DB::table('reports')->join('users', 'users.id', '=', 'reports.uid')->join('mods', 'mods.id', '=', 'reports.modid')->order_by('reports.closed', 'asc')->order_by('reports.id', 'desc')->get(array('users.username AS reporter', 'mods.title AS modname', 'reports.message AS message', 'reports.id AS id', 'reports.closed AS closed'));

		return View::make('admin.reports')->with('bcArr', $breadcrumbs)->with('reports', $reports);
	}

	public function action_disablemod($id = 0) {
		if (!Auth::check() || Auth::user()->usergroup != 4) {
			return Response::error('404');
			//echo Auth::user()->usergroup;
		}

		if($id > 0 && DB::table('mods')->where('id', '=', $id)->count() != 0) {
			DB::table('mods')->where('id', '=', $id)->update(array('active' => 0));
			$breadcrumbs = array(
                array('Home', '/'),
                array('Admin', 'admin'),
                array('Reports', 'admin/reports'),
                array('Mod Disabled', 'admin/disablemod/'.$id),
                );
            return View::make('generic.error')->with(array(
                    'bcArr' => $breadcrumbs,
                    'title' => 'Info',
                    'type' => 'info',
                    'message' => 'Mod Disabled!'
                    ));
		} else {
			$breadcrumbs = array(
                array('Home', '/'),
                array('Admin', 'admin'),
                array('Reports', 'admin/reports'),
                array('Missing Mod', 'admin/disablemod/'.$id),
                );
            return View::make('generic.error')->with(array(
                    'bcArr' => $breadcrumbs,
                    'title' => 'Error',
                    'type' => 'error',
                    'message' => 'That mod doesn\'t seem to exist any more. Please try another.'
                    ));
		}
	}

	public function action_closereport($id = 0) {

		if ($id >0 && DB::table('reports')->where('id', '=', $id)->count() > 0) {
			DB::table('reports')->where('id','=', $id)->update(array('closed' => 1));
		}

		return Redirect::to('admin/viewreport/'. $id);
	}

	public function action_viewreport($id = 0) {
		if (!Auth::check() || Auth::user()->usergroup != 4) {
			return Response::error('404');
			//echo Auth::user()->usergroup;
		}
		if ($id > 0 && DB::table('reports')->where('id', '=', $id)->count() != 0) {
			$breadcrumbs = array(
                array('Home', '/'),
                array('Admin', 'admin'),
                array('Reports', 'admin/reports'),
                array('View Report', 'admin/viewreport/'.$id),
                );
			$report = DB::table('reports')->join('users', 'users.id', '=', 'reports.uid')->join('mods', 'mods.id', '=', 'reports.modid')->where('reports.id', '=', $id)->first(array('users.username AS reporter', 'mods.title AS modname', 'reports.message AS message', 'reports.id AS id', 'users.id AS reporterid', 'mods.id AS modid', 'reports.type AS type', 'mods.active AS modstatus', 'reports.closed AS closed'));

			$data = array();

		
			$type = "DMCA";
			switch ($report->type) {
				case '0':
					$type = "Mod is Spam";
					break;
				
				case '1':
					$type = "Copyright/DMCA";
					break;
				
				default:
					$type = "Misc";
					break;
			}
			Core::array_push_associative($data, array('type' => $type));
		

			$modstatus = "Active";
			switch ($report->modstatus) {
				case '1':
					$modstatus = "Active";
					break;
				default:
					$modstatus = "Disabled";
					break;
			}
			Core::array_push_associative($data, array('modstatus' => $modstatus));

			Core::array_push_associative($data, array('message' => $report->message, 
				'modname' => $report->modname, 
				'reportid' => $report->id, 
				'reporter' => $report->reporter,
				'modid' => $report->modid,
				'reporterid' => $report->reporterid,
				'closed' => $report->closed));


			return View::make('admin.viewreport')->with('bcArr', $breadcrumbs)->with('report', $data);
		} else {
			$breadcrumbs = array(
                array('Home', '/'),
                array('Admin', 'admin'),
                array('Missing Report', 'admin/viewreport/'.$id),
                );
            return View::make('generic.error')->with(array(
                    'bcArr' => $breadcrumbs,
                    'title' => 'Error',
                    'type' => 'error',
                    'message' => 'That report doesn\'t seem to exist any more. Please try another.'
                    ));
		}
	}
	
}