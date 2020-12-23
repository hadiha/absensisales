<template>
	<div class="ui basic cancel modal">
        <div class="ui icon header">
          <i class="trash icon"></i>
          Batal Tambah Barang
        </div>
        <div class="content">
            <div class="form-element">
                <p>Anda yakin ingin membatalkan penambahan barang ini?</p>
            </div>
        </div>
        <div class="actions">
            <button type="button" class="ui inverted deny button">
                <i class="remove icon icon"></i>
                Tidak
            </button>
            <button type="button" class="ui inverted red approve button">
                <i class="checkmark icon icon"></i>
                Ya
            </button>
        </div>
    </div>
</template>

<script>
	export default {
		events: {
			'card-list:cancel': function () {
				$(this.$el).modal('show')
			}
		},

		ready() {
		    const self = this
			$(function () {
				$(self.$el).modal({
		            onApprove: function () {
						self.$dispatch('card-list:canceled')
		            },
		            onDeny: function () {
						self.$dispatch('card-list:cancel-deny')
		            }
		        })
			})
		}
	}
</script>
