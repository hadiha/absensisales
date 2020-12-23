<template lang="html">
    <div class="ui {{ class }} modal">
        <div v-if="type == 'alert'" class="ui icon header">
          <i v-if="icon" class="{{ icon }} icon"></i>
          {{ processedTitle }}
        </div>
        <div v-else class="header">
            <i v-if="icon" class="{{ icon }} icon"></i>
            {{ processedTitle }}

            <button v-show="isClosable()" @click="close()" class="ui negative mini right floated icon button">
                <i class="delete icon"></i>
            </button>
        </div>
        <div v-if="type !== 'nobody'" class="content">
            <div v-if="errorLength > 0" class="ui  error message" transition="hide">
                <i class="close icon" v-on:click="closeError()"></i>
                <div class="content">
                    <div class="header">{{ errorTitle }}</div>
                    <ul class="list">
                        <li v-for="err in msgErrors">{{ err }}</li>
                    </ul>
                </div>
            </div>
            <form>
                <input type="hidden" name="id" v-model="modalId">
                <div class="form-element">
                    <slot></slot>
                </div>
            </form>
        </div>
        <div class="actions">
            <button type="button" v-for="act in action" @click="invoke(act, $index)" :disabled="act.disabled" :class="'ui ' + act.class + ' button right floated'">
                <i v-if="act.icon" class="{{ act.icon }} icon"></i>
                {{{ act.title }}}
            </button>
        </div>
    </div>
</template>

<script scoped>
import Fillable from './mixins/FillableMixins.js'

export default {
  mixins: [Fillable],
  data() {
    return {
      msgErrors: {},
      modalId: 0,
      titleReplacement: '',
    };
  },
  computed: {
    processedTitle: function () {
      return this.titleReplacement ? this.titleReplacement : this.title
    },
    errorLength: function() {
      return Object.keys(this.msgErrors).length
    },
  },
  attached() {},
  methods: {
    invoke: function(action, index) {
      action._index = index
      if (action.action) {
        if (typeof action.action === 'string') {
          this[action.action](action)
        } else {
          this[action.action.name](action.action.params, action)
        }
      }
    },

    isClosable() {
      return this.closable;
    },

    parseRedirection(url, id) {
      return url.replace('#id', id)
    },

    closeError(){
      this.msgErrors = {}
    },

    submit: function(action) {
      const self = this
      const putterString = this.modalId ? '/' + this.modalId : ''
      const target = action.target + putterString
      const data = new FormData($(this.$el).find('form')[0])
      const title = action.title
      let redirection = action.redirection ? action.redirection : false
      const verb = this.modalId ? 'put' : 'post'

      let dummy = JSON.parse(JSON.stringify(action))
      dummy.disabled = true
      dummy.title = "<i class='refresh icon'></i> Please Wait..."

      this.action.$set(action._index, dummy)

      if (verb == 'put') {
        data.append('_method', 'PUT')
      }

      this.$http.post(target, data).then((response) => {
        let successMessage = this.modalId ? 'Data has been modified.' : 'Data has been added.'

        if (response.data.msg) {
          successMessage = response.data.msg
        }
        self.msgErrors = {}
        $(this.$el).find('form')[0].reset()
        self.$dispatch('modal:submitted')
        self.close()
        self.$dispatch(
          'pop-message',
          'success',
          'Transaksi data berhasil!',
          successMessage
        )

        dummy.title = title
        dummy.disabled = false
        this.action.$set(action._index, dummy)
        if (redirection) {
          redirection = this.parseRedirection(redirection, response.data.id)
          window.location.href = redirection
        }
      }, (response) => {
        try {
          const err = JSON.parse(response.body)
          this.msgErrors = err

        } catch (err) {
          this.msgErrors = ["ID atau NIP telah digunakan."]
        }

        dummy.title = title
        dummy.disabled = false
        this.action.$set(action._index, dummy)
      })
    },
    show: function() {
      this.msgErrors = []
      this.$broadcast('syncedselect:reload')
      $(this.$el).modal('show')
    },
    close: function() {
      this.titleReplacement = ''
      $(this.$el).modal('hide')
      this.clearData()
    },
    clearData: function() {
      this.modalId = 0
      this.msgErrors = {}
      const self = this
      const els = $(this.$el).find('.form-element :input')

      _.each(els, function(el) {
        if (!$(el).hasClass('permanently')) {
          $(el).val('')
        }
        self.$broadcast('vue-component:change', el.name, '')
      })
    },
    populateData: function(data) {
      const els = $(this.$el).find('.form-element :input')
      const self = this

      self.$broadcast('vue-component:all-data', data)
      this.fillElements(els, data)
      this.modalId = data.id
    },
    deleteConfirm: function(action) {
      this.$dispatch('vuetable:action', 'delete-confirmed', {
        id: action.id
      })
      this.close()
    },
    statusConfirm: function(action) {
      this.$dispatch('vuetable:action', 'status-confirmed', {
        id: action.id
      })
      this.close()
    },
  },
  ready() {
    $(this.$el).modal('setting', 'closable', this.isClosable())
    _.map(this.action.reverse(), (data) => {
      data.disabled = false
    })
  },
  components: {},
  events: {
    'modal:close': function(prefix) {
      if (prefix == this.eventPrefix) {
        this.close()
      }
    },
    'modal:show': function(prefix, data) {
      if (prefix == this.eventPrefix) {
        if (data) {
          this.populateData(data)
          if (data['_meta'] && data['_meta'].title) {
            this.titleReplacement = data['_meta'].title
          }
        }

        this.show()
      }
    },
  },
  props: {
    title: {},
    type: {
      default: 'default'
    },
    eventPrefix: {},
    errorTitle: {
      default: 'Peringatan! Terdapat kesalahan dalam isian anda!'
    },
    icon: {},
    action: {},
    class: {},
    closable: {
      default: false
    },
  }
};
</script>

<style lang="css">
  .actions:after {
    content: "";
    display: table;
    clear: both;
  }
</style>
