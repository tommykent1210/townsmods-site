<legend>Project Actions</legend>
<p>The following actions relate to getting project information. All information is publically accessible.</p>


<legend>Contents</legend>
<ul>
	<li><a href="#get_info">Get Info</a></li>
</ul>

</div>
<div class="well well-small">
	<a id="get_info"></a><h4>Get Info<small> - Action name: "project_info"</small></h4>
	<p>Gets public project information.</p>

	<strong>Request:</strong>
	<table class="table table-bordered table-striped">
		<tr>
			<th>Parameter</th>
			<th>Description</th>
			<th>Example</th>
		</tr>

		<tr>
			<td><em>id</em></td>
			<td>The Project id.</td>
			<td>12</td>
		</tr>
	</table>

	<br />

	<strong>Response:</strong>
	<table class="table table-bordered table-striped">
		<tr>
			<th>Parameter</th>
			<th>Description</th>
			<th>Example</th>
		</tr>

		<tr>
			<td><em>author</em></td>
			<td>The user ID of the author</td>
			<td>12345</td>
		</tr>
		<tr>
			<td><em>title</em></td>
			<td>The project title</td>
			<td>Test Project</td>
		</tr>
		<tr>
			<td><em>description</em></td>
			<td>The project description</td>
			<td>This is a test project</td>
		</tr>
		<tr>
			<td><em>changelog</em></td>
			<td>The project changelog</td>
			<td>-V1.0: Added a boss</td>
		</tr>
		<tr>
			<td><em>version</em></td>
			<td>The project version</td>
			<td>1.0</td>
		</tr>
		<tr>
			<td><em>supportedVersion</em></td>
			<td>The version of towns the mod supports. "0" is returned for all versions.</td>
			<td>13a</td>
		</tr>
		<tr>
			<td><em>type</em></td>
			<td>The project type. Currently 3 project types are available: "0" = mods, "1" = saves, "2" = buried towns</td>
			<td>2</td>
		</tr>
		<tr>
			<td><em>updatedDate</em></td>
			<td>The project's last updated date</td>
			<td>2013-04-30 00:17:39</td>
		</tr>
		<tr>
			<td><em>uploadedDate</em></td>
			<td>The project's initial upload date</td>
			<td>2013-04-29 00:00:00</td>
		</tr>
		<tr>
			<td><em>modloaderCompatible</em></td>
			<td>If the project is compatible with the built in modloader added in v12 of Towns. Returns "1" for compatible, and "0" for incompatible.</td>
			<td>1</td>
		</tr>
		<tr>
			<td><em>views</em></td>
			<td>The number of views the project has</td>
			<td>222</td>
		</tr>
		<tr>
			<td><em>supportURL</em></td>
			<td>The project's support URL</td>
			<td>http://somesite.com/forum/thread/2</td>
		</tr>
	</table>
</div>
