<template>
    <div class="py-3 tags-index-field">
        <span v-if="field.usesCustomizedDisplay" v-html="tagFieldValue"></span>
        <span v-else>{{ tagFieldValue }}</span>
    </div>
</template>

<script>
export default {
    props: ['resourceName', 'field'],

    computed: {
        tagFieldValue() {
            const fieldValue = this.field.displayedAs ?? this.field.value;

            return Array.isArray(fieldValue) ? fieldValue.join(', ') : fieldValue;
        },
    },
};
</script>
