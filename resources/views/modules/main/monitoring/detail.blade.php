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
					<td width="35%">Nama Pegawai</td>
					<td>:</td>
					<td>{{$record->user->name}}</td>
				</tr>
				<tr>
					<td>Area</td>
					<td>:</td>
					<td>{{$record->user->area}}</td>
				</tr>
				<tr>
					<td>Tanggal</td>
					<td>:</td>
					<td>{{ $record->date_in ? Carbon::parse($record->date_in)->format('d/m/Y') : Carbon::parse($record->created_at)->format('d/m/Y')}}</td>
				</tr>
				<tr>
					<td>Jam Masuk</td>
					<td>:</td>
					<td>{{ $record->date_in ? Carbon::parse($record->date_in)->format('H:i') : '-'}}</td>
				</tr>
				<tr>
					<td>Jam Keluar</td>
					<td>:</td>
					<td>{{ $record->date_out ? Carbon::parse($record->date_out)->format('H:i') : '-'}}</td>
				</tr>
				<tr>
					<td>Koordinat</td>
					<td>:</td>
					<td>{{$record->latitude}}, {{$record->longitude}}</td>
				</tr>
				<tr>
					<td>Status</td>
					<td>:</td>
					<td>@if($record->status == 'hadir') Masuk @else  {{ ucfirst($record->status) }} @endif</td>
				</tr>
				<tr>
					<td>Keterangan</td>
					<td>:</td>
					<td>{{$record->keterangan}}</td>
				</tr>
			</tbody>
		</table>
		<table class="ui celled table" style="font-weight: bold;text-align:center">
			@if($record->status == 'hadir')
				<thead>
					<tr>
						<th>Foto Masuk</th>
						<th>Foto Pulang</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>
							@if($record->fileurl_in != null) 
							<div class="ui tiny images">
									<img class="ui image" src="{{ url('storage/'.$record->fileurl_in) }}">
							</div>
							@else
							Tidak ada Foto
							@endif
						</td>
						<td>
							@if($record->fileurl_out != null) 
							<div class="ui tiny images">
									<img class="ui image" src="{{ url('storage/'.$record->fileurl_out) }}">
							</div>
							@else
							Tidak ada Foto
							@endif
						</td>
					</tr>
				</tbody>
			@else
			<thead>
				<tr>
					<th>Foto</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
						@if($record->fileurl_sakit != null) 
						<div class="ui tiny images">
								<img class="ui image" src="{{ url('storage/'.$record->fileurl_sakit) }}">
						</div>
						@else
						Tidak ada Foto
						@endif
					</td>
				</tr>
			</tbody>
			@endif
		</table>
		
		{{-- <div class="sixteen wide field">
			<label><b>Reference Files</b></label>
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
		</div> --}}
	</form>
</div>
<div class="actions">
	<div class="ui teal deny button">
		OK
	</div>
</div>