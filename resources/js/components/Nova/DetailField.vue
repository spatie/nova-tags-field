<template>
    <PanelItem :index="index" :field="field">
        <template #value>
            <p v-html="typeof field.value === 'object' ? field.value.join(', ') : field.value"></p>
        </template>
    </PanelItem>
</template>

<script>
export default {
    props: ['index', 'resource', 'resourceName', 'resourceId', 'field'],
};
</script>
