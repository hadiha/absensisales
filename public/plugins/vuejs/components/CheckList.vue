<template lang="html">
    <template v-for="item in items">
        <div class="field">
            <div class="ui toggle checkbox">
                <input :checked="(item.status == 1 || state == true) ? true : false" type="checkbox" :name="name + '[' + item.id + ']'">
                <label>{{ item.date }}</label>
            </div>
        </div>
    </template>
</template>

<script>
export default {
  data() {
    return {
      state: false,
      items: []
    }
  },
  props: {
    name: {},
    itemKey: {},
    value: {
      default: false,
    },
    mode: {
        default: 'one',
    },
    label: {},
  },
  computed: {},
  events: {
      'vue-component:all-data': function (data) {
          if (this.mode === 'all') {
              this.items = data
          } else {
              console.log(data, this.itemKey)
              this.items = data[this.itemKey]
          }
      }
    },
  methods: {
    toggle() {
      this.state = $(this.$el).find('.ui.checkbox').checkbox('is checked')
      this.broadcastState()
    },

    turnOn() {
      $(this.$el).find('.ui.checkbox').checkbox('check')
      this.toggle()
    },

    turnOff() {
      $(this.$el).find('.ui.checkbox').checkbox('uncheck')
      this.toggle()
    },

    broadcastState() {
      this.$dispatch('switch:state-updating', this.name, this.state)
    },

    init() {
      const self = this
      $(self.$el).find('.ui.checkbox').on('change', function() {
        self.toggle()
      })
      if (this.state) {
        $(self.$el).find('.ui.checkbox').checkbox('check')
      }
    },
  },
  ready() {
    this.state = this.value ? true : false
    this.init()
  }
}
</script>
