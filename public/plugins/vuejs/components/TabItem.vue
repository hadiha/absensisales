<template lang="html">
    <div v-show="active" class="ui {{ position }} attached segment">
        <div v-if="remote" class="remote-content"></div>
        <div v-else>
            <slot></slot>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            position: 'top',
            cached: false,
        };
    },
    props: {
        title: {},
        icon: {},
        remote: {},
        caching: {
            default: false,
        },
        active: {
            default: false,
        }
    },
    events: {
        'tab.activation': function(msg) {
            if (this.remote) {
            }
            if (this.title === msg) {
                this.active = true
                this.onActive()
            } else {
                this.active = false
            }
        }
    },
    methods: {
        onActive() {
            if (!this.cached) {
                if (this.remote) {
                    if (this.cleanup) {
                        this.cleanup()
                    }
                    $(this.$el).find('.remote-content').html("<div class='ui very basic segment' style='padding: 30px !important'><div class='ui inverted active dimmer'><div class='ui text loader'>Loading</div></div></div>")
                    this.$http.get(this.remote).then((response) => {
                        $(this.$el).find('.remote-content').html(response.body)
                        this.cleanup = this.$compile($(this.$el).get(0))
                        if (this.usingCache()) {
                            this.cached = true
                        }
                        $('body').initElement()
                    })
                }
            }
        },

        setPosition(position) {
            this.position = position == 'top' ? 'bottom': 'top'
            this.position = position == 'vertical' ? 'right' : this.position
        },

        isActive() {
            return this.active !== false;
        },

        usingCache() {
            return this.caching !== false;
        }
    },
    ready: function() {
        this.$dispatch('tab-created', this, this.title)
    },
};
</script>

<style lang="css">
</style>
