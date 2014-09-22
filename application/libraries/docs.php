<?php

class Docs {
	//for the docs
	public static function outputAPIDocSidebar($page = 'home') {
		$sidebar = Config::get('docs.api_sidebar');

		
		$sbcontent = Docs::renderSideBar($sidebar, $page, 'api');

		return $sbcontent;
	}
	public static function outputAPIDocSidebarActions($page = 'home') {
		$sidebar = Config::get('docs.api_sidebar_actions');

		$sbcontent = Docs::renderSideBar($sidebar, $page, 'api');
		

		return $sbcontent;
	}

	public static function outputGameDocSidebar($page = 'home') {
		$sidebar = Config::get('docs.game_sidebar');

		
		$sbcontent = Docs::renderSideBar($sidebar, $page, 'game');

		return $sbcontent;
	}

	public static function outputModdingDocSidebar($page = 'home') {
		$sidebar = Config::get('docs.modding_sidebar');

		
		$sbcontent = Docs::renderSideBar($sidebar, $page, 'modding');

		return $sbcontent;
	}

	public static function renderSideBar($arr, $page, $type) {
		$sbcontent = "";
		foreach ($arr as $sbe) {
			if($page == $sbe[1]) {
				$sbcontent .= '<li class="active"><a href="'.URL::to('docs/'.$type.'/'.$sbe[1]).'"><i class="'.$sbe[2].' icon-white"> </i> '.$sbe[0].'</a></li>';
			} else {
				$sbcontent .= '<li><a href="'.URL::to('docs/'.$type.'/'.$sbe[1]).'"><i class="'.$sbe[2].'"> </i> '.$sbe[0].'</a></li>';
			}
		}

		return $sbcontent;
	}


}

?>