<template>
    <tag-names :tags="field.value" class="py-3 tags-index-field"></tag-names>
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
