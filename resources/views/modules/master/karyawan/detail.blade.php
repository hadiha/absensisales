<script type="text/javascript">
	$(document).ready(function() {
		$("#personil").dropdown('refresh');
		$('.ui.calendar').calendar(calendarOpts);
	});
</script>
<div class="ui inverted loading dimmer">
	<div class="ui text loader">Loading</div>
</div>
<div class="header">
	<div class="sixteen wide tablet column">
		<h4 class="ui horizontal divider header">
			<i class="address book icon"></i>
			Detail Karyawan
		</h4>
	</div>
</div>
<div class="content">
	<form class="ui large form" id="dataForm" role="form" method="POST" action="{{ url($pageUrl).'/'.$record->id }}" enctype="multipart/form-data">
		<input type="hidden" name="_method" value="PUT">
		{!! csrf_field() !!}        
		<div class="ui grid">
			
			<div class="sixteen wide tablet eight wide computer column">
				<div class="two fields">
					<div class="five wide field">
						@if($record->photo)
						<img class="image-preview"  style="height: 4cm; width:100%!important; object-fit: cover;" id="showAttachment" src="{{ asset('storage/'.$record->photo) }}">
						@else
						<img class="image-preview"  style="height: 6cm; width:100%!important; object-fit: cover;" id="showAttachment" src="{{ asset('images/default.jpg') }}">
						@endif
					</div>
					<div class="eleven wide field">
						<div class="two fields">
							<div class="five wide field">
								<label for="nama" style="text-align: left;">NIK</label>
							</div>
							<div class="eleven wide field">
								<div class="ui left icon input">
									<i class="address card icon"></i>
									<input type="text" name="nik" placeholder="NIK" value="{{ $record->nik }}" readonly>
								</div>
							</div>
						</div>
						<div class="two fields">
							<div class="five wide field">
								<label for="nama" style="text-align: left;">Nama</label>
							</div>
							<div class="eleven wide field">
								<div class="field">
									<input type="text"  placeholder="Full Name" name="nama" value="{{ $record->nama }}" readonly>
								</div>
							</div>
						</div>
						<div class="two fields">
							<div class="five wide field">
								<label for="nama" style="text-align: left;">Email</label>
							</div>
							<div class="eleven wide field">
								<div class="ui left icon input">
									<i class="mail card icon"></i>
									<input type="email" name="email" placeholder="Email Address" value="{{ $record->user->email }}" readonly>
								</div>
							</div>
						</div>
						<div class="two fields">
							<div class="five wide field">
								<label for="nama" style="text-align: left;">Tanggal Lahir</label>
							</div>
							<div class="eleven wide field">
								<div class="ui" id="example2">
									<div class="ui input left icon">
										<i class="calendar icon"></i>
										<input type="text" placeholder="dd/mm/yyyy" name="tgl_lahir" value="{{ 
											Carbon::createFromFormat('Y-m-d', $record->tgl_lahir)->format('d/m/Y')
										}}" readonly>
									</div>
								</div>
							</div>
						</div>
						<div class="two fields">
							<div class="five wide field">
								<label for="nama" style="text-align: left;">Tempat Lahir</label>
							</div>
							<div class="eleven wide field">
								<div class="field">
									<input type="text" name="tmp_lahir" placeholder="Tempat Lahir" value="{{ $record->tmp_lahir }}" readonly>
								</div>
							</div>
						</div>      
					</div>
				</div>
				<div class="two fields">
					<div class="five wide field">
						<label for="jabatan" style="text-align: left;">Jabatan</label>
					</div>
					<div class="eleven wide field">
						<input type="text" value="{{ "admin"==$record->jabatan?'Administrator':'Programmer' }}" readonly>
					</div>
				</div>   
				<div class="two fields">
					<div class="five wide field">
						<label for="nama" style="text-align: left;">Jenis Kelamin</label>
					</div>
					<div class="eleven wide field">
						<input type="text" value="{{ "L"==$record->jk?'Laki-Laki':'Perempuan' }}" readonly>
					</div>
				</div>             
			</div> <!-- end -->
			<div class="sixteen wide tablet eight wide computer column">
				<div class="two fields">
					<div class="five wide field">
						<label for="nama" style="text-align: left;">No. Telepon</label>
					</div>
					<div class="eleven wide field">
						<div class="ui left icon input">
							<i class="phone icon"></i>
							<input type="text" name="phone" placeholder="Phone Number" value="{{ $record->no_hp }}" readonly>
						</div>
						<span id="tampil-alert-phone"></span>
					</div>
				</div>
				<div class="two fields">
					<div class="five wide field">
						<label for="nama" style="text-align: left;">NPWP</label>
					</div>
					<div class="eleven wide field">
						<div class="field">
							<input type="text" name="npwp" placeholder="No. NPWP" value="{{ $record->no_npwp }}" readonly >
						</div>
						<span id="tampil-alert-npwp"></span>
					</div>
				</div>
				<div class="two fields">
					<div class="five wide field">
						<label for="nama" style="text-align: left;">No. Rekening</label>
					</div>
					<div class="eleven wide field">
						<div class="field">
							<input type="text" name="no_rekening" placeholder="No. Rekening" value="{{ $record->no_rekening }}" readonly>
						</div>
						<span id="tampil-alert-no_rekening"></span>

					</div>
				</div>
				<div class="two fields">
					<div class="five wide field">
						<label for="nama" style="text-align: left;">Atas Nama</label>
					</div>
					<div class="eleven wide field">
						<div class="field">
							<input type="text" name="atas_nama" placeholder="A/n" value="{{ $record->atas_nama }}" readonly>
						</div>
						<span id="tampil-alert-atas_nama"></span>

					</div>
				</div>
				<div class="two fields">
					<div class="five wide field">
						<label for="nama" style="text-align: left;">Tanggal Masuk</label>
					</div>
					<div class="eleven wide field">
						<div class="ui" id="example2">
							<div class="ui input left icon">
								<i class="calendar icon"></i>
								<input type="text" placeholder="dd/mm/yyyy" name="tgl_masuk" value="{{ Carbon::createFromFormat('Y-m-d', $record->tgl_masuk)->format('d/m/Y') }}" readonly>
							</div>
						</div>
					</div>
				</div>
				@if (!empty($record->tgl_keluar)) 
				<div class="two fields">
					<div class="five wide field">
						<label for="nama" style="text-align: left;">Tanggal Keluar</label>
					</div>
					<div class="eleven wide field">
						<div class="ui" id="example2">
							<div class="ui input left icon">
								<i class="calendar icon"></i>
								<input type="text" placeholder="dd/mm/yyyy" name="tgl_keluar" value="{{ Carbon::createFromFormat('Y-m-d', $record->tgl_keluar)->format('d/m/Y') }}" readonly>
							</div>
						</div>
					</div>
				</div>
				@endif
				<div class="two fields">
					<div class="five wide field">
						<label for="nama" style="text-align: left;">Status</label>
					</div>
					<div class="eleven wide field">
						<div class="field">
							<select name="status" class="ui dropdown" placeholder="Status" disabled>
								@foreach ($option_status as $val)
								<option value="{{ $val->id }}" {{ $val->id==$record->status?'selected':'' }}>{{ $val->keterangan }}</option>
								@endforeach
							</select>
						</div>
						<span id="tampil-alert-status"></span>
					</div>
				</div>
			</div> <!-- end column 2 -->
		</div> <!-- end Grid -->
		<div class="actions" align="right">
			<div class="ui black deny page button">
				Close
			</div>
		</div>
	</form>
</div>