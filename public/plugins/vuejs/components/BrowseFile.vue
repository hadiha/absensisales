<template lang="html">
    <div class="ui action input">
        <input v-model="file" name="{{ name }}" type="file" style="display: none">
        <input v-model="filename" type="text" readonly>
        <button @click="browse()" type="button" class="ui teal right button">
            Browse
        </button>
    </div>
</template>

<script>
export default {
    data () {
        return {
            filename: "Browse...",
            file: "",
        }
    },
    props: {
        name: {
            required: true,
        },
    },
    computed: {},
    methods: {
        browse() {
            $(this.$el).find('[type=file]').trigger('click')
        },
        notifyFileInput(event) {
            this.filename = event.target.files[0].name
        }
    },
    ready() {
      const self = this
        $(this.$el).find('[type=file]').change(function (event) {
          self.notifyFileInput(event)
          self.$dispatch('browse-file:change', event.target.files[0])
        });
    }
}
</script>

<style lang="css">
</style>
