<template>
    <div class="pagination-buttons">
        <span>
            <a @click="onPageClick(pages[0])">First</a>
            <a @click="onPreviousPageClick" :class="{ disabled: disablePreviousButton }">Previous</a>

            <a
                v-for="page in pages"
                @click="onPageClick(page)"
                :class="{ selected: current === page }"
            >
                {{ page }}
            </a>

            <a @click="onNextPageClick" :class="{ disabled: disableNextButton }">Next</a>
            <a @click="onPageClick(pages[pages.length - 1])">Last</a>
        </span>
    </div>
</template>

<script>
export default {
    name: "PaginationButtons",
    props: ['current', 'pageCount'],
    computed: {
        pages() {
            let pagesArr = []
            for (let i = 0; i < this.pageCount; i++) {
                pagesArr.push(i + 1)
            }
            return pagesArr
        },
        disablePreviousButton() {
            // Disable previous button when the current page is the first page
            return this.current === this.pages[0]
        },
        disableNextButton() {
            // Disable the next button when the current page is the last page
            return this.current === this.pages[this.pages.length - 1]
        },
    },
    methods: {
        onPageClick(page) {
            this.$emit('pagination-buttons:page-click', page)
        },
        onPreviousPageClick() {
            // Do not do anything if the button is disabled
            if (this.disablePreviousButton) {
                return
            }

            this.onPageClick(this.current - 1)
        },
        onNextPageClick() {
            // Do not do anything if the button is disabled
            if (this.disableNextButton) {
                return
            }

            this.onPageClick(this.current + 1)
        },
    },
}
</script>

<style scoped>
.pagination-buttons {
    text-align: center;
    margin: 0 auto;
    width: 25%;
}

.pagination-buttons span {
    display: flex;
    justify-content: space-between;
}

a {
    cursor: pointer;
    color: #696868;
}

.selected {
    font-weight: bold;
    color: black;
}

.disabled {
    cursor: not-allowed;
    color: lightgrey;
}
</style>
