function slugify(text)
{
  return text.toString().toLowerCase()
    .replace(/\s+/g, '-')           // Replace spaces with -
    .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
    .replace(/\-\-+/g, '-')         // Replace multiple - with single -
    .replace(/^-+/, '')             // Trim - from start of text
    .replace(/-+$/, '');            // Trim - from end of text
}

function toggleSidebar() {
	if($('.pusher').hasClass('first-shown')) { $('.pusher').removeClass('first-shown') }

	if($('.ui.sidebar').sidebar('is hidden')){
          // alert('is no')
          $('.pusher').addClass('shown')
          $('.ui.sidebar')
          .sidebar({
          	dimPage: false,
          	closable: false
          })
          .sidebar('show');
      }else{
        // alert('no u')
        $('.pusher').removeClass('shown')
        $('.ui.sidebar')
        .sidebar({
        	dimPage: false,
        	closable: false
        })
        .sidebar('hide');
    }
}

$(document).ready(function() {
	$('.pusher').addClass('shown')
	$('.ui.sidebar')
		.sidebar({
			dimPage: false,
			closable: false
		})
		.sidebar('show');

	// initialize and add onChange event
	$('.ui.dropdown').dropdown({
		onChange: function(value) {
			var target = $(this).dropdown();
			if (value!="") {
				target
				.find('.dropdown.icon')
				.removeClass('dropdown')
				.addClass('delete')
				.on('click', function() {
					target.dropdown('clear');
					$(this).removeClass('delete').addClass('dropdown');
					return false;
				});
			}
		}
	});
	
	// force onChange  event to fire on initialization
	$('.ui.dropdown')
		.closest('.ui.selection')
		.find('.item.active').addClass('qwerty').end()
		.dropdown('clear')
		.find('.qwerty').removeClass('qwerty')
		.trigger('click');

	$('.message .close').on('click', function() {
		$(this).closest('.message').transition('fade');
	});

	$('.ui.accordion').accordion();

	$('.ui.sidebar > div').slimScroll({
		size: '5px',
		height: '100%'
	});
	setTimeout( function(){
		$('#cover').fadeOut('400');
	}, 500)
	

	$('.card').find('.three.buttons').slideUp(1)
	$('.layout.buttons button').tab()
	// $('table').tablesort()
	$('.filter .rangestart').calendar({
		type: 'date',
        text: {
          months: ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"],
        },
		endCalendar: $('.filter .rangeend')
	});
	$('.filter .rangeend').calendar({
		type: 'date',
        text: {
          months: ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"],
        },
		startCalendar: $('.filter .rangestart')
	});

	$('a.card').hover(function() {
		$(this).find('.three.buttons').slideDown(100)
	}, function(){
		$(this).find('.three.buttons').slideUp(100)
	});
});

$(document).on('click', '.ui.file.input input:text, .ui.button.file', function(e) {
	$(e.target).parent().find('input:file').click();
});

$(document).on('change', '.ui.file.input input:file', function(e) {
	var file = $(e.target);
	var name = '';
	var fieldName = $(this).attr('name');
	var res = fieldName.split("[]");
	for (var i=0; i<e.target.files.length; i++) {
		name += e.target.files[i].name + ', ';
		var fileDate = new Date(e.target.files[i].lastModified);
		var day = fileDate.getDate();
		var month = fileDate.getMonth();
		var year = fileDate.getFullYear();
		var hours = fileDate.getHours();
		var minutes = fileDate.getMinutes();
		var seconds = fileDate.getSeconds();

		if(day.toString().length == 1)
		{
			day = '0' + day.toString();
		}

		if(month.toString().length == 1)
		{
			month = '0' + month.toString();
		}

		if(hours.toString().length == 1)
		{
			hours = '0' + hours.toString();
		}

		if(minutes.toString().length == 1)
		{
			minutes = '0' + minutes.toString();
		}

		if(seconds.toString().length == 1)
		{
			seconds = '0' + seconds.toString();
		}

		if ($('input[name="'+res[0]+'_taken['+i+']"]').length != 0)
		{
			$('input[name="'+res[0]+'_taken['+i+']"]').remove();
		}
		var date = e.target.files[i];
		input = `<input type="hidden" name="`+res[0]+`_taken[`+i+`]" value="`+year+`-`+month+`-`+day+` `+hours+`:`+minutes+`:`+seconds+`">`;
		$(this).append(input);
	}
	// remove trailing ","
	name = name.replace(/,\s*$/, '');
	$('input:text', file.parent()).val(name);
});

$(document).on('click', '.ui.action.input:not(.disabled) input:text, .ui.action.input:not(.disabled) .ui.button', function (e) {
    $('input:file', $(e.target).parents()).click();
});

$(document).on('change', '.ui.action.input:not(.disabled) input:file', function (e) {
    var name = e.target.files[0].name;
    $('input:text', $(e.target).parent()).val(name);
});
