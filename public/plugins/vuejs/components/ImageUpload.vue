<template lang="html">
	<div class="blurring dimmable image-container">
        <div class="ui dimmer">
            <div class="content">
                <div class="center">
                    <button type="button" v-if="removeable" @click="removeImage()" class="ui inverted red icon button"><i class="remove icon"></i> Hapus</button>
                    <button type="button" @click="browse()" class="ui inverted green icon button"><i class="clone icon"></i> Ubah</button>
                </div>
            </div>
        </div>
	    <img class="ui fluid image" :src="image"/>
	    <div class="ui input">
	        <input v-model="file" :name="name" type="file" style="display: none" @change="onFileChange" accept="image/*">
	        <input v-model="filename" type="text" readonly>
			<!--div class="ui buttons">
				<button v-if="removeable" @click="removeImage()" type="button" class="ui red right vertical animated button remove">
					<div class="hidden content">Hapus</div>
					<div class="visible content">
						<i class="remove icon"></i>
					</div>
				</button>
		        <button @click="browse()" type="button" class="ui teal right button">
		            Cari
		        </button>
			</div-->
	    </div>
	</div>
</template>

<script>
	export default{
		data: function(){
			return {
				removeable: false,
				filename: '',
				image: '',
			}
		},
		ready () {
			const self = this
			this.image = this.value

		    $(function () {
		        self.refreshDom()
		    })
		},
		props: {
			name: {},
			value: {
				default: 'http://placehold.it/350x195?text=Select+Image'
			}
		},
		events: {
			'image:change' : function (path, name) {
				this.image = path + '/' + name
				this.filename = name
				this.removeable = true
			}
		},
		methods: {
		    refreshDom() {
		        $(this.$el).dimmer({
		          on: 'hover'
		        })
		    },
	        browse() {
	        	console.log(this.name, $(this.$el))
	            $(this.$el).find('[type=file]').trigger('click')
	        },
			onFileChange(e) {
				var files = e.target.files || e.dataTransfer.files;

				if (!files.length) return;

				this.createImage(files[0]);
				this.filename = e.target.files[0].name;
				this.removeable = true;
			},
			createImage(file) {
			  var image = new Image();
			  var reader = new FileReader();
			  var vm = this;

			  reader.onload = (e) => {
			    vm.image = e.target.result;
			  };
			  reader.readAsDataURL(file);
			},
			removeImage: function (e) {
				$(this.$el).find('[type=file]').val('');
				this.image = this.value;
				this.filename = '';
				this.removeable = false;
			},
		}
	}
</script>

<style lang="css">
	.image-container > .ui.image{
		border-radius: 4px 4px 0 0;
		/*border: 1px solid rgba(34,36,38,.15);
		border-bottom: none;*/
	}
	.image-container > .ui.input > input[type=text]{
		border-radius: 0 0 4px 4px;
	}
	/*.image-container .ui.action.input:not([class*="left action"])>.button:last-child,
	.image-container .ui.action.input:not([class*="left action"])>.buttons:last-child>.button,
	.image-container .ui.action.input:not([class*="left action"])>.dropdown:last-child{
		border-radius: 0;
		border-bottom-right-radius: 4px;
	}

	.image-container .ui.action .buttons {
		position: absolute;
		right: 0;
	}
	.image-container .ui.action .buttons button.remove {
		border-radius: 0!important;
	}*/
</style>
