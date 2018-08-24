<script>
export default {
    model: {
        prop: 'tags',
        event: 'update',
    },

    props: {
        tags: { required: true },
        removeOnBackspace: { default: true },
    },

    data() {
        return {
            input: '',
        };
    },

    computed: {
        newTag() {
            return this.input.trim();
        },
    },

    methods: {
        removeTag(tag) {
            this.$emit('update', this.tags.filter(t => t !== tag));
        },
        addTag() {
            if (this.newTag.length === 0 || this.tags.includes(this.newTag)) {
                return;
            }

            this.$emit('update', [...this.tags, this.newTag]);

            this.clearInput();
        },

        clearInput() {
            this.input = '';
        },

        handleBackspace(e) {
            if (this.newTag.length === 0) {
                this.$emit('update', this.tags.slice(0, -1));
            }
        },
    },

    render() {
        return this.$scopedSlots.default({
            tags: this.tags,
            removeTag: this.removeTag,
            addTag: this.addTag,
            removeButtonEvents: tag => ({
                click: () => {
                    this.removeTag(tag);
                },
            }),
            inputProps: {
                value: this.input,
            },
            inputEvents: {
                input: e => (this.input = e.target.value),
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
