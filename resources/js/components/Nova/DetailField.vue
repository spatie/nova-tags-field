<template>
    <PanelItem :index="index" :field="field">
        <template #value>
            <p v-html="tagFieldValue"></p>
        </template>
    </PanelItem>
</template>

<script>
import { FieldValue } from 'laravel-nova';

export default {
    mixins: [FieldValue],

    props: ['index', 'resource', 'resourceName', 'resourceId', 'field'],

    computed: {
        tagFieldValue() {
            let fieldValue = this.fieldValue

            return typeof fieldValue === 'object' ? fieldValue.join(', ') : fieldValue
        },
    },
};
</script>
