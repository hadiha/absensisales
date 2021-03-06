@extends('layouts.list')

@section('filters')
	<div class="field">
		<input type="text" name="filter[code]" placeholder="Kode Klien">
	</div>
	<div class="field">
		<input type="text" name="filter[name]" placeholder="Nama Klien">
	</div>
	<button type="button" class="ui teal icon filter button" data-content="Cari Data">
		<i class="search icon"></i>
	</button>
	<button type="reset" class="ui icon reset button" data-content="Bersihkan Pencarian">
		<i class="refresh icon"></i>
	</button>
@endsection

@section('js-filters')
	d.kode = $("input[name='filter[code]']").val();
	d.name = $("input[name='filter[name]']").val();
@endsection

@section('rules')
	<script type="text/javascript">
		formRules = {
			username: 'empty',
			email: 'empty',
			roles: 'empty',
		};
	</script>
@endsection

@section('init-modal')
	<script>


        onShow = function(){
            $("input:text").click(function() {
                $(this).parent().find("input:file").click();
            });

            $('input:file', '.ui.action.input')
            .on('change', function(e) {
                var name = e.target.files[0].name;
                $('input:text', $(e.target).parent()).val(name);
            });


            // $('.checkbox').checkbox();
            // $('.ui.dropdown').dropdown({
            //     onChange: function(value) {
            //         var target = $(this).dropdown();
            //         if (value!="") {
            //             target
            //                 .find('.dropdown.icon')
            //                 .removeClass('dropdown')
            //                 .addClass('delete')
            //                 .on('click', function() {
            //                     target.dropdown('clear');
            //                     $(this).removeClass('delete').addClass('dropdown');
            //                     return false;
            //                 });
            //         }
            //     }
            // });
            // // force onChange  event to fire on initialization
            // $('.ui.dropdown')
            //     .closest('.ui.selection')
            //     .find('.item.active').addClass('qwerty').end()
            //     .dropdown('clear')
            //         .find('.qwerty').removeClass('qwerty')
            //     .trigger('click');

	        // $('[name=display_name]').on('change, keyup', function(event) {
	        //     var display_name = $(this).val();
	        //     $('[name=name]').val(slugify(display_name));
	        // });

            return false;
        };
	</script>
@endsection