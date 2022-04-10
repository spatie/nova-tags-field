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
                class="tags-input w-full form-control form-input form-input-bordered h-auto p-2 flex flex-wrap items-center"
                :class="{ 'border-danger': errors.has(name) }"
                @click="focusInput"
            >

                <span v-for="tag in tags" :key="tag" class="flex items-center space-x-2 px-2 py-1 bg-primary-500 mr-1 mb-1 rounded text-white">
                    <span>{{ tag }}</span>
                    <button
                        type="button"
                        @click.prevent.stop="removeTag(tag)"
                    >
                        &times;
                    </button>
                </span>
                <input
                    v-if="canAddTag"
                    ref="input"
                    class="dark:bg-gray-900 outline-none p-1 w-32"
                    :placeholder="placeholder ? placeholder : __('Add tag...')"
                    v-bind="inputProps"
                    v-on="inputEvents"
                />

            </div>
            <ul v-if="suggestions.length" class="flex mt-2 p-0">
                <li v-for="suggestion in suggestions" :key="suggestion" class="mr-2">
                    <button
                        class="px-2 py-1 bg-primary-100 rounded text-primary-500"
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
