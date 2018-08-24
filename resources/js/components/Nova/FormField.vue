<template>
    <default-field :field="field">
        <template slot="field">
            <inline-tag-input
              v-model="tags"
              class="w-full form-control form-input form-input-bordered">
            </inline-tag-input>
        </template>
    </default-field>
</template>

<script>
import { FormField, HandlesValidationErrors } from 'laravel-nova';
import InlineTagInput from '../Tags/InlineTagInput';

export default {
    mixins: [FormField, HandlesValidationErrors],

    components: { InlineTagInput },

    props: ['resourceName', 'resourceId', 'field'],

    data() {
        return {
            tags: [],
        };
    },

    methods: {
        /*
         * Set the initial, internal value for the field.
         */
        setInitialValue() {
            const tagNames = this.field.value.map(tag => tag.name);

            this.value = tagNames;

            this.tags = tagNames;
        },

        /**
         * Fill the given FormData object with the field's internal value.
         */
        fill(formData) {
            console.log('fill', this.tags);
            formData.append(this.field.attribute, this.tags);
        },

        /**
         * Update the field's internal value.
         */
        handleChange(value) {
            console.log('handleChange', value);
            this.value = value;
        },
    },
};
</script>
