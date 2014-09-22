@layout('template')

@section('head')
@endsection

@section('title')
Login
@endsection

@section('content')
<div class="span4 offset4 well well-small">
  <legend>Login</legend>
  @include('windows.login') 
</div>
@endsection