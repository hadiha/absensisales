export default {
  methods: {
    fillElements(els, data) {
      const self = this
      _.each(els, function (el) {
        let elementName = el.name

        if ($(el).data('lookup-field')) {
          elementName = $(el).data('lookup-field')
        }

        if (_.has(data, elementName) && !($(el).hasClass('ignored'))) {
          $(el).val(_.get(data, elementName))
          self.$broadcast('vue-component:change', elementName, _.get(data, elementName))
        }
      })
    },
  }
}
