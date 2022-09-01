<template>
    <div
        class="py-3 tags-index-field"
        v-html="tagFieldValue"
    ></div>
</template>

<script>
import { FieldValue } from 'laravel-nova';

export default {
    mixins: [FieldValue],

    props: ['resourceName', 'field'],

    computed: {
        tagFieldValue() {
            let fieldValue = this.fieldValue

            return typeof fieldValue === 'object' ? fieldValue.join(', ') : fieldValue
        },
    },
};
</script>
