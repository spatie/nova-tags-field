<template>
    <PanelItem :index="index" :field="field">
        <template #value>
            <p v-if="field.usesCustomizedDisplay" v-html="tagFieldValue"></p>
            <p v-else>{{ tagFieldValue }}</p>
        </template>
    </PanelItem>
</template>

<script>
export default {
    props: ['index', 'resource', 'resourceName', 'resourceId', 'field'],

    computed: {
        tagFieldValue() {
            const fieldValue = this.field.displayedAs ?? this.field.value;

            return Array.isArray(fieldValue) ? fieldValue.join(', ') : fieldValue;
        },
    },
};
</script>
