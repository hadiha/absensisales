<div class="ui inverted loading dimmer">
	<div class="ui text loader">Loading</div>
</div>
<div class="header">Detail {{ $title or '' }}</div>
<div class="content">
 	<form class="ui data form" id="dataForm" action="{{ url($pageUrl.$record->id) }}" method="POST">
		<table class="ui basic table" style="font-weight: bold">
			<thead></thead>
			<tbody>
				<tr>
					<td width="35%">Area</td>
					<td>:</td>
					<td>{{$record->area->name}}</td>
				</tr>
				<tr>
					<td>Tanggal</td>
					<td>:</td>
					<td>{{Carbon::parse($record->date)->format('d/m/Y')}}</td>
				</tr>
				<tr>
					<td>Keterangan</td>
					<td>:</td>
					<td>{{$record->keterangan}}</td>
				</tr>
			</tbody>
		</table>
		
		<div class="sixteen wide field">
			<label><b>Foto</b></label>
			@if($record->files->count() > 0)
				<div class="ui tiny images">
					@foreach($record->files as $file)
						<img class="ui image" src="{{ url('storage/'.$file->fileurl) }}">
					@endforeach
				</div>
			@else
				<div class="ui floating message">
					<p>Data Tidak Ditemukan!</p>
				</div>
			@endif
		</div>
	</form>
</div>
<div class="actions">
	<div class="ui teal deny button">
		OK
	</div>
</div>