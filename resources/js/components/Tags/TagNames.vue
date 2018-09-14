<template>
    <div v-text="names.join(', ')"></div>
</template>

<script>
export default {
    props: ['tags'],

    computed: {
        names() {
            return this.tags.map(tag => tag.name);
        },
    },
}
</script>
