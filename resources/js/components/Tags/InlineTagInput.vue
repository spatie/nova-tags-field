<template>
    <renderless-tag-input :tags="tags" @update="(newTags) => $emit('update', newTags)">
        <div class="tag-input" slot-scope="{ tags, removeTag, removeButtonEvents, inputProps, inputEvents }">
      <span v-for="tag in tags" :key="tag" class="tag-input-tag">
        <span>{{ tag }}</span>
        <button type="button" class="tag-input-remove"
                v-on="removeButtonEvents(tag)"
        >&times;</button>
      </span>
            <input class="tag-input-text" placeholder="Add tag..."
                   v-bind="inputProps"
                   v-on="inputEvents"
            >
        </div>
    </renderless-tag-input>
</template>

<script>
    import RenderlessTagInput from "./RenderlessTagInput.vue"

    export default {
        components: {
            RenderlessTagInput
        },
        model: {
            prop: "tags",
            event: "update"
        },
        props: {
            tags: { required: true }
        },
        data() {
            return {}
        },
        methods: {}
    }
</script>
