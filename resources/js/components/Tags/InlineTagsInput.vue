<template>
    <renderless-tags-input
        :tags="tags"
        @update="(newTags) => $emit('update', newTags)"
    >
        <div class="tags-input" slot-scope="{ tags, removeTag, removeButtonEvents, inputProps, inputEvents }">
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
            <input class="tags-input-text" placeholder="Add tag..."
                v-bind="inputProps"
                v-on="inputEvents"
            >
        </div>
    </renderless-tags-input>
</template>

<script>
import RenderlessTagsInput from './RenderlessTagsInput.vue';

export default {
    components: {
        RenderlessTagsInput,
    },

    model: {
        prop: 'tags',
        event: 'update',
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
