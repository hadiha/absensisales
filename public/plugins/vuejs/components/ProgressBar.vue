<template lang="html">
    <div>
        <div v-if="title" class="ui sub header">
            <div class="content">
                {{ title }}
            </div>
        </div>
        <div :class="'ui error ' + color + ' ' + size + ' progress'" :data-value="value" :data-total="total">
            <div class="bar"></div>
            <div class="label">{{ value }} / {{ total }}</div>
        </div>
    </div>
</template>

<script scoped>
export default {
    data () {
        return {}
    },
    computed: {},
    ready () {
        $('.ui.progress').progress()
    },
    attached () {},
    methods: {},
    props: [
        {
            name: 'value',
            default: 0,
        },
        {
            name: 'total',
            default: 0,
        },
        {
            name: 'size',
            default: '',
        },
        {
            name: 'title',
            default: null,
        },
        {
            name: 'color',
            default: '',
        },
    ],
    components: {}
}
</script>

<style lang="scss" scoped>
    .ui.sub.header {
        font-size: 14px;
        font-weight: normal;
        text-transform: none;
        line-height: 1;
    }
</style>
