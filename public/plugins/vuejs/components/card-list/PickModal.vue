<template>
	<div class="ui pick modal">
		<div class="header">
			Pilih Barang
            <button type="button" @click="close()" class="ui negative mini right floated icon button">
                <i class="delete icon"></i>
            </button>
		</div>
        <div class="content">
            <div class="form-element">
	            <table-container base-url="{{ $baseUrl }}" api-url="{{ $apiUrl }}">
			        <filter-box :advanced-only="true">
			        	<div class="ui form">
				            <div class="three fields">
				                <div class="field">
				                    <label>Kode Barang </label>
				                    <input type="text" name="kode_alat" autofocus>
				                </div>
				                <div class="field">
				                    <label>Nama Barang</label>
				                    <input type="text" name="nama">
				                </div>
				                <div class="field">
				                    <label>Gudang</label>
				                    <synced-select name="id_gudang" identifier="id_gudang" display="nama" api-url="{{$warehouseUrl}}"> </synced-select>
				                </div>
				            </div>
			        	</div>
			       	</filter-box>
		            <vuetable
			           :api-url="apiUrl"
			           :fields='[
			                {"name":"__sequence","title":"No","dataClass":"collapsing single line","titleClass":"collapsing"},
			                {"name":"kode_alat","title":"Kode Barang"},
			                {"name":"nama","title":"Nama Barang"},
			                {"name":"warehouse.nama","title":"Gudang"},
			                {"name":"condition.keterangan","title":"Kondisi"},
			                {"name":"__component:pick-btn","title":"Aksi"}
			            ]'
			            
			           :append-params="[
			            'includes=condition,warehouse'
			           ]"
			           data-path="data"
			           pagination-path=""
			       	></vuetable>
		       	</table-container>
            </div>
        </div>
    </div>
</template>

<script>
	export default {
		data() {
			return {
				items: {},
			}
		},
		events: {
			'card-list:add-item': function(items){
				this.items = items
				this.show();
			},
			'modal:close': function() {
				this.close()
			}
		},
		ready() {
		    const self = this
			$(function () {
				$(self.$el).modal()
			})
		},
		methods: {
			close() {
				$(this.$el).modal('hide');
			},
			show() {
				const self = this
				const filters = {
					items: _.map(this.items, function (item) {
						return item[self.identifier]
					})
				}

				this.$broadcast('vuetable:filter', filters)
				$(this.$el).modal('show');
			}
		},
		props: {
			apiUrl: {
				required: true
			},
			identifier: {
				default: 'kode_alat'
			}
		},
		components: {
		}
	}
</script>
