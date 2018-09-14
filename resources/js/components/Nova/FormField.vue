<template>
    <default-field :field="field">
        <template slot="field">
            <inline-tags-input v-model="tags"></inline-tags-input>
        </template>
    </default-field>
</template>

<script>
import { FormField, HandlesValidationErrors } from 'laravel-nova';
import InlineTagsInput from '../Tags/InlineTagsInput';

export default {
    inheritAttrs: false,

    mixins: [FormField, HandlesValidationErrors],

    props: ['field'],

    data() {
        return {
            tags: [],
        };
    },

    components: {
        InlineTagsInput,
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
            formData.append(this.field.attribute, this.tags.join('-----'));
        },

        /**
         * Update the field's internal value.
         */
        handleChange(value) {
            this.value = value;
        },
    },
};
</script>
