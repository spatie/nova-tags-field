<template>
    <tags-input :tags="tags" @input="handleInput">
        <div slot-scope="{ tags, removeTag, inputProps, inputEvents, suggestions, insertSuggestion }">
            <div class="tags-input w-full form-control form-input form-input-bordered flex items-center" @click="focusInput">
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
                    ref="input"
                    class="tags-input-text"
                    placeholder="Add tag..."
                    v-bind="inputProps"
                    v-on="inputEvents"
                >
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
        </div>
    </tags-input>
</template>

<script>
import TagsInput from './TagsInput.vue';

export default {
    props: ['field', 'tags'],

    model: {
        prop: 'tags',
    },

    components: {
        TagsInput,
    },

    methods: {
        focusInput() {
            this.$refs.input.focus();
        },

        handleInput(tags) {
            this.$emit('input', tags);

            // Re-focus the input when a suggestion was inserted
            this.focusInput();
        },
    },
};
</script>
