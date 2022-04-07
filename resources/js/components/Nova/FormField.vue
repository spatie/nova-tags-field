<template>
    <DefaultField :field="field" :errors="errors" :show-help-text="showHelpText">
        <template #field>
            <component
                :is="component"
                :name="field.attribute"
                :type="field.type"
                :suggestion-limit="field.suggestionLimit"
                :limit="field.limit"
                :errors="errors"
                :tags="tags"
                :placeholder="field.placeholder"
                :can-be-deselected="field.canBeDeselected"
                v-model="tags"
            ></component>
        </template>
    </DefaultField>
</template>

<script>
import MultiTagsInput from '../Tags/MultiTagsInput';
import SingleTagsInput from '../Tags/SingleTagsInput';
import { FormField, HandlesValidationErrors } from 'laravel-nova';

export default {
    inheritAttrs: false,

    mixins: [FormField, HandlesValidationErrors],

    props: ['resourceName', 'resourceId', 'field'],

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
            return this.field.multiple ? 'MultiTagsInput' : 'SingleTagsInput';
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
