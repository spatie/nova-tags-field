<script>
import { h } from 'vue';
import throttle from 'lodash/throttle';

export default {
    props: {
        tags: { required: true, default: () => [] },
        type: { default: null },
        suggestionLimit: { required: true },
        limit: { default: null },
        removeOnBackspace: { default: true },
        modelValue: { default: null },
    },

    emits: ['updateTags'],

    model: {
        prop: 'tags',
    },

    data() {
        return {
            input: '',
            suggestions: [],
            tagsInput: this.tags,
        };
    },

    created() {
        this.throttledGetSuggested = throttle(this.getSuggested, 400);
    },

    computed: {
        newTag() {
            return this.input.trim();
        },
        canAddTag() {
            if (typeof this.limit === 'undefined') {
                return true;
            }

            if (this.limit === null) {
                return true;
            }

            if (!Number.isInteger(this.limit)) {
                return true;
            }

            if (this.limit < 1) {
                return true;
            }

            return this.tagsInput.length < this.limit;
        },
    },

    methods: {
        addTag() {
            if (this.newTag.length === 0 || this.tagsInput.includes(this.newTag)) {
                return;
            }

            this.$emit('updateTags', [...this.tagsInput, this.newTag]);

            this.clearInput();
        },

        removeTag(tag) {
            this.$emit(
                'updateTags',
                this.tagsInput.filter(t => t !== tag)
            );
        },

        selectTag(tag) {
            this.$emit('updateTags', tag);
        },

        clearInput() {
            this.input = '';

            this.suggestions = [];
        },

        handleBackspace() {
            if (this.newTag.length === 0) {
                this.$emit('updateTags', this.tagsInput.slice(0, -1));
            }
        },

        getSuggested() {
            if (!this.input) {
                this.suggestions = [];

                return;
            }

            if (this.suggestionLimit === 0) {
                this.suggestions = [];

                return;
            }

            let queryString = `?filter[containing]=${encodeURIComponent(this.input)}&limit=${
                this.suggestionLimit
            }`;

            if (this.type) {
                queryString += `&filter[type]=${this.type}`;
            }

            Nova.request()
                .get(`/nova-vendor/spatie/nova-tags-field${queryString}`)
                .then(response => {
                    // If the input was cleared by the time the request finished,
                    // clear the suggestions too.
                    if (!this.input) {
                        this.suggestions = [];

                        return;
                    }

                    this.suggestions = response.data.filter(suggestion => {
                        return !this.tagsInput.find(tag => tag === suggestion);
                    });
                });
        },

        insertSuggestion(suggestion) {
            this.$emit('updateTags', [...this.tagsInput, suggestion]);

            this.clearInput();
        },
    },

    watch: {
        tags(newTags) {
            this.tagsInput = newTags;
        },
    },

    render() {
        return h(
            'div',
            this.$slots.default({
                tags: this.tagsInput,
                addTag: this.addTag,
                removeTag: this.removeTag,
                canAddTag: this.canAddTag,
                selectTag: this.selectTag,
                suggestions: this.suggestions,
                insertSuggestion: this.insertSuggestion,
                inputProps: {
                    value: this.input,
                },
                inputEvents: {
                    input: e => {
                        this.input = e.target.value;

                        this.throttledGetSuggested();
                    },
                    keydown: e => {
                        if (e.key === 'Backspace' && this.removeOnBackspace) {
                            this.handleBackspace();
                        }
                        if (e.key === 'Enter') {
                            e.preventDefault();
                            this.addTag();
                        }
                        if (e.key === 'ArrowDown' && this.suggestions.length === 1) {
                            this.input = this.suggestions[0];
                            this.addTag();
                        }
                    },
                },
            })
        );
    },
};
</script>
