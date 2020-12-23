<template lang="html">
    <select v-model.sync="selected" :name="name" v-bind:readonly="isReadOnly" :data-lookup-field="lookupField">
        <option v-if="usingPlaceholder" value="">{{ placeholder }}</option>
        <option :selected="opt[this.identifier] == selected" v-for="opt in items" :value="opt[this.identifier]">
            {{ opt[this.display] }}
        </option>
    </select>
</template>

<script>
import Vue from 'vue'

export default {
  props: {
    apiUrl: "",
    lookupField: {
      default: null
    },
    parents: {},
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
      default: "-- Please Choose --",
    },
    usingPlaceholder: {
      default: true,
    },
  },
  data() {
    return {
      items: [],
      selected: 0,
      conditions: {},
    }
  },
  events: {
    'syncedselect:reload': function(selected) {
      this.reinit()
    },
    'syncedselect:refresh': function(selected) {
      this.reinit(true)
    },
    'synced-select:updated': function(name, value) {
      if (_.has(this.parents, name)) {
        let conditions = this.conditions
        conditions[name] = value
        this.$set('conditions', conditions)
        this.reinit()
      }
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
      this.$dispatch('synced-select:changed', this.name, val)
        // $(this.$el).dropdown('set selected', val)
    }
  },
  ready() {
    this.reinit()
  },
  attached() {},
  methods: {
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
