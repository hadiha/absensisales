<template lang="html">
    <div v-show="show" :class="'ui icon ' + type +' message'">
        <i v-show="icon" :class="icon + ' icon'"></i>
        <i class="close icon" @click="close()"></i>
        <div class="content">
            <div class="header">{{ title }}</div>
            <p>
                {{ body }}
            </p>
        </div>
    </div>
</template>

<script>
export default {
    data () {
        return {}
    },
    computed: {
        icon: function () {
            switch (this.type) {
                case 'error': return 'delete'; break;
                case 'success': return 'check'; break;
                default: return ''; break;
            }
        },
    },
    ready () {},
    attached () {},
    methods: {
        close: function () {
            this.show = false
        },
    },
    events: {
        'message:pop': function (type, title, body) {
            this.type = type
            this.title = title
            this.body = body
            this.show = true
        },
    },
    props: {
        type: {
            default: 'success',
        },
        show: {
            default: false,
        },
        title: {},
        body: {},
    },
    components: {}
}
</script>

<style lang="css">
</style>
