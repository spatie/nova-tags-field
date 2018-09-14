<template>
    <select
        v-if="availableTags.length"
        class="w-full form-control form-select"
        :id="field.name"
        :value="tags[0]"
        @input="$emit('input', [$event.target.value])"
    >
        <option value="" selected disabled>
            {{ __('Choose an option') }}
        </option>
        <option
            v-for="tag in availableTags"
            :key="tag.name"
            :value="tag.name"
        >
            {{ tag.name }}
        </option>
    </select>
</template>

<script>
export default {
    props: ['field', 'tags'],

    model: {
        prop: 'tags',
    },

    data: () => ({
        availableTags: [],
    }),

    mounted() {
        this.getAvailableTags();
    },

    methods: {
        getAvailableTags() {
            const queryString = this.field.type
                ? `filter[type]=${this.field.type}`
                : '';

            axios.get(`/nova-vendor/spatie/nova-tags-field?${queryString}`).then(response => {
                this.availableTags = response.data;
            });
        },
    },
};
</script>
