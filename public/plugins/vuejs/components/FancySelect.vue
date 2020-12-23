<template lang="html">
    <div class="ui  fluid upward dropdown labeled search icon button">
        <i :class="icon + ' icon'"></i> 
        <span class="text">{{ placeholder }}</span>
        <div class="menu">
            <div class="item" @click="setSelected(opt)" v-for="opt in items" :data-value="opt[this.identifier]">
              {{ opt[this.display] }}
            </div>
        </div>
        <input type="hidden" :name="name" :value="selected">
    </div>
</template>

<script>
import Vue from 'vue'

export default {
  props: {
    apiUrl: "",
    identifier: {
      default: "id",
    },
    display: {
      default: "name",
    },
    name: {
      required: true,
    },
    placeholder: {
      default: "Please Choose",
    },
    icon: {
      default: "cube",
    },
    selected: {
      default: null
    }
  },
  data() {
    return {
      items: [],
    }
  },
  events: {
    'fancy-select:reload': function(selected) {
      this.reinit()
    },
    'fancy-select:refresh': function(selected) {
      this.reinit(true)
    },
    'vue-component:change': function(name, value) {
      if (this.lookupField && name === this.lookupField) {
        this.selected = value
      } else if (name === this.name) {
        this.selected = value
      }
    },
  },
  watch: {
    selected: function(val, oldVal) {
      this.$dispatch('fancy-select:changed', this.name, val)
        $(this.$el).dropdown('set selected', val)
    }
  },
  ready() {
    this.reinit()
  },
  methods: {
    setSelected: function(opt) {
      this.selected = _get(opt, this.identifier)
    },
    builtUrl: function() {
      let additional = ""
      const self = this
      let count = 0

      if (_.size(this.conditions) > 0) {
        additional = "?"
      }

      _.each(this.conditions, function(val, key) {
        if (count > 0) {
          additional += "&"
        }

        let keyname = self.parents[key]

        additional += "conditions[" + keyname + "]" + "=" + val
        count++
      })

      return this.apiUrl + additional
    },
    reinit: function(reset) {
      let newOpts = new Set()
      this.$http.get(this.builtUrl()).then((response) => {
        const items = response.data.data
        const self = this

        _.each(items, function(val) {
          newOpts.add(val)
        })

        self.items = Array.from(newOpts)

        if (reset === true) {
          this.$set('selected', 0)
        }
      })

    },
  },
  components: {}
}
</script>
