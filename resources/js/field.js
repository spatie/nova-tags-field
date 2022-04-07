import IndexField from './components/Nova/IndexField';
import DetailField from './components/Nova/DetailField';
import FormField from './components/Nova/FormField';

Nova.booting(app => {
    app.component('index-nova-tags-field', IndexField);
    app.component('detail-nova-tags-field', DetailField);
    app.component('form-nova-tags-field', FormField);
});
