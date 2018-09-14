<template>
    <panel-item :field="field">
        <p slot="value" v-text="field.value.join(', ')"></p>
    </panel-item>
</template>

<script>
export default {
    inheritAttrs: false,

    props: ['field'],
};
</script>
