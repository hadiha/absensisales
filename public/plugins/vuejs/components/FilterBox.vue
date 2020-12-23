<template lang="html">
    <div>
        <template v-if="!advancedOnly">
            <div style="text-align: right; margin-bottom: 10px" >
                <div class="ui input">
                    <input :disabled="show" v-model="searchField" @keyup.enter="search()" type="text" placeholder="{{ placeholder }}">
                </div>
                <div class="ui blue buttons">
                    <button :disabled="show" type="button" @click="search()" class="ui button">
                        <i class="search icon"></i>
                        Cari
                    </button>
                    <button type="button" :disabled="show" v-if="usingAdvanced" class="ui icon dropdown button">
                        <i class="dropdown icon"></i>
                        <div class="menu">
                            <div @click="toggle()" class="item">Pencarian Lanjut</div>
                        </div>
                    </button>
                </div>
                <button @click="reset()" type="button" class="ui button">Reset</button>
            </div>
            <div style="margin-bottom: 10px" v-if="!show" class="clear"></div>
            <div v-else class="clear"></div>
        </template>
        <div v-if="usingAdvanced || advancedOnly" v-show="show || advancedOnly" class="ui segment">
            <form>
                <slot></slot>
                <div class="clear"></div>
                <button type="button" @click="advanced()" class="ui yellow right floated button">
                    <i class="ui search icon"></i>
                    Cari
                </button>
                <button v-if="!advancedOnly" type="button" @click="cancel()" class="ui right floated button">
                    Batal
                </button>
                <button v-else type="reset" class="ui right floated button">Reset</button>
                <div class="clear"></div>
            </form>
        </div>
        <div style="margin-bottom: 10px" v-if="advancedOnly" class="clear"></div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            show: false,
            searchField: '',
        };
    },
    computed: {},
    ready() {
      const self = this
      $(this.$el).find(':input').on('keyup', function (e) {
        if(e.which == 13) {
          self.search()
        }
      })
    },
    attached() {},
    methods: {
        toggle() {
            this.show = !this.show
        },
        search() {
          console.log('cheeki breeki')
            this.$dispatch('filterbox:search-evoked', this.searchField)
        },
        advanced() {
            const data = $(this.$el).find('form').serializeObject()
            this.$dispatch('filterbox:filter-evoked', data)
        },
        reset() {
            this.searchField = ''
            this.cancel()
        },
        cancel() {
            this.show = false
            this.search()
        }
    },
    components: {},
    props: {
        usingAdvanced: {
            default: false
        },
        advancedOnly: {
            default: false
        },
        placeholder: {
            default: 'Cari...'
        }
    }
};
</script>

<style lang="css">
</style>
