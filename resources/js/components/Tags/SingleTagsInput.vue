<template>
    <select
        v-if="loaded"
        class="w-full block form-control form-select form-select-bordered"
        :class="{ 'border-danger': errors.has(name) }"
        :id="name"
        :value="tags[0]"
        @input="$emit('update:modelValue', [$event.target.value])"
    >
        <option value="" selected :disabled="!canBeDeselected">
            {{ placeholder ? placeholder : __('Choose an option') }}
        </option>
        <option v-for="tag in availableTags" :key="tag" :value="tag">
            {{ tag }}
        </option>
    </select>
</template>

<script>
export default {
    props: ['tags', 'type', 'name', 'suggestionLimit', 'errors', 'placeholder', 'canBeDeselected'],

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
            const queryString = this.type ? `filter[type]=${this.type}` : '';

            Nova.request()
                .get(`/nova-vendor/spatie/nova-tags-field?${queryString}`)
                .then(response => {
                    this.availableTags = response.data;

                    this.loaded = true;
                });
        },
    },
};
</script>
