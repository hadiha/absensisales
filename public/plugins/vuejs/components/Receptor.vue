<template lang="html">
    <div v-visible="state">
        <slot></slot>
    </div>
</template>

<script>
export default {
    data () {
        return {
            state: false
        }
    },
    computed: {},
    props: {
        trigger: {},
    },
    mounted () {},
    methods: {
        updateState(state) {
            this.state = state
        }
    },
    components: {},
    events: {
        'switch:state-updated': function (name, state) {
            if (name === this.trigger) {
                this.updateState(state)
            }
        }
    },
}
</script>

<style lang="css">
</style>
