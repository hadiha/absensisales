<template>
<div>
	<button type="button" class="ui green mini icon button" @click="pick()"><i class="share icon"></i></button>
	<button type="button" class="ui red mini icon button" @click="install()"><i class="configure icon"></i></button>
</div>
</template>

<script>
export default {
	template: [
		].join(''),
	props: {
		rowData: {
			type: Object,
			required: true
		}
	},
	methods: {
		pick() {
			this.$dispatch('pick-btn:picked', this.rowData)
			this.$dispatch('modal:close')
		},
		install() {
			this.$dispatch('pick-btn:installed', this.rowData)
			this.$dispatch('modal:close')
		}
	}
}
</script>
