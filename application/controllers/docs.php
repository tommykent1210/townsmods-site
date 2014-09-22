<?php
// application/controllers/account.php
class Docs_Controller extends Base_Controller
{

    public $restful = true;

    public function get_index() {
        $breadcrumbs = array(
                array('Home', '/'),
                array('Documentation', 'docs')
                );
        return View::make('docs.index')->with('bcArr', $breadcrumbs);
    }

    public function get_api($page = "")
    {
        if ($page == "") {
            return Redirect::to('docs/api/home');
        } else {
            $title = $page;
            $title = str_replace('_', ' ', $title);
            $title = str_replace('-', ': ', $title);
            
            $breadcrumbs = array(
                array('Home', '/'),
                array('Documentation', 'docs'),
                array('API', 'docs/api'),
                array(ucwords($title), 'docs/api/'.$page),
                );
            $page_safe = str_replace('_', '', strtolower($page));
            $page_safe = str_replace('-', '.', strtolower($page_safe));


            if (View::exists('docs.api.'.$page_safe) && ($page_safe != 'doctemplate') && ($page_safe != 'sidebar')) {
                $content = View::make('docs.api.'.$page_safe);
                return View::make('docs.api.doctemplate')->with('page', $page)->with('content', $content)->with('bcArr', $breadcrumbs);

            } else {
                return Response::error('404');
            }
            
        }
        
        
    }

    public function get_game($page = "")
    {
        if ($page == "") {
            return Redirect::to('docs/game/home');
        } else {
            $title = str_replace('_', ' ', $page);
            $title = str_replace('-', ': ', $page);
            
            $breadcrumbs = array(
                array('Home', '/'),
                array('Documentation', 'docs'),
                array('Game', 'docs/game'),
                array(ucwords($title), 'docs/game/'.$page),
                );
            $page_safe = str_replace('_', '', strtolower($page));
            $page_safe = str_replace('-', '.', strtolower($page_safe));


            if (View::exists('docs.game.'.$page_safe) && ($page_safe != 'doctemplate') && ($page_safe != 'sidebar')) {
                $content = View::make('docs.game.'.$page_safe);
                return View::make('docs.game.doctemplate')->with('page', $page)->with('content', $content)->with('bcArr', $breadcrumbs);

            } else {
                return Response::error('404');
            }
            
        }
        
        
    }

    public function get_modding($page = "")
    {
        if ($page == "") {
            return Redirect::to('docs/modding/home');
        } else {
            $title = str_replace('_', ' ', $page);
            $title = str_replace('-', ': ', $page);
            
            $breadcrumbs = array(
                array('Home', '/'),
                array('Documentation', 'docs'),
                array('Modding', 'docs/modding'),
                array(ucwords($title), 'docs/modding/'.$page),
                );
            $page_safe = str_replace('_', '', strtolower($page));
            $page_safe = str_replace('-', '.', strtolower($page_safe));


            if (View::exists('docs.modding.'.$page_safe) && ($page_safe != 'doctemplate') && ($page_safe != 'sidebar')) {
                $content = View::make('docs.modding.'.$page_safe);
                return View::make('docs.modding.doctemplate')->with('page', $page)->with('content', $content)->with('bcArr', $breadcrumbs);

            } else {
                return Response::error('404');
            }
            
        }
        
        
    }
}

?>