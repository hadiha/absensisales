//passport
Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue')
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue')
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue')
);

// Avatar
Vue.component('avatar', require('./components/Avatar.vue'))

// SyncedSelect
Vue.component('synced-select', require('./components/SyncedSelect.vue'))

// Progress Bar
Vue.component('progress-bar', require('./components/ProgressBar.vue'))

// Menu Item
Vue.component('menu-item', require('./components/MenuItem.vue'))

// Tab
Vue.component('tab', require('./components/TabItem.vue'))

Vue.component('tabs', require('./components/Tabs.vue'))

// Panel
Vue.component('panel', require('./components/Panel.vue'))

// Modal
Vue.component('modal', require('./components/Modal.vue'))

// Dummy
Vue.component('table-container', require('./components/TableContainer.vue'))

// FilterBox
Vue.component('filter-box', require('./components/FilterBox.vue'))

// Table
Vue.component('vuetable-pagination', require('./components/vue-table/VuetablePagination.vue'))
Vue.component('vuetable-pagination-dropdown', require('./components/vue-table/VuetablePaginationDropdown.vue'))
Vue.component('vuetable', require('./components/vue-table/Vuetable.vue'))

// Table - PickBtn
Vue.component('pick-btn', require('./components/PickBtn.vue'))

// Message
Vue.component('message', require('./components/Message.vue'))

// Browse File
Vue.component('browse-file', require('./components/BrowseFile.vue'))

// Ajax Form
Vue.component('ajax-form', require('./components/AjaxForm.vue'))

// Switch and Receptor
Vue.component('switch', require('./components/Switch.vue'))
Vue.component('receptor', require('./components/Receptor.vue'))

// CheckList
Vue.component('check-list', require('./components/CheckList.vue'))

// Image Upload
Vue.component('image-upload', require('./components/ImageUpload.vue'))

// Card List
Vue.component('card-list', require('./components/CardList.vue'))

// datepicker
Vue.component('datepicker', require('./components/datepicker/Datepicker.vue'))

// Fancy Select
Vue.component('fancy-select', require('./components/FancySelect.vue'))
