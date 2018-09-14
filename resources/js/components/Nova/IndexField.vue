<template>
    <p class="py-3 tags-index-field" v-text="field.value.join(', ')"></p>
</template>

<script>
export default {
    inheritAttrs: false,

    props: ['field'],
};
</script>
