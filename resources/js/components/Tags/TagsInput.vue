<script>
export default {
    props: {
        tags: { required: true },
        type: { default: null },
        suggestionLimit: { required: true },
        removeOnBackspace: { default: true },
    },

    model: {
        prop: 'tags',
    },

    data() {
        return {
            input: '',
            suggestions: [],
        };
    },

    created() {
        this.throttledGetSuggested = window._.throttle(this.getSuggested, 400);
    },

    computed: {
        newTag() {
            return this.input.trim();
        },
    },

    methods: {
        addTag() {
            if (this.newTag.length === 0 || this.tags.includes(this.newTag)) {
                return;
            }

            this.$emit('input', [...this.tags, this.newTag]);

            this.clearInput();
        },

        removeTag(tag) {
            this.$emit('input', this.tags.filter(t => t !== tag));
        },

        selectTag(tag) {
            this.$emit('input', tag);
        },

        clearInput() {
            this.input = '';

            this.suggestions = [];
        },

        handleBackspace() {
            if (this.newTag.length === 0) {
                this.$emit('input', this.tags.slice(0, -1));
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

            let queryString = `?filter[containing]=${encodeURIComponent(this.input)}&limit=${this.suggestionLimit}`;

            if (this.type) {
                queryString += `&filter[type]=${this.type}`;
            }

            window.axios.get(`/nova-vendor/spatie/nova-tags-field${queryString}`).then(response => {
                // If the input was cleared by the time the request finished,
                // clear the suggestions too.
                if (!this.input) {
                    this.suggestions = [];

                    return;
                }

                this.suggestions = response.data.filter(suggestion => {
                    return !this.tags.find(tag => tag === suggestion);
                });
            });
        },

        insertSuggestion(suggestion) {
            this.$emit('input', [...this.tags, suggestion]);

            this.clearInput();
        },
    },

    render() {
        return this.$scopedSlots.default({
            tags: this.tags,
            addTag: this.addTag,
            removeTag: this.removeTag,
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
                    if(e.key === "ArrowDown" && this.suggestions.length === 1) {
                        this.input = this.suggestions[0];
                        this.addTag();
                    }
                },
            },
        });
    },
};
</script>
