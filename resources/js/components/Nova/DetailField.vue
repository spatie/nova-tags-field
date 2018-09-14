<template>
    <panel-item :field="field">
        <tag-names slot="value" :tags="field.value"></tag-names>
    </panel-item>
</template>

<script>
import TagNames from '../Tags/TagNames';

export default {
    props: ['field'],

    components: {
        TagNames,
    },
};
</script>
