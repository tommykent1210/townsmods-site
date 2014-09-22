@layout('template')

@section('title')
{{$title}}
@endsection

@section('content')
  <div class="alert alert-{{$type}}">
  <strong>{{$title}}!</strong> {{$message}}
</div>
@endsection