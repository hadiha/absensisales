<template lang="html">
    <div>
        <div class="ui four stackable special cards">
            <div class="blurring dimmable fluid card" v-for="item in items">
                <div class="ui dimmer">
                    <div class="content">
                        <div class="center">
                            <button type="button" @click="cancelling(item)" class="ui inverted red icon button"><i class="icon remove"></i> Batalkan</button>
                        </div>
                    </div>
                </div>
                <div class="content">
                    <input type="hidden" :name="name+'[]'" :value="item[identifier]">
                    <input type="hidden" :name="status+'[]'" :value="item[identifier_status]">
                    <div class="right floated meta">{{ item[fields.qty] }}</div>
                    <div class="header">
                        {{ item[fields.code] }}
                    </div>
                    <div class="meta">
                        <div v-if="item[fields.status] == 2">
                            <p style="color:red;">{{ item[fields.name] }}</p>
                        </div>
                        <div v-else>
                            <p style="color:black;">{{ item[fields.name] }}</p>
                        </div>
                    </div>
                </div>
                <div class="image">
                    <img :src="imageUrl + '/' + item[fields.image]">
                </div>
                <div v-if="advanced !== null" class="extra content">
                    <slot></slot>
                </div>
            </div>
            <div v-if="justList === null" class="new card">
                <button type="button" @click="add()" class="ui inverted blue icon button">
                    <i class="icon add"></i> Tambah Barang
                </button>
            </div>
        </div>

        <cancel-modal></cancel-modal>
        <pick-modal :identifier="identifier" :api-url="apiUrl"></pick-modal>
    </div>
</template>

<script>
export default {
  props: {
    alat:{
        default:null
    },
    advanced: {
        default: null
    },
    justList: {
        default: null
    },
    cancelable: {
        default: true
    },
    apiUrl: {
        required: true
    },
    imageUrl: {
        default: ''
    },
    name: {
        required: true
    },
    status: {
        required: true
    },
    identifier: {
        default: "kode_alat"
    },
    identifier_status: {
        default: "status"
    },
    fields: {
        default: function () {
            return {
                code: 'code_cleaned',
                name: 'nama',
                image: 'foto',
                qty: 'qty',
                status : "status"
            }
        }
    },
    data: {
        default: function () {
            return []
        }
    },
  },
  data() {
    return {
      cancelModal: null,
      items: [],
      selected: 0,
      conditions: {},
    }
  },
  events: {
    'card-list:cancel-deny': function () {
        this.selected = null
    },
    'card-list:canceled': function () {
        this.approveDelete()
    },
    'pick-btn:picked': function(item) {
        if($(".daftar_alat").length){ 
            $(".daftar_alat").hide()
        }
        item.status = 1
        this.items.push(item)
        const self = this
        this.$nextTick(function () {
            self.refreshDom()
        })
    },
    'pick-btn:installed': function(item) {
        if($(".daftar_alat").length){ 
            $(".daftar_alat").hide()
        }
        item.status = 2
        this.items.push(item)
        const self = this
        this.$nextTick(function () {
            self.refreshDom()
        })
    }
  },
  watch: {
  },
  ready() {
    const self = this
    self.items = self.data

    $(function () {
        self.refreshDom()
    })
  },
  methods: {
    refreshDom() {
        if(this.cancelable){
            $(this.$el).find('.dimmable.card').dimmer({
              on: 'hover'
            })
        }
    },
    add() {
        this.$broadcast('card-list:add-item', this.items)
    },
    cancelling(item) {
        this.selected = item
        this.$broadcast('card-list:cancel', this.selected)
    },
    approveDelete() {
        const self = this
        self.items = _.filter(self.items, function (item) {
            console.log(item, self.selected)
            if (item == self.selected) {
                return false
            }

            return true
        })
    },
  },
  components: {
    CancelModal: require('./card-list/CancelModal.vue'),
    PickModal: require('./card-list/PickModal.vue')
  }
}
</script>

<style lang="css" scoped>
    .new.card{
        box-shadow: none !important;
    }
    .new.card .button {
        width: 100% !important;
        height: 100% !important;
        text-align: center;
        vertical-align: middle;
    }
</style>
