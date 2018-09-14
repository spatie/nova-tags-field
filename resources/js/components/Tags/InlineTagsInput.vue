<template>
    <tags-input :tags="tags" @input="$emit('input', $event)">
        <div
            class="tags-input w-full form-control form-input form-input-bordered flex items-center"
            slot-scope="{ tags, removeTag, removeButtonEvents, inputProps, inputEvents }"
        >
            <span v-for="tag in tags" :key="tag" class="tags-input-tag">
                <span>{{ tag }}</span>
                <button
                    type="button"
                    class="tags-input-remove"
                    v-on="removeButtonEvents(tag)"
                >
                    &times;
                </button>
            </span>
            <input
                class="tags-input-text"
                placeholder="Add tag..."
                v-bind="inputProps"
                v-on="inputEvents"
            >
        </div>
    </tags-input>
</template>

<script>
import TagsInput from './TagsInput.vue';

export default {
    components: {
        TagsInput,
    },

    model: {
        prop: 'tags',
    },

    props: {
        tags: { required: true },
    },

    data() {
        return {};
    },

    methods: {},
};
</script>
