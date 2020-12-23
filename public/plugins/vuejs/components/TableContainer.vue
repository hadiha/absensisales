<template lang="html">
    <div :id="id" :class="className">
        <slot></slot>
        <modal class="small" type="nobody" event-prefix="contained:" :title="deleteString" :action="[{
                title: 'No',
                class: 'ui button',
                action: 'close',
            },
            {
                title: 'Yes',
                class: 'ui red button',
                action: 'deleteConfirm',
                id: deleteId,
            }]">
        </modal>
    </div>
</template>

<script>
export default {
  data() {
    return {
      deleteString: "Are You Sure?",
      deleteId: 0,
    }
  },
  props: {
    className: {},
    lookupField: {
        default: 'id'
    },
    id: {},
    baseUrl: {},
    apiUrl: {},
  },
  computed: {},
  ready() {},
  attached() {},
  methods: {
    renderColumn: (value, row) => {
      console.log(row)
      return "<i class='" + row.iso_code + " flag'></i> " + value
    },
    detail: function(id) {
      window.location.href = this.baseUrl + '/' + id
    },
    detailModal: function(id, action) {
        let apiUrl = this.apiUrl + '/' + id
        if (action.urlParams) {
            apiUrl += action.urlParams
        }
      this.$http.get(apiUrl).then(function(response) {
        let data = response.data
        if (!data.id) {
          data['id'] = id
        }

        data['_meta'] = action
        this.$broadcast('modal:show', null, data)
      })
    },
    delete: function(id, action) {
      this.deleteId = id
      this.$broadcast('modal:show', 'contained:')
    },
    deleteConfirmed: function(id) {
      const self = this
      console.log(id)
      this.$http.delete(this.apiUrl + '/' + id).then(function(response) {
        self.$broadcast('vuetable:refresh')
        console.log(response)
        self.$dispatch(
          'pop-message',
          'success',
          'Delete data berhasil!',
          response.data.msg
        )
      }, function(response) {
        self.$dispatch(
          'pop-message',
          'error',
          'Data tidak dapat di delete (Data sedang digunakan)!',
          response.data.msg
        )
      })
    },
    customRedirect: function(data, action){
        let url = action.urlRedirect;


        url = _.replace(url, /#(\w+(?:\.\w+)*)/g, function (match) {
          return _.get(data, match.substr(1))
        })

        window.location=url;
    }
  },
  events: {
    'filterbox:search-evoked': function(query) {
      this.$broadcast('vuetable:search', query)
    },
    'filterbox:filter-evoked': function(data) {
      this.$broadcast('vuetable:filter', data)
    },
    'vuetable:action': function(name, data, action) {

      name == 'detail' ? this.detail(data[this.lookupField]) : void(0)
      name == 'detail-modal' ? this.detailModal(data[this.lookupField], action) : void(0)
      name == 'delete' ? this.delete(data[this.lookupField], action) : void(0)
      name == 'delete-confirmed' ? this.deleteConfirmed(data.id) : void(0)
      name == 'redirect' ? this.customRedirect(data, action) : void(0)

    },
    'modal:submitted': function() {
      this.$broadcast('vuetable:refresh')
    }
  },
  components: {}
}
</script>

<style lang="css">
</style>
