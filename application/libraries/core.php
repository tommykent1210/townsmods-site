<?php

/**
* 
*/
class Core
{
	
	public static function generateRandomString($length = 10) {
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[mt_rand(0, strlen($characters) - 1)];
	    }
	    return $randomString;
	}

	public static function timestamp() {
		return date('Y-m-d H:i:s');
	}

	public static function unix_time() {
		return time();
	}

	public static function trimDescription($description, $length) {
		return substr($description,0, $length - 3)."...";
	}

	public static function recalculateXP($id) {
		if (DB::table('users')->where('id', '=', $id)->count() == 1) {
			$userinfo = DB::table('users')->where('id', '=', $id)->first();
            $givenlikes = DB::table('likes')->where('uid', '=', $id)->count();
            $reclikes = 0;
            $userMods = DB::table('mods')->where('authorID', '=', $id)->get('id');

            foreach ($userMods as $mod) {
            	$count = DB::table('likes')->where('modid', '=', $mod->id)->count();
            	$reclikes += $count;
            }
            echo $givenlikes.'-'.$reclikes;

			//now we need to add together with any bonus XP
            $totalXP = intval(($givenlikes * intval(Config::get('townsmods.xpforlike'))) + ($reclikes * intval(Config::get('townsmods.xpforlikerec'))) + $userinfo->bonusxp);

            DB::table('users')->where('id', '=', $id)->update(array('xp' => $totalXP));
        }

	}

	public static function array_push_associative(&$arr) {
	   $args = func_get_args();
	   $ret = 0;
	   foreach ($args as $arg) {
	       if (is_array($arg)) {
	           foreach ($arg as $key => $value) {
	               $arr[$key] = $value;
	               $ret++;
	           }
	       }else{
	           $arr[$arg] = "";
	       }
	   }
	   return $ret;
	}

	public static function getLevel() {
		$xp = Auth::user()->xp;
		$levels = Config::get('townsmods.levels', array(
			array(0,0)
			));

		
		$level = 0;
		for ($i=0; $i < count($levels) - 1; $i++) { 
			if ($xp >=  intval($levels[$i][1])) {
				$level = intval($levels[$i][0]);
			}
		}
		//return 10;
		return $level;
	}

	public static function getRanks($type) {
		if (Auth::check()) {
			$userLevel = 0;
			$userLevel = Core::getLevel();

			$ranks = DB::table('ranks')->where('level', '<=', $userLevel)->where('type', '=', $type)->get();

			//var_dump($ranks);
			//exit;
			
			$titles = array();

			if (isset($ranks)) {
				foreach ($ranks as $rank) {
					Core::array_push_associative($titles, array($rank->id => $rank->text));
				}
			}
			
			return $titles;
		} else {
			return array();
		}
	}

	public static function formatRank($text) {
		if ($text) {
			$arr = explode(',', $text);
			$title = "";
			foreach ($arr as $arritem) {
				$temp = DB::table('ranks')->where('id','=', $arritem)->first();
				$title = $title . ' '. $temp->text;
			}

			return $title;
		} else {
			return "null";
		}
	}


	public static function stripSpaces($string) {
		return str_replace(" ", "", $string);
	}

	public static function returnXMLHeader() {
		return '<?xml version="1.0" encoding="ISO-8859-1" ?>';
	}

	public static function makeThumbnail($id = 0) {
		$new_w = 150;
		$new_h = 150;


		$imageID = DB::table('content')->where('id', '=', $id)->first();
		if ($imageID) {
			try {

				//if it exists, resize it
				$name = path('public').'cdn/'.$imageID->contenturl;
				$filename = path('public').'cdn/thumb/'.$imageID->contenturl;

				$filename = strtolower($filename);
				$system=explode('.',$name);
				//print_r($system);
				if (preg_match('/jpg|jpeg/',strtolower($system[2]))){
					$src_img=imagecreatefromjpeg($name);
				} elseif (preg_match('/png/',strtolower($system[2]))){
					$src_img=imagecreatefrompng($name);
				} else {
					echo "invalid type";
					exit;
				}
				//echo "test";
				//exit;
				$old_x=imageSX($src_img);
				$old_y=imageSY($src_img);
				/*if ($old_x > $old_y) {
					$thumb_w=$new_w;
					$thumb_h=$old_y*($new_h/$old_x);
				}
				if ($old_x < $old_y) {
					$thumb_w=$old_x*($new_w/$old_y);
					$thumb_h=$new_h;
				}
				if ($old_x == $old_y) {
					$thumb_w=$new_w;
					$thumb_h=$new_h;
				}*/
				$thumb_h = $new_h;
				$thumb_w = $new_w;

				$dst_img=ImageCreateTrueColor($thumb_w,$thumb_h);
				imagecopyresampled($dst_img,$src_img,0,0,0,0,$thumb_w,$thumb_h,$old_x,$old_y); 
				if (preg_match("/png/",$system[1]))
				{
					imagepng($dst_img,$filename); 
				} else {
					imagejpeg($dst_img,$filename); 
				}
				imagedestroy($dst_img); 
				imagedestroy($src_img); 
				return true;
			} catch (Exception $e) {
				echo $e;
				return false;
			}
		}
	}

	public static function thumbnailExists($id = 0) {

		$imageID = DB::table('content')->where('id', '=', $id)->first();
		$exists = false;
		if ($imageID) {
			$name = strtolower( path('public').'cdn/thumb/'.$imageID->contenturl);

			if(file_exists($name)) {
				$exists = true;
			} else {
				$exists = false;
			}
		} else {
			$exists = false;
		}
		
		return $exists;
	}

	public static function deleteThumbnail($id = 0, $regen = false) {
		$imageID = DB::table('content')->where('id', '=', $id)->first();

		if ($imageID) {
			$name = strtolower(path('public').'cdn/thumb/'.$imageID->contenturl);
			if(unlink($name)) {
				if($regen == true) {
					Core::makeThumbnail($id);
				}
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
}

?>