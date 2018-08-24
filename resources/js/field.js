Nova.booting((Vue, router) => {
    Vue.component('index-nova-tags-field', require('./components/IndexField'));
    Vue.component('detail-nova-tags-field', require('./components/DetailField'));
    Vue.component('form-nova-tags-field', require('./components/FormField'));
})
