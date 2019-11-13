<template>
    <div class="py-3 tags-index-field" v-html="typeof field.value === 'object' ? field.value.join(', ') : field.value"></div>
</template>

<script>
export default {
    inheritAttrs: false,

    props: ['field'],
};
</script>
