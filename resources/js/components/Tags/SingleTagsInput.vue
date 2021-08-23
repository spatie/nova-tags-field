<template>
    <select
        v-if="loaded"
        class="w-full form-control form-select"
        :class="{ 'border-danger': errors.has(name) }"
        :id="name"
        :value="tags[0]"
        @input="$emit('input', [$event.target.value])"
    >
        <option value="" selected :disabled="!canBeDeselected">
            {{ placeholder ? placeholder : __('Choose an option') }}
        </option>
        <option
            v-for="tag in availableTags"
            :key="tag"
            :value="tag"
        >
            {{ tag }}
        </option>
    </select>
</template>

<script>
export default {
    props: ['tags', 'type', 'name', 'suggestionLimit', 'errors', 'placeholder', 'canBeDeselected', 'resourceName'],

    model: {
        prop: 'tags',
    },

    data: () => ({
        loaded: false,
        availableTags: [],
    }),

    mounted() {
        this.getAvailableTags();
    },

    methods: {
        getAvailableTags() {
            let params = {}

            if (this.type) {
                params['filter[type]'] = this.type;
            }

            if (this.resourceName) {
                params.resourceName = this.resourceName;
            }

            window.axios
                .get('/nova-vendor/spatie/nova-tags-field', {
                    params,
                })
                .then(response => {
                    this.availableTags = response.data;

                    this.loaded = true;
                });
        },
    },
};
</script>
