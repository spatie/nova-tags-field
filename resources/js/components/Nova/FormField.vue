<template>
    <default-field :field="field" :errors="errors">
        <template slot="field">
            <component
                :is="component"
                :name="field.attribute"
                :type="field.type"
                :suggestion-limit="field.suggestionLimit"
                :errors="errors"
                v-model="tags"
            ></component>
        </template>
    </default-field>
</template>

<script>
import MultiTagsInput from '../Tags/MultiTagsInput';
import SingleTagsInput from '../Tags/SingleTagsInput';
import { FormField, HandlesValidationErrors } from 'laravel-nova';

export default {
    inheritAttrs: false,

    mixins: [FormField, HandlesValidationErrors],

    props: ['field'],

    data() {
        return {
            tags: this.field.value,
        };
    },

    components: {
        MultiTagsInput,
        SingleTagsInput,
    },

    computed: {
        component() {
            return this.field.multiple ? 'multi-tags-input' : 'single-tags-input';
        },
    },

    methods: {
        fill(formData) {
            formData.append(this.field.attribute, this.tags.join('-----'));
        },

        handleChange(value) {
            this.value = value;
        },
    },
};
</script>
