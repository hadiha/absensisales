
<script type="text/javascript">
	$(document).ready(function() {
		$('button[data-content]').popup({
			hoverable: true,
			position : 'top center',
			delay: {
				show: 300,
				hide: 800
			}
		});

		dt = $('#listTable').DataTable({
	        dom: 'rt<"bottom"ip><"clear">',
			responsive: true,
			autoWidth: false,
			processing: true,
			serverSide: true,
			lengthChange: false,
			pageLength: 10,
			filter: false,
			sorting: [],
			language: {
				url: "{{ asset('plugins/datatables/Indonesian.json') }}"
			},
			ajax:  {
				url: "{{ url($pageUrl) }}/grid",
				type: 'POST',
				data: function (d) {
					d._token = "{{ csrf_token() }}";
					@yield('js-filters')
				}
			}, 
			columns: {!! json_encode($tableStruct) !!},
			drawCallback: function() {
				var api = this.api();

				api.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i, x, y) {
					cell.innerHTML = parseInt(cell.innerHTML)+i+1;
					// cell.innerHTML = i+1;
				} );

				$('[data-content]').popup({
					hoverable: true,
					position : 'top center',
					delay: {
						show: 300,
						hide: 800
					}
				});

				//Calender
				// $('.ui.calendar').calendar({
				// 	type: 'date'
				// });

				//Popup							
				// $('.checked.checkbox')
				//   .popup({
				//     popup : $('.custom.popup'),
				//     on    : 'click'
				//   });
			}
		});

		// dt.on('draw.dt', function () {
  //           dt.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
  //               // console.log(cell.innerHTML)
  //               start = cell.innerHTML;
  //               // cell.innerHTML = "<div class='text-center'>" + (parseInt(start) + (i+1))+ "</div>";
  //               cell.innerHTML = "<div class='text-center'>" + (parseInt(start))+ "</div>";
  //               // console.log(start);
  //           });
  //       }).draw('page');

        // change page list
        $('select[name="filter[page]"]').on('change', function(e) {
        	var length = this.value // $("input[name='filter[entri]']").val();
			length = (length != '') ? length : 10;
			dt.page.len(length).draw();
			e.preventDefault();
		});

		$('.filter.button').on('click', function(e) {
			dt.draw();
			// dt.ajax.reload();
			e.preventDefault();
		});
		
		// {/{ dd($pageUrl.'show-detail') }}
		/* Formatting function for row details - modify as you need */
		function format (id) {
		    // `d` is the original data object for the row
		    $.ajax({
		    	url: "{{ $pageUrl.'show-detail' }}",
		    	type: 'POST',
		    	dataType: 'html',
		    	data: {_token:'{{ csrf_token() }}', id:id},
		    }) 
		    .done(function(response) {
		    	console.log("success");
		    	$('#content_detail'+id).html(response);
		    })
		    .fail(function() {
		    	console.log("error");
		    })
		    .always(function() {
		    	console.log("complete");
		    });

		    return '<div class="ui slider attached segment" id="content_detail'+id+'" style="width:97%"><center>Loading..</center></div>';
		}

	    // Add event listener for opening and closing details
	    $('#listTable tbody').on('click', 'td.details-control button', function () {
	     	var nilai = $(this).data('button');
	     	// alert(nilai);
	    	var tr = $(this).closest('tr');
	        var rows = dt.row( tr );
			console.log(rows);
	        if ( rows.child.isShown() ) {
 		        // This row is already open - close it
	            rows.child.hide();
	            tr.removeClass('shown');

	         	$(this).find('i').removeClass('minus');
	         	$(this).find('i').addClass('plus');
	        }
	        else {
	            rows.child(format(nilai)).show();
	            tr.addClass('shown');

	            $(this).find('i').removeClass('plus');
	         	$(this).find('i').addClass('minus');
	        }

	    });

	    $.fn.dataTable.ext.errMode = 'none';

	    $('#listTable').on( 'error.dt', function ( e, settings, techNote, message ) {
	    	console.log( 'An error has been reported by DataTables: ', message );
	    }) ;

	});
</script>