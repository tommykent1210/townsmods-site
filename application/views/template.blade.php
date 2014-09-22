
<!DOCTYPE html>
<html lang="en">
  <head>
    {{ Asset::container('bootstrapper')->scripts() }}

    <meta charset="utf-8">
    @yield('head')
    <title>TownsMods.net -
    @yield('title')
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">


    {{ HTML::script('js/jquery-ui-1.10.2.custom.min.js')}}
    {{ HTML::script('js/jasny-bootstrap.js')}}
    {{ HTML::script('js/imgLiquid-min.js')}}
    <!-- Le styles -->
    <style>
      body {
        padding-top: 0px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
    </style>
    {{ Asset::container('bootstrapper')->styles() }}
    {{ HTML::style('css/jasny-bootstrap.css') }}
    {{ HTML::style('css/custom.css') }}
    {{ HTML::style('css/font-awesome.min.css') }}
    {{ HTML::style('css/prettify.css') }}

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
    <link rel="shortcut icon" href="{{URL::to('favicon.ico')}}">
    <link rel="shortcut icon" href="{{URL::to('favicon.png')}}">
    
  </head>

  <body style="padding-top: 0px;">
    <!-- nav -->
    @include('nav')
    @if (Auth::check() && Auth::user()->active == 0)
    <div class="alert alert-block">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <h4>Warning!</h4>
      You don't seem to have activated your account yet. Please click the link in the email we sent you on registration. If you have forgotten the email, or the link has expired. Please click here: <br />
      <a href="{{URL::to('user/resendverification')}}" class="btn btn-warning"><i class="icon-envelope"></i> Resend Email</a>
    </div>
    @endif
    
    @if (isset($bcArr) && $bcArr != array())
    <div class="container">
    <ul class="breadcrumb">
        @foreach ($bcArr as $breadcrumb)
            @if(URL::to($breadcrumb[1]) == URL::current())
            <li><a href="{{URL::to($breadcrumb[1])}}">{{$breadcrumb[0]}}</a></li>
            @else
            <li><a href="{{URL::to($breadcrumb[1])}}">{{$breadcrumb[0]}}</a> <span class="divider">/</span></li>
            @endif
       
        @endforeach
    </ul>
    @endif
      @yield('content')
    </div> <!-- /container -->

    @include('footer')
    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    {{ HTML::script('js/prettify.js') }}
    <script>prettyPrint();</script>

   

  </body>
</html>
