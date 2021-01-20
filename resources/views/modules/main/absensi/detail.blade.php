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
					<td width="35%">Nama Barang</td>
					<td>:</td>
					<td>{{$record->item->name}}</td>
				</tr>
				<tr>
					<td>Kode Barang</td>
					<td>:</td>
					<td>{{$record->item->kode}}</td>
				</tr>
				<tr>
					<td>Tanggal Laporan</td>
					<td>:</td>
					<td>{{$record->item->name}}</td>
				</tr>
				<tr>
					<td>Stok</td>
					<td>:</td>
					<td>{{$record->stock}}</td>
				</tr>
				<tr>
					<td>Sale In</td>
					<td>:</td>
					<td>{{$record->sale_in}}</td>
				</tr>
				<tr>
					<td>Sale Out</td>
					<td>:</td>
					<td>{{$record->sale_out}}</td>
				</tr>
				
			</tbody>
		</table>
		
		<div class="sixteen wide field">
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
		</div>
	</form>
</div>
<div class="actions">
	<div class="ui teal deny button">
		OK
	</div>
</div>