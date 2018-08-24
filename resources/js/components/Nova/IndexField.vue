<template>
    <div>
        <span v-for="tag in field.value" class="tag-input-tag">
            {{ tag.name }}
        </span>
    </div>
</template>

<script>
export default {
    props: ['resourceName', 'field'],
};
</script>
