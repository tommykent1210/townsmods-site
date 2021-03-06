<?php
// application/controllers/account.php
class Data_Controller extends Base_Controller
{
    public function action_user() {
        $data = array();
        if (isset($_REQUEST['term'])) {
            $chars = $_REQUEST['term'];
            
            $usernames = DB::table('users')->where('username', 'LIKE', "%".$chars."%")->take(10)->get();
            
            foreach ($usernames as $username) {
                //echo $username['username'];
                $data[] = array(
                    'label' => $username->username,
                    'value' => $username->username
                );
            }
            
        } else {
            
            $data[0] = array(
                'label' => '',
                'value' => '');
        }
        echo json_encode($data);
        
    }

    public function action_previewimage($id = "0.png") {
        $id = intval(str_replace('.png', '', $id));


        if ($id >0) {

            $pic = DB::table('content')->where('id', '=', $id)->where('active', '=', 1)->first();
            $loc = path('public').'cdn/thumb/';
            

            if ($pic) {
                if (Core::thumbnailExists($id) == false) {
                    Core::makeThumbnail($id);
                }
                $name = $loc.strtolower($pic->contenturl);
                //echo $name;
                $mime = File::mime($name);
                header("Content-Type: ".$mime);
                echo file_get_contents($name);
                exit;
                
            } else {
                echo "Content Not Found";
            }
        } else {
            echo "invalid ID";
        }
    }

    public function action_thumb($id = 0) {
        Core::makeThumbnail($id);
    }

    public function action_scan() {
        $publicDir = dirname(dirname(dirname(__FILE__))).'/public';
        $tempdir = $publicDir.'/hashing/temp/';
        // Do some hashing
        if (DB::table('content')->where('scanned', '=', '0')->where('type', '=', '1')->count() > 0) {
            $modFile = DB::table('content')->where('scanned', '=', '0')->where('type', '=', '1')->take(10)->get();
            foreach ($modFile as $content) {
                //take each mod 1 at a time
                //remove the temp dir, if it exists
                //File::rmdir($tempdir);
                //mkdir($tempdir, 0777);
                //try unzipping the mod file
                $modLoc = $publicDir.'/cdn/'.$content->contenturl;
                echo 'ModLoc: ' .$modLoc. '<br />';
                
                $zip = new ZipArchive;
                $res = $zip->open($modLoc);
                if ($res === TRUE) {
                    // extract it to the path we determined above
                    $zip->extractTo($tempdir);
                    $zip->close();
                    $paths = array();
                    $objects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($tempdir));
                    foreach($objects as $name => $object){

                        array_push($paths, $object->getPathname());

                    }
                    $filesim = 0;
                    $filestot = 0;
                    //hash them all
                    foreach($paths as $fileitem) {
                        
                        $hash = hash_file('md5', $fileitem);
                        $filestot += 1;

                        if (DB::table('hashes')->where('hash', '=', $hash)->count() > 0) {
                            $filesim += 1;
                        } else {
                            //if it doesn't exist, add it to the db
                            DB::table('hashes')->insert(array('contentID' => $content->id, 'hash' => $hash));
                        }

                    }

                    //finally, create a percentage similarity, and set the mod as scanned
                    $perc = ($filesim / $filestot) * 100;
                    echo "Percent Similar: ". $perc;
                    DB::table('content')->where('id', '=', $content->id)->update(array('similarityScore' => $perc, 'scanned' => 1));
                } else {
                    echo 'result: '.$res;
                }
            }
        } else {
            echo 'no files';
        } 
    }
}

?>