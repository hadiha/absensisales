<div class="ui inverted loading dimmer">
	<div class="ui text loader">Loading</div>
</div>
<div class="header">Ubah {{ $title or '' }}</div>
<div class="content">
 	<form class="ui data form" id="dataForm" action="{{ url($pageUrl.$record->id) }}" method="POST">
		{{-- <div class="ui error message">
		</div> --}}
		{!! csrf_field() !!}
		<input type="hidden" name="_method" value="PUT">
		<input type="hidden" name="id" value="{{ $record->id }}">
        <div class="field">
        	<label>Nama Barang</label>
            <input type="text" placeholder="Nama Barang" value="{{$record->item->name}}" readonly>
		</div>
		<div class="field">
        	<label>Kode Barang</label>
            <input type="text" placeholder="Nama Barang" value="{{$record->item->kode}}" readonly>
		</div>
		<div class="two fields">
			<div class="field">
			  <label>Tanggal Laporan</label>
			  <input type="text" placeholder="tanggal" name="tanggal" value="{{ Carbon::parse($record->tanggal)->format('d/m/Y')}}" readonly>
			</div>
			<div class="field">
				<label>Stok</label>
				<input type="text" placeholder="Stock" name="stock" value="{{$record->stock}}">
			</div>
		</div>
		<div class="two fields">
			<div class="field">
			  <label>Sale In</label>
			  <input type="text" placeholder="Sale In" name="sale_in" value="{{$record->sale_in}}">
			</div>
			<div class="field">
			  <label>Sale Out</label>
			  <input type="text" placeholder="Sale Out" name="sale_out" value="{{$record->sale_out}}">
			</div>
		</div>
		
		<div class="sixteen wide field">
			<label>Reference Files</label>
			<div class="ui action input">
				<input class="countFile" type="text" name="fileupload" value="{{$record->files->count()}} File" placeholder="Search..." readonly>
				<input type="file" style="display:none !important;" accept="image/*" multiple>
				<button type="button" class="ui button browse file">Cari..</button>
			</div>
	  	</div>
		<div class="field showbrowse file">
			@if($record->files->count() > 0)
				@foreach($record->files as $file)
				<div class="two fields upload-file">
					<div class="fourteen wide field">
					<div class="ui progress success" data-percent="100">
						<div class="bar" style="transition-duration: 300ms; width: 100%;">
						<div class="progress">100%</div>
						</div>
						<div class="label">{!! $file->filename !!}</div>
					</div>
					</div>
					<div class="two wide field">
						<a href="{{ asset('storage/'.$file->fileurl) }}" download="{{ $file->filename }}" target="_blank" class="mini ui icon green button">
							<i class="download icon"></i>
						</a>
						<button class="mini ui icon red removebrowse button">
							<i class="trash icon"></i>
						</button>
						<input name="fileid[]" value="{!! $file->id !!}" type="hidden">
						<input name="filespath[]" value="{!! $file->fileurl !!}" type="hidden">
						<input name="fileurl[]" value="{!! $file->fileurl !!}" type="hidden">
						<input name="filename[]" value="{!! $file->filename !!}" type="hidden">
					</div>
				</div>
				@endforeach
			@else
				<div class="ui floating message">
					<p>Tidak Ada Foto!</p>
				</div>
			@endif
		</div>



	</form>
</div>
<div class="actions">
	<div class="ui black deny button">
		Batal
	</div>
	<div class="ui positive right labeled icon save button">
		Simpan
		<i class="checkmark icon"></i>
	</div>
</div>