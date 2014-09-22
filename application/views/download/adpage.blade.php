@layout('template')

@section('title')
File Download: {{$file->title}} ({{$project->title}})
@endsection

@section('head')
<script type="text/javascript">

$(function(){
  var count = {{Config::get('townsmods.dlwaittime')}};
  countdown = setInterval(function(){
    $("#waitbutton").html("Please wait " +count + " seconds...");
    if (count < 0) {
        count = 0;
    }
    if (count == 0) {
        $("#waitbutton").html("Click here to download!");
        $("#waitbutton").removeClass('disabled');
    }
    count--;
  }, 1000);
});
</script>
@endsection

@section('content')
    <div class="well well-small">
        <legend>{{$project->title}} <small>{{$file->title}} - (Downloaded: {{$file->downloads}} times)</small></legend>
        <center>
            <script type="text/javascript"><!--
            google_ad_client = "ca-pub-7931407366643622";
            /* townsmods-download */
            google_ad_slot = "8632868974";
            google_ad_width = 468;
            google_ad_height = 60;
            //-->
            </script>
            <script type="text/javascript"
            src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
        </script>
        <br />
        <a id="waitbutton" href="{{ URL::to('download/complete/'.$id.'/'.$hash) }}" class="btn btn-primary btn-large disabled">Please wait {{Config::get('townsmods.dlwaittime')}} seconds...</a></center>
	</div>
@endsection