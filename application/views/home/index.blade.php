@layout('template')

@section('title')
Home
@endsection

@section('content')
      <div style="margin: 80px 0; text-align: center;">
        <h1>Welcome!</h1>
        <p style="font-size: 24px; line-height: 1.25;">Welcome to TownsMods! A new site aimed at making the sharing of user content easier for towns!</p>
        <a class="btn btn-success" href="http://townsgame.com/"><i class="icon-shopping-cart"> </i> Haven't got Towns? Buy it here now!</a>
      </div>

      <hr>

      <!-- Example row of columns -->
      <div class="row-fluid">
        <div class="span4">
          <h2>Features</h2>
          <p>
            <ul class="icons">
                <li><i class="icon-li icon-lock"></i> Secure, safe downloading</li>
                <li><i class="icon-li icon-search"></i> Easy searching</li>
                <li><i class="icon-li icon-save"></i> Saves, mods and more!</li>
                <li><i class="icon-li icon-comment-alt"></i> Author Attribution</li>
            </ul>
        </p>
        </div>
        <div class="span4">
          <h2>Go!</h2>
          <p>We're finally ready for the public! Have fun downloading mods and saves!</p>
       </div>
        <div class="span4">
          <h2>The Future?</h2>
          <p>We have lots of exciting plans for the future, including more security and better copyright protection for uploaders!</p>
        </div>
      </div>


@endsection