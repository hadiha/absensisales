<template lang="html">
    <div class="ui fluid card">
      <div class="image">
          <img :src="photo" :id="id">
      </div>
      <div class="content">
          <div class="header">{{ name }}</div>
          <div class="meta">{{ title }}</div>
      </div>
      <div class="ui vertical menu extra content">
          <slot></slot>
      </div>
  </div>
</template>

<script>
export default {
  data () {
    return {}
  },
  computed: {},
  ready () {},
  attached () {},
  methods: {},
  props: [
      'photo',
      'id',
      'name',
      'title',
  ],
  components: {}
}
</script>

<style lang="css" scoped>
    .extra.content {
        padding: 0;
    }
</style>
