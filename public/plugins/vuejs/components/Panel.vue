<template lang="html">
    <div class="ui segments">
        <div class="ui top attached main header menu">
            <div v-if="icon">
                <i class="{{ icon }} icon"></i>
                <div class="content">
                    {{ title }}
                </div>
            </div>
            <span v-else>
                {{ title }}
            </span>
            <div v-if="righttitle" class="right menu">
              <p class="black">{{ righttitle }}</p>
            </div>
        </div>

        <div class="ui bottom attached segment">
            <slot></slot>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {};
    },
    computed: {},
    ready() {},
    attached() {},
    methods: {},
    components: {},
    props: ["title","icon",'righttitle']
};
</script>

<style lang="css">
</style>
