{{Core::returnXMLHeader()}}

<response>
	<server>
		<name>TownsMods.net</name>
		<downloadURL>{{URL::to('api/getbury')}}/__ID__</downloadURL>
		<uploadURL>{{URL::to('api/getbury')}}/__ID__</uploadURL>
	</server>
	<buriedFiles>
	@foreach ($files as $file)
	<buriedFile>
			<fileName>{{Core::stripSpaces($file->title)}}.zip</fileName>
			<fileID>{{$file->id}}</fileID>
		</buriedFile>
	@endforeach
</buriedFiles>
</response>