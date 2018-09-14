<template>
    <div class="py-3 tags-index-field">
        <span v-for="tag in field.value" :key="tag.id" class="tags-input-tag">
            {{ tag.name }}
        </span>
    </div>
</template>

<script>
export default {
    props: ['resourceName', 'field'],
};
</script>
