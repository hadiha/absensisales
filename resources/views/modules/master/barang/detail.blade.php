@extends('layouts.form')

@section('css')
@append

@section('js')
@append

@section('scripts')
<script type="text/javascript">
	$(document).on('click', '.vertical.all', function(e){
		e.preventDefault();
		var container 	= $(this).closest('thead');
		var action 		= $(this).data('action');
		var selector	= $('.'+action+'.check');
		var checked		= true;
		
		container.next('tbody').find(selector).each(function(e){
			checked = !$(this).prop('checked') ? false : checked;
			// $(this).prop('checked', !$(this).prop('checked'));
		});

		container.next('tbody').find(selector).prop('checked', !checked);
	});

	$(document).on('click', '.horizontal.all', function(e){
		e.preventDefault();
		var container 	= $(this).closest('tr');
		var selector	= $('.check');
		var checked		= true;
		
		container.find(selector).each(function(e){
			checked = !$(this).prop('checked') ? false : checked;
			// $(this).prop('checked', !$(this).prop('checked'));
		});

		container.find(selector).prop('checked', !checked);
	});
</script>
@append

@section('content-body')
	<form id="dataForm" action="{{ url($pageUrl.$record->id.'/grant') }}" class="ui form" method="POST">
		{!! csrf_field() !!}
		<input type="hidden" name="_method" value="PUT">
		<table class="ui small compact blue table">
			<thead>
				<tr>
					<th><i class="sidebar icon"></i> Menu</th>
					<th class="center aligned">View</th>
					<th class="center aligned">Add</th>
					<th class="center aligned">Edit</th>
					<th class="center aligned">Delete</th>
					<th class="center aligned"></th>
				</tr>
			</thead>
			@foreach($mainMenu->roots() as $item)
			@php
				$perms = \App\Models\Authentication\Permission::where('name', 'like', $item->perms.'%')->get();
			@endphp
			<thead>
				<th><i class="{{ $item->icon }} icon"></i> {!! $item->title !!}</th>
				<th class="center aligned">
					@if($item->hasChildren())
						<button type="button" class="ui vertical all mini button" data-action="view"><i class="checkmark icon"></i> View All</button>
					@else
						@if($p = $perms->where('name', $item->perms.'-view')->first())
						<div class="ui fitted checkbox">
						  <input name="check[]" class="view check" type="checkbox" value="{{ $p->id }}" @if($record->hasPermission($item->perms.'-view')) checked @endif>
						  <label></label>
						</div>
						@endif
					@endif
				</th>
				<th class="center aligned">
					@if($item->hasChildren())
						<button type="button" class="ui vertical all mini button" data-action="add"><i class="checkmark icon"></i> Add All</button>
					@else
						@if($p = $perms->where('name', $item->perms.'-add')->first())
						<div class="ui fitted checkbox">
						  <input name="check[]" class="add check" type="checkbox" value="{{ $p->id }}" @if($record->hasPermission($item->perms.'-add')) checked @endif>
						  <label></label>
						</div>
						@endif
					@endif
				</th>
				<th class="center aligned">
					@if($item->hasChildren())
						<button type="button" class="ui vertical all mini button" data-action="edit"><i class="checkmark icon"></i> Edit All</button>
					@else
						@if($p = $perms->where('name', $item->perms.'-edit')->first())
							<div class="ui fitted checkbox">
							  <input name="check[]" class="edit check" type="checkbox" value="{{ $p->id }}" @if($record->hasPermission($item->perms.'-edit')) checked @endif>
							  <label></label>
							</div>
						@endif
					@endif
				</th>
				<th class="center aligned">
					@if($item->hasChildren())
						<button type="button" class="ui vertical all mini button" data-action="delete"><i class="checkmark icon"></i> Delete All</button>
					@else
						@if($p = $perms->where('name', $item->perms.'-delete')->first())
							<div class="ui fitted checkbox">
							  <input name="check[]" class="delete check" type="checkbox" value="{{ $p->id }}" @if($record->hasPermission($item->perms.'-delete')) checked @endif>
							  <label></label>
							</div>
						@endif
					@endif
				</th>
				<th class="center aligned">
					@if(!$item->hasChildren())
						<button type="button" class="ui horizontal all mini button"><i class="checkmark icon"></i> Check All</button>
					@endif
				</th>
			</thead>
	        @if($item->hasChildren())
	        	<tbody>
				@foreach($item->children() as $child)
					@php
						$perms = \App\Models\Authentication\Permission::where('name', 'like', $child->perms.'%')->get();
					@endphp
					<tr>
						<td><b><i class="{{ $child->icon }} icon"></i> {!! $child->title !!}</b></td>
						<td class="center aligned">
							@if($p = $perms->where('name', $child->perms.'-view')->first())
							<div class="ui fitted checkbox">
							  <input name="check[]" class="view check" type="checkbox" value="{{ $p->id }}" @if($record->hasPermission($child->perms.'-view')) checked @endif>
							  <label></label>
							</div>
							@endif
						</td>
						<td class="center aligned">
							@if($p = $perms->where('name', $child->perms.'-add')->first())
							<div class="ui fitted checkbox">
							  <input name="check[]" class="add check" type="checkbox" value="{{ $p->id }}" @if($record->hasPermission($child->perms.'-add')) checked @endif>
							  <label></label>
							</div>
							@endif
						</td>
						<td class="center aligned">
							@if($p = $perms->where('name', $child->perms.'-edit')->first())
							<div class="ui fitted checkbox">
							  <input name="check[]" class="edit check" type="checkbox" value="{{ $p->id }}" @if($record->hasPermission($child->perms.'-edit')) checked @endif>
							  <label></label>
							</div>
							@endif
						</td>
						<td class="center aligned">
							@if($p = $perms->where('name', $child->perms.'-delete')->first())
							<div class="ui fitted checkbox">
							  <input name="check[]" class="delete check" type="checkbox" value="{{ $p->id }}" @if($record->hasPermission($child->perms.'-delete')) checked @endif>
							  <label></label>
							</div>
							@endif
						</td>
						<td class="center aligned">
							<button type="button" class="ui horizontal all mini button"><i class="checkmark icon"></i> Check All</button>
						</td>
					</tr>
	        	@endforeach
	        	</tbody>
	        @endif
			@endforeach
			<tfoot>
				<tr>
					<th colspan="6">
						<a href="{{ url($pageUrl) }}" class="ui button">
							<i class="left angle icon"></i> Kembali
						</a>
						<button type="button" class="ui blue right floated save page button">
							<i class="save icon"></i> Simpan
						</button>
					</th>
				</tr>
			</tfoot>
		</table>
	</form>
@endsection