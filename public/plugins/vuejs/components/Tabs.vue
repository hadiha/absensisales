<template lang="html">
    <div style="margin-bottom: 10px;" :class="(type == 'vertical') ? 'ui basic horizontal main segments' : ''">
        <div v-if="type == 'top'" class="ui {{ layout }} top attached menu">
            <div v-if="title" class="header item">
                <i v-if="icon" class="{{ icon }} icon"></i>
                <div>
                    {{ title }}
                    <span v-if="active">&middot; {{ active }}</span>
                </div>
            </div>
            <div class="{{ position }} menu">
                <a :class="( (active === tab.message) ? 'active' : '' ) + ' item'" @click="notify(tab)" v-for="tab in tabs">
                    <i v-if="tab.icon" class="{{ tab.icon }} icon"></i>
                    {{ tab.message }}
                </a>
                <div v-if="hasMore" class="ui dropdown item" :style="moreActive">
                    <i v-if="moreIcon" class="{{ moreIcon }} icon"></i>
                    <div class="content">
                        {{ moreText }}
                    </div>
                    <i class="dropdown icon"></i>
                    <div class="menu">
                        <a v-for="tab in moreTabs" :class="( (active === tab.message) ? 'active' : '' ) + ' item'" @click="notify(tab)">
                            <i v-if="tab.icon" class="{{ tab.icon }} icon"></i>
                            {{ tab.message }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="type == 'vertical'" class="ui secondary vertical pointing menu">
            <a :class="( (active === tab.message) ? 'active ' : '' ) + 'ui item'" v-for="tab in tabs" @click="notify(tab)">{{ tab.message }}</a>
        </div>
        <slot></slot>
        <div v-if="type == 'bottom'" class="ui {{ layout }} bottom attached menu">
            <div class="{{ position }} menu">
                <a :class="( (active === tab.message) ? 'active' : '' ) + ' item'" @click="notify(tab)" v-for="tab in tabs">
                    <i v-if="tab.icon" class="{{ tab.icon }} icon"></i>
                    {{ tab.message }}
                </a>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        type: {
            default: "top"
        },
        layout: {
            default: "default"
        },
        position: {
            default: "left"
        },
        title: {},
        icon: {},
        max: {
            default: 4,
        },
        placeholder: {
            default: "More",
        },
    },
    data() {
        return {
            tabs: [],
            moreTabs: [],
            tabCount: 0,
            moreText: '',
            moreIcon: null,
            hasMore: false,
            moreActive: '',
            active: '',
        };
    },
    ready() {
        this.position = this.layout == 'default' ? 'right' : this.position
    },
    events: {
        'tab-created': function (tab, msg) {
            if (this.tabCount < this.max - 1) {
                this.tabs.push({ message: msg, active: tab.isActive(), icon: tab.icon, isMore: false })
                this.tabCount++
            } else {
                this.moreTabs.push({ message: msg, active: tab.isActive(), icon: tab.icon, isMore: true })
                this.hasMore = true
            }

            if (tab.isActive()) {
                this.active = msg

                this.notify({
                    message: msg,
                    isMore: this.hasMore,
                    icon: tab.icon
                })
            }
            tab.setPosition(this.type)
        }
    },
    methods: {
        notify: function(msg) {
            this.active = msg.message
            this.$broadcast('tab.activation', msg.message)
            if (!msg.isMore) {
                this.moreText = this.placeholder
                this.moreActive = ''
                this.moreIcon = null
            } else {
                this.moreText = msg.message
                this.moreActive = 'background: white; color: black; font-weight: bold'
                this.moreIcon = msg.icon
            }
        }
    },
    computed: {},
    attached() {},
    components: {}
};

</script>
<style>
.ui.horizontal.main.segments .segment {
    padding-right: 0px;
    padding-top: 0px;
}

.ui.horizontal.main.segments .menu {
    padding-bottom: 0;
    margin-bottom: 0;
}

.ui.horizontal.main.segments .item {
    padding-left: 0;
}

</style>
<style lang="scss" scoped>
    .ui.horizontal.main.segments {
        box-shadow: 0 0 0 0 rgba(0, 0, 0, 0);
        margin-top: 0px;
        padding-top: 0px;
        border: 0;
    }

    .ui.default.menu {
        background: #F9F6F1;

    }

    .right.menu {
        .item {
            &.active {
                background: white;
                font-weight: bold;
                padding-bottom: 13px;
            }
        }
    }

    .ui.item.whiteout {
        background: white;
        font-weight: bold;
        padding-bottom: 13px;
    }

    .header.item {
        color: #555555;
        border-right: 0;
    }

    .header.item:before {
        background: rgba(0,0,0,0);
    }
</style>
