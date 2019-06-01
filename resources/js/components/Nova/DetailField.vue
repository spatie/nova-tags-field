<template>
    <panel-item :field="field">
        <p slot="value" v-html="typeof field.value === 'object' ? field.value.join(', ') : field.value"></p>
    </panel-item>
</template>

<script>
export default {
    inheritAttrs: false,

    props: ['field'],
};
</script>
