<template>
    <div>
        <span v-for="tag in field.value" :key="tag.id" class="tag-input-tag">
            {{ tag.name }}
        </span>
    </div>
</template>

<script>
export default {
    props: ['resourceName', 'field'],
};
</script>
