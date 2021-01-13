<script type="text/javascript">

	function saveData(formid) {
		// show loading
		$('#' + formid).find('.loading.dimmer').addClass('active');

		// begin submit
		$("#" + formid).ajaxSubmit({
			success: function(resp){
				console.log('save...')
				swal({
					title:'Tersimpan!',
					text:'Data berhasil disimpan.',
					type:'success',
					allowOutsideClick: false,
					showCancelButton: false,

					confirmButtonColor: '#0052DC',
					confirmButtonText: 'Tutup',
					
					cancelButtonColor: '#6E6E6E',
					cancelButtonText: 'Print'
				}).then((result) => { // ok
					location.href = '{{ url($pageUrl) }}';

				}, function(dismiss) { // cancel
					// if (dismiss === 'cancel') { // you might also handle 'close' or 'timer' if you used those
					// 	console.log('print 2')
					// 	getNewTab('{{ url('print') }}/' + resp.registration);

					// 	@if(isset($action) && $action == 'create')
					// 		location.href = '{{ url($action.'/'.$jalur) }}';
					// 	@else
					// 		location.href = '{{ url('/') }}';
					// 	@endif
					// } else {
					// 	throw dismiss;
					// }
				})
			},
			error: function(resp){
				$('#' + formid).find('.loading.dimmer').removeClass('active');
				// $('#cover').hide();
				var response = resp.responseJSON;
				$.each(response.errors, function(index, val) {
					clearFormError(index,val);
					showFormError(index,val);
				});
				time = 5;
				interval = setInterval(function(){
					time--;
					if(time == 0){
						clearInterval(interval);
						$('.pointing.prompt.label.transition.visible').fadeOut('slideUp', function(e) {
							$(this).remove();
						});
						$('.error').each(function (index, val) {
							$(val).removeClass('error');
						});
					}
				},1000)
				// var error = $('<ul class="list"></ul>');
				// $.each(resp.responseJSON.errors, function(index, val) {
				// 	error.append('<li>'+val+'</li>');
				// });
				// $('#' + formid).find('.ui.error.message').html(error).show();	
			}
		});
	}

	function deleteData(url) {
		swal({
			title: 'Menghapus Data',
			text: "Apakah akan menghapus data tersebut?",
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			confirmButtonText: 'Ya',
			cancelButtonColor: '#d33',
			cancelButtonText: 'Tidak',
			reverseButtons: true,
		}).then((result) => {
			if (result) {
				$.ajax({
					url: url,
					type: 'POST',
					// dataType: 'json',
					data: {
						'_method' : 'DELETE',
						'_token' : '{{ csrf_token() }}'
					}
				})
				.done(function(response) {
					swal({
				    	title: 'Data Berhasil Dihapus',
						text: " ",
						type: 'success',
						allowOutsideClick: false
				    }).then((res) => {
				    	dt.draw('page');
				    })
				})
				.fail(function(response) {
					swal({
				    	title: 'Data Gagal Dihapus',
						text: " ",
						type: 'error',
						allowOutsideClick: false
				    }).then((res) => {

				    })
				})

			}
		})
	}

	function loadModal(param) {
		var url    = (typeof param['url'] === 'undefined') ? '#' : param['url'];
		var modal  = (typeof param['modal'] === 'undefined') ? 'formModal' : param['modal'];
		var formId = (typeof param['formId'] === 'undefined') ? 'formData' : param['formId'];
		var onShow = (typeof param['onShow'] === 'undefined') ? function(){} : param['onShow'];

		$(modal).modal({
			bottom: 'auto',
			inverted: true,
			observeChanges: true,
			closable: false,
			detachable: false, 
			autofocus: false,
			onApprove : function() {
				$(formId).form('validate form');
				if($(formId).form('is valid')){
					$(modal).find('.loading.dimmer').addClass('active');
					$(formId).ajaxSubmit({
						success: function(resp){
							$(modal).modal('hide');
							swal(
							'Tersimpan!',
							'Data berhasil disimpan.',
							'success'
							).then((result) => {
								dt.draw('page');
								return true;
							})
						},
						error: function(resp){
							$(modal).find('.loading.dimmer').removeClass('active');
							// $('#cover').hide();
							var response = resp.responseJSON;
							$.each(response.errors, function(index, val) {
								clearFormError(index,val);
								showFormError(index,val);
							});
							time = 5;
							interval = setInterval(function(){
								time--;
								if(time == 0){
									clearInterval(interval);
									$('.pointing.prompt.label.transition.visible').fadeOut('slideUp', function(e) {
										$(this).remove();
									});
									$('.error').each(function (index, val) {
										$(val).removeClass('error');
									});
								}
							},1000)
							// $(modal).find('.loading.dimmer').removeClass('active');
							// var error = $('<ul class="list"></ul>');

							// $.each(resp.responseJSON.errors, function(index, val) {
							// 	error.append('<li>'+val+'</li>');
							// });

							// if(resp.responseJSON.status=='errors'){
							// 	error.append('<li>'+resp.responseJSON.message+'</li>');
							// }

							// $(modal).find('.ui.error.message').html(error).show();
						}
					});	
				}
				return false;
			},
			onShow: function(){
				$(modal).find('.loading.dimmer').addClass('active');
				$.get(url, { _token: "{{ csrf_token() }}" } )
				.done(function( response ) {
					$(modal).html(response);
					// execute script
					// console.log('ini eksekusi dari onshow')
					onShow();
				});
			},
			onHidden: function(){
				$(modal).html(`<div class="ui inverted loading dimmer">
										<div class="ui text loader">Loading</div>
									</div>`);
			}
		}).modal('show');
	}

	function postNewTab(url, param){
        var form = document.createElement("form");
        form.setAttribute("method", 'POST');
        form.setAttribute("action", url);
        form.setAttribute("target", "_blank");

        $.each(param, function(key, val) {
            var inputan = document.createElement("input");
                inputan.setAttribute("type", "hidden");
                inputan.setAttribute("name", key);
                inputan.setAttribute("value", val);
            form.appendChild(inputan);
        });

        document.body.appendChild(form);
        form.submit();

        document.body.removeChild(form);
    }

    function getNewTab(url){
        var win = window.open(url, '_blank');
  		win.focus();
    }

	function showFormError(key, value)
	{
		if(key.includes("."))
		{
			res = key.split('.');
			key = res[0] + '[' + res[1] + ']';
			if(res[1] == 0)
			{
				key = res[0] + '\\[\\]';
			}
		}
		var elm = $('#dataForm' + ' [name=' + key + ']').closest('.field');
		$(elm).addClass('error');
		var message = `<div class="ui basic red pointing prompt label transition visible">`+ value +`</div>`;

		var showerror = $('#dataForm' + ' [name=' + key + ']').closest('.field');
		$(showerror).append('<div class="ui basic red pointing prompt label transition visible">' + value + '</div>');
	}

	function clearFormError(key, value)
	{
		if(key.includes("."))
		{
			res = key.split('.');
			key = res[0] + '[' + res[1] + ']';
			if(res[1] == 0)
			{
				key = res[0] + '\\[\\]';
			}
			console.log(key);
		}
		var elm = $('#dataForm' + ' [name=' + key + ']').closest('.field');
		$(elm).removeClass('error');

		var showerror = $('#dataForm' + ' [name=' + key + ']').closest('.field').find('.ui.basic.red.pointing.prompt.label.transition.visible').remove();
	}

	$(document).on('click','input[type="text"][name="fileupload"]', function () {
		$(this).parents('.ui.action').find('button.browse.file').trigger('click');
	});
	$('.browse.file').unbind('click');

	$(document).on('click','.browse.file', function (e) {
		$(this).unbind('click');
        e.preventDefault();
        var fileinput = $(this).parents('.ui.action.input').find('input[type="file"]');
        browseFile(fileinput);
    });

	function browseFile(fileinput) {
	    $(fileinput).unbind('change');
	    $(fileinput).on('change', function (e) {
			var pass = 0;
			var maxsize = {{Helpers::convertfilesize()}};

	    if(e.target.files.length > 0)
	        {
          		$.each(e.target.files, function (index, file) {
					var showclass = "success";

					if(file.size > maxsize)
					{
						showclass="error";
						pass = 1;
						$('.showbrowse.file').append(`<div class="two fields upload-file">
							<div class="sixteen wide field">
							<div class="ui progress `+showclass+`">
							<div class="bar">
							<div class="progress"></div>
							</div>
							<div class="label">`+ file.name +` ( Failed to upload size above ` + '{{ini_get('upload_max_filesize')}}' + `B )</div>
							</div>
							</div>
							<div class="two wide field">
							<input type="file" style="display:none !important;" accept="image/*">
							<div class="two wide field">
								<a href="javascript:void(0)" class="ui icon red removefailedupload button">
								<i class="trash icon"></i>
								</a>
							</div>
							</div>`)

							$('.removefailedupload').on('click', function (e) {
					        e.preventDefault();
									$(this).parents('.two.fields:first').remove();
					    });
					}else{
						var formData = new FormData();
						formData.append('_token', '{{ csrf_token() }}');
						formData.append('file', file);

						var elem = document.createElement('div');
						$(elem).attr('class', 'two fields upload-file');

						$.ajax({
							url: '{{ url('barang/file-upload')  }}',
							type: "POST",
							dataType: 'json',
							processData: false,
							contentType: false,
							data : formData,
							beforeSend : function () {
								$(elem).html(`<div class="fourteen wide field">
									<div class="ui progress `+showclass+`">
										<div class="bar">
											<div class="progress"></div>
										</div>
										<div class="label">`+ file.name +`</div>
									</div>
								</div>
								<div class="two wide field">
									<button class="ui icon red removebrowse button">
									<i class="trash icon"></i>
									</button>
								</div>`);
								$('.showbrowse.file').append(elem)
								$(elem).find('.ui.progress').progress({
				                    total : e.total,
				                    value : 0,
				                })
							},
							uploadProgress : function (event, position, total, percentComplete) {
								$(elem).find('.ui.progress').progress({
									total : total,
									value : percentComplete,
								})
							},
							success: function(resp){
								$(elem).find('.two.wide.field').append(`<input name="filespath[]" value="`+resp.filepath+`" type="hidden">
									<input name="fileurl[]" value="`+resp.filepath+`" type="hidden">
									<input name="filename[]" value="`+resp.filename+`" type="hidden">
								`);
								$(elem).find('.ui.progress').progress({
									total : 100,
									value : 100,
								})
								removebrowse();
					            window.onbeforeunload = function(d) {
					                return "Dude, are you sure you want to leave? Think of the kittens!";
					            }
					            $('.countFile').val(($('.two.fields.upload-file').length) +' File');
							},
							error : function(resp){
							},
						})
					}
				});
	        }
	    });
	}

	$(document).on('click','.removebrowse.button', function (e) {
			e.preventDefault();
			var pathinput = $(this).parents('.two.wide.field').find('input[name="filespath[]"]').val();
			var elem = $(this);
			var url = '{{ url('barang/unlink') }}';
			if($(this).data('url'))
			{
				url = $(this).data('url');
			}
			var formData = new FormData();
			formData.append('_token', '{{ csrf_token() }}');
			formData.append('path', pathinput);

			$.ajax({
				url: url,
				type: "POST",
				dataType: 'json',
				processData: false,
				contentType: false,
				data : formData,
				success: function(resp){
					elem.parents('div[class="two fields upload-file"]').remove();
					$('.countFile').val(($('.two.fields.upload-file').length)+ ' File');

				},
				error : function(resp){
				},
			})
		});

		function removebrowse() {
			$('.removebrowse.button').on('click', function (e) {
				e.preventDefault();
				var pathinput = $(this).parents('.two.wide.field').find('input[name="filespath[]"]').val();
				var elem = $(this);
				var url = '{{ url('barang/unlink') }}';
				if($(this).data('url'))
				{
						url = $(this).data('url');
				}
				var formData = new FormData();
				formData.append('_token', '{{ csrf_token() }}');
				formData.append('path', pathinput);

				$.ajax({
					url: url,
					type: "POST",
					dataType: 'json',
					processData: false,
					contentType: false,
					data : formData,
					success: function(resp){
						elem.parents('div[class="two fields upload-file"]').remove();
						$('.countFile').val(($('.two.fields.upload-file').length)+ ' File');

					},
					error : function(resp){
					},
				})
			});
		}


</script>