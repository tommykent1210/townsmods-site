@layout('template')

@section('title')
Privacy Policy & TOS
@endsection

@section('content')
  <div class="well">
    <legend>Privacy Policy</legend>

    {{View::make('generic.privacy_policy')}}

    <legend>Terms Of Service</legend>

    {{View::make('generic.terms_of_service')}}
  </div>


@endsection