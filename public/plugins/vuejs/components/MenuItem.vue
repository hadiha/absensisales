<template lang="html">
    <a href="{{ url }}" class="ui orange colored card">
        <div class="content">
            <h5 class="ui icon header">
                <i class="{{ icon }} icon"></i>
                <div class="content">
                    <slot></slot>
                    <div v-if="sub" class="sub header">{{ sub }}</div>
                </div>
            </h5>
        </div>
    </a>
</template>

<script>
export default {
    data() {
        return {
        };
    },
    props: {
        icon: {},
        name: {},
        sub: {
            default: '',
        },
        url: {},
    },
    computed: {},
    ready() {},
    attached() {},
    methods: {},
    components: {}
};
</script>

<style lang="css">
</style>
