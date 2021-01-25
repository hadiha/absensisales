<div class="ui inverted loading dimmer">
	<div class="ui text loader">Loading</div>
</div>
<div class="header">Detail Permohonan</div>
<div class="content">
 	<form class="ui data form" id="dataForm" action="" method="POST">
		<table class="ui basic table" style="font-weight: bold">
			<thead></thead>
			<tbody>
				<tr>
					<td rowspan="2"><img class="ui top aligned tiny image" src="{{$record->user->showfotopath()}}"></td>
					<td width="5%">Nama</td>
					<td>:</td>
					<td>{{$record->user->name}}</td>
				</tr>
				<tr>
					<td>Area</td>
					<td>:</td>
					<td>{{$record->user->area}}</td>
				</tr>
				<tr>
					<td colspan="2">Tanggal</td>
					<td>:</td>
					<td>{{Carbon::parse($record->created_at)->format('d/m/Y')}}</td>
				</tr>
				<tr>
					<td colspan="2">Status </td>
					<td>:</td>
					<td>{{$record->status}}</td>
				</tr>
				<tr>
					<td colspan="2">Keterangan</td>
					<td>:</td>
					<td>{{$record->Keterangan ?? '-'}}</td>
				</tr>
				
			</tbody>
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