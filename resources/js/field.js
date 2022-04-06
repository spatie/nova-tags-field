import FormField from './components/Nova/FormField.vue';
import DetailField from './components/Nova/DetailField.vue';
import IndexField from './components/Nova/IndexField.vue';

Nova.booting((Vue) => {
    Vue.component('form-visual-editor', FormField);
    Vue.component('detail-visual-editor', DetailField);
    Vue.component('index-visual-editor', IndexField);
});
