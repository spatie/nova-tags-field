<script>
export default {
    props: {
        tags: { required: true },
        type: { default: null },
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

        getSuggestions() {
            if (!this.input) {
                this.suggestions = [];

                return;
            }

            const queryString = this.type
                ? `filter[type]=${this.type}&filter[containing]=${this.input}`
                : `filter[containing]=${this.input}`;

            axios.get(`/nova-vendor/spatie/nova-tags-field?${queryString}`).then(response => {
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

                    this.getSuggestions();
                },
                keydown: e => {
                    if (e.key === 'Backspace' && this.removeOnBackspace) {
                        this.handleBackspace();
                    }
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        this.addTag();
                    }
                },
            },
        });
    },
};
</script>
