@if(Auth::guest())
  <div id="LoginModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="LoginModalLabel" aria-hidden="true">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      <h4 id="LoginModalLabel">Login</h4>
    </div>
    <div class="modal-body">
      <!--login form -->
      @include('windows.login') 
    </div>
  </div>
@endif

    <!-- header image -->
    <!--<div style="background-size: cover; background-image: url('img/bg.png'); background-repeat:no-repeat; width:auto; height:100px;">
    </div>-->
    
      <!--<div class="container">-->
        <div class="header">
          <div class="container">
            <div class="row">
              <div class="pull-left">
                <img src="{{URL::to('img/overlay.png')}}" style="height:170px;" />
              </div>
              <!-- header image -->

              @if (Auth::check() && 1 == 2)
              <!-- DISABLED FOR NOW! -->
              <!-- user stats -->
              <div class="span2 offset10 well well-small" style="margin-top: 40px;">
                <p>XP: {{Auth::user()->xp}}</p>
                
                <p>Level: {{Auth::user()->rank}}</p>
              </div>
              @endif
            </div>
          </div>
        </div>    
        <div class="navbar" style="-webkit-border-radius: 0; -moz-border-radius: 0; border-radius: 0;">
          <div class="navbar-inner">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="{{URL::to('/')}}">TownsMods</a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li><a href="{{ URL::to('/') }}"><i class="icon-home"></i> Home</a></li>
              <li><a href="{{ URL::to('projects/all') }}"><i class="icon-folder-open-alt"></i> Projects</a></li>
              <li><a href="{{ URL::to('projects/mods') }}"><i class="icon-cog"></i> Mods</a></li>
              <li><a href="{{ URL::to('projects/saves') }}"><i class="icon-save"></i> Saves</a></li>
              <li><a href="{{ URL::to('projects/buried') }}"><i class="icon-globe"></i> Buried Towns</a></li>
              <li><a href="{{ URL::to('docs') }}"><i class="icon-book"></i> Docs</a></li>
              <li><a href="{{ URL::to('profile/list') }}"><i class="icon-user"></i> Users</a></li>
            </ul>

            <!-- user and login stuff -->
            <ul class="nav" style="float:right">
              @if(Auth::check())
               
                <div class="btn-group">
                  <a class="btn " href="{{URL::to('user')}}"><i class="icon-user"> </i> {{Auth::user()->username}}</a>
                  <button class="btn dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu pull-right nav-inner">
                     <li><a href="{{URL::to('user/messages')}}"><i class="icon-envelope"> </i> Messages: <span class="badge badge-success">{{DB::table('messages')->where('uid','=', Auth::user()->id )->where('unread','=', 1)->count()}}</span></a></li>
                     <li><a href="{{URL::to('user')}}"><i class="icon-cogs"> </i> User Control Panel</a></li>
                     <li><a href="{{URL::to('profile/view/'.Auth::user()->id)}}"><i class="icon-user"> </i> My Profile</a></li>
                     
                     <li class="divider"></li>
                     @if (Auth::user()->usergroup == 4)
                     <li><a tabindex="" href="{{URL::to('admin')}}"><i class="icon-user-md"> </i> Admin CP</a></li>
                     @endif
                     <li><a tabindex="-1" href="{{URL::to('user/logout')}}"><i class="icon-off"> </i> Logout</a></li>
                  </ul>
                </div>
              @else
                <!-- Modal -->
                <li><a href="#LoginModal" role="button" class="" data-toggle="modal"><i class="icon-lock"> </i> Login/Register</a></li>
              @endif
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    

