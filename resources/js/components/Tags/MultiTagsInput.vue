<template>
    <tags-input
        :tags="tagsInput"
        :type="type"
        :suggestion-limit="suggestionLimit"
        :limit="limit"
        :value="modelValue"
        @updateTags="handleInput"
    >
        <template
            v-slot="{
                tags,
                removeTag,
                canAddTag,
                inputProps,
                inputEvents,
                suggestions,
                insertSuggestion,
            }"
        >
            <div
                class="tags-input w-full form-control form-input form-input-bordered flex items-center"
                :class="{ 'border-danger': errors.has(name) }"
                @click="focusInput"
            >
                <span v-for="tag in tags" :key="tag" class="tags-input-tag mr-1">
                    <span>{{ tag }}</span>
                    <button
                        type="button"
                        class="tags-input-remove"
                        @click.prevent.stop="removeTag(tag)"
                    >
                        &times;
                    </button>
                </span>
                <input
                    v-if="canAddTag"
                    ref="input"
                    class="tags-input-text"
                    :placeholder="placeholder ? placeholder : __('Add tag...')"
                    v-bind="inputProps"
                    v-on="inputEvents"
                />
            </div>
            <ul v-if="suggestions.length" class="tags-input-suggestions">
                <li v-for="suggestion in suggestions" :key="suggestion" class="mr-1">
                    <button
                        class="tags-input-tag"
                        @mousedown.prevent
                        @click.prevent="insertSuggestion(suggestion)"
                    >
                        {{ suggestion }}
                    </button>
                </li>
            </ul>
        </template>
    </tags-input>
</template>

<script>
import TagsInput from './TagsInput.vue';

export default {
    props: [
        'name',
        'tags',
        'type',
        'suggestionLimit',
        'errors',
        'placeholder',
        'limit',
        'modelValue',
    ],

    emits: ['update:modelValue'],

    components: {
        TagsInput,
    },

    data() {
        return {
            tagsInput: this.tags,
        };
    },

    mounted() {},

    methods: {
        focusInput() {
            if (this.$refs.input) {
                this.$refs.input.focus();
            }
        },

        handleInput(tags) {
            this.$emit('update:modelValue', tags);

            this.focusInput();
        },
    },

    watch: {
        tags(updatedTags) {
            this.tagsInput = updatedTags;
        },
    },
};
</script>
