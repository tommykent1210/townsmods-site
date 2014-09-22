<?php
// application/controllers/account.php
class About_Controller extends Base_Controller
{

    public $restful = true;

    public function get_dmca()
    {
        $breadcrumbs = array(
                array('Home', '/'),
                array('About DMCA', 'about/dmca'),
                
                );

        return View::make('about.dmca')->with('bcArr', $breadcrumbs);
        
    }

    public function get_privacy()
    {
        $breadcrumbs = array(
                array('Home', '/'),
                array('Privacy & TOS', 'about/privacy'),
                );

        return View::make('about.privacy')->with('bcArr', $breadcrumbs);
        
    }

    public function get_buried($action = "") {
        $breadcrumbs = array(
                array('Home', '/'),
                array('Buried Towns', 'about/buried'),
                );

        return View::make('about.buried')->with('bcArr', $breadcrumbs);

        
    }



}

?>