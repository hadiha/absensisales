Vue.directive('visible', function (value) {
    if (value) {
        $(this.el).show('fast')
    } else {
        $(this.el).hide('fast')
    }
})
