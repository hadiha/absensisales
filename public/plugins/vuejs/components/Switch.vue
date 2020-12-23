<template lang="html">
    <div>
        <div class="ui toggle checkbox">
            <input :checked="state" type="checkbox" :name="name">
            <label v-if="label">{{ label }}</label>
        </div>
    </div>
</template>

<script>
export default {
  data() {
    return {
      state: false,
    }
  },
  props: {
    name: {},
    value: {
      default: false,
    },
    label: {},
  },
  computed: {},
  events: {
    'vue-component:change': function(name, value) {
      if (name === this.name) {
        if (value) {
          this.turnOn()
        } else {
          this.turnOff()
        }
      }
    },
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
