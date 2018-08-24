<template>
    <panel-item :field="field">
        <p slot="value" class="text-90">
            <span v-for="tag in field.value" class="tag-input-tag">
                {{ tag.name }}
            </span>
        </p>
    </panel-item>
</template>

<script>
export default {
    props: ['resource', 'resourceName', 'resourceId', 'field'],
}
</script>
