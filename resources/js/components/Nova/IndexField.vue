<template>
    <tag-names :tags="field.value" class="py-3 tags-index-field"></tag-names>
</template>

<script>
import TagNames from '../Tags/TagNames';

export default {
    inheritAttrs: false,

    props: ['field'],

    components: {
        TagNames,
    },
};
</script>
