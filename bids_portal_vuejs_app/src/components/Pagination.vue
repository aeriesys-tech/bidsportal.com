<template>
    <nav class="d-flex justify-content-center" aria-label="navigation">
        <ul class="pagination pagination-primary-soft d-inline-block d-md-flex rounded mb-0">
            <li class="page-item mb-0">
                <button class="page-link btnshadow" type="button" @click="onClickFirstPage" :disabled="isInFirstPage">
                    First
                </button>
            </li>

            <li class="page-item mb-0 ">
                <button class="page-link btnshadow " type="button" @click="onClickPreviousPage" :disabled="isInFirstPage">
                    Previous
                </button>
            </li>

            <li v-for="(page,key) in pages" class="page-item mb-0" :key="key">
                <button class="page-link btnshadow " type="button" @click="onClickPage(page.name)" :disabled="page.isDisabled" :class="{active: isPageActive(page.name) }">
                    {{ page.name }}
                </button>
            </li>

            <li class="page-item mb-0">
                <button class="page-link btnshadow" type="button" @click="onClickNextPage" :disabled="isInLastPage">
                    Next
                </button>
            </li>

            <li class="page-item mb-0">
                <button class="page-link btnshadow" type="button" @click="onClickLastPage" :disabled="isInLastPage">
                    Last
                </button>
            </li>
        </ul>
    </nav>
</template>

<script>
    export default {
        name: "Pagination",
        props: {
            maxPage: {
                type: Number,
                required: true,
            },
            totalPages: {
                type: Number,
                required: true,
            },
            currentPage: {
                type: Number,
                required: true,
            },
        },

        computed: {
            startPage() {
                if (this.currentPage === 1) {
                    return 1;
                }
                if (this.currentPage === this.totalPages) {
                    return this.totalPages - this.maxPage + 1;
                }
                return this.currentPage - 1;
            },
            endPage() {
                return Math.min(this.startPage + this.maxPage - 1, this.totalPages);
            },
            pages() {
                const range = [];
                for (let i = this.startPage; i <= this.endPage; i += 1) {
                    range.push({
                        name: i,
                        isDisabled: i === this.currentPage,
                    });
                }
                return range;
            },
            isInFirstPage() {
                return this.currentPage === 1;
            },
            isInLastPage() {
                return this.currentPage === this.totalPages;
            },
        },
        methods: {
            onClickFirstPage() {
                this.$emit("pagechanged", 1);
                window.scrollTo({ top: 0, left: 0, behavior: 'smooth' });
            },
            onClickPreviousPage() {
                this.$emit("pagechanged", this.currentPage - 1);
                window.scrollTo({ top: 0, left: 0, behavior: 'smooth' });
            },
            onClickPage(page) {
                this.$emit("pagechanged", page);
                window.scrollTo({ top: 0, left: 0, behavior: 'smooth' });
            },
            onClickNextPage() {
                this.$emit("pagechanged", this.currentPage + 1);
                window.scrollTo({ top: 0, left: 0, behavior: 'smooth' });
            },
            onClickLastPage() {
                this.$emit("pagechanged", this.totalPages);
                window.scrollTo({ top: 0, left: 0, behavior: 'smooth' });
            },
            isPageActive(page) {
                return this.currentPage === page;
            },
        },
    };
</script>

<style>
/* .btnshadow{background-color:white !important;color:black} */
.btnshadow{box-shadow: rgba(0, 0, 0, 0.12) 0px 1px 3px, rgba(0, 0, 0, 0.24) 0px 1px 2px;}
    .pagination {
        display: flex !important;
        padding-left: 0 !important;
        list-style: none !important;
    }

    .pagination .pagination-item {
        margin-right: 1px !important;
    }

    .pagination .pagination-item button {
        border: 1px solid #4594e2 !important;
        background-color: #fff !important;
        color:black;
    }

    .pagination .pagination-item .active {
        background-color: #1833ccf3 !important;
        color: #fff!important;
    }
     .pagination .pagination-item .active {
        background-color: #24317cf3 !important;
        color: #fff!important;
    }
    .btn {
        font-size: 16px !important;
    }
    /* .btn:hover {
        color:var(--bs-gray-700) !important;
     
    } */
    .page-item .pagination-item button {
        border: 1px solid #4594e2 !important;
        background-color: #fff !important;
    }
    .page-item .active {
        background-color: #5143d9 !important;
        color: #fff !important;
    }
    .page-link {
        font-size: 14px !important;
    }

    /* css */

   
    .pagination-primary-soft .page-link {
        border: transparent;
        border-radius: 0.5rem !important;
        /* color: var(--bs-gray-700); */
        background-color: white;
    }
  /* .page-link {
        font-size: 14px !important;
    }
    .pagination-primary-soft .page-link {
    border: transparent;
    border-radius: 0.5rem !important;
    color: var(--bs-gray-700);
    background-color: var(--bs-light);
} */

.page-link {
    position: relative;
    display: block;
    padding: var(--bs-pagination-padding-y) var(--bs-pagination-padding-x);
    font-size: var(--bs-pagination-font-size);
    color: var(--bs-pagination-color);
    background-color: var(--bs-pagination-bg);
    border: var(--bs-pagination-border-width) solid var(--bs-pagination-border-color);
    -webkit-transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, -webkit-box-shadow 0.15s ease-in-out;
    transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, -webkit-box-shadow 0.15s ease-in-out;
    transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out, -webkit-box-shadow 0.15s ease-in-out;
}
.pagination {
    --bs-pagination-padding-x: 1rem;
    --bs-pagination-padding-y: 0.7rem;
    --bs-pagination-font-size: 1rem;
    --bs-pagination-color: var(--bs-gray-600);
    --bs-pagination-bg: #fff;
    --bs-pagination-border-width: 1px;
    --bs-pagination-border-color: var(--bs-gray-300);
    --bs-pagination-border-radius: 0.5rem;
    --bs-pagination-hover-color: var(--bs-white);
    --bs-pagination-hover-bg: var(--bs-primary);
    --bs-pagination-hover-border-color: var(--bs-primary);
    --bs-pagination-focus-color: var(--bs-link-hover-color);
    --bs-pagination-focus-bg: var(--bs-gray-200);
    --bs-pagination-focus-box-shadow: 0 0 0 0 rgba(var(--bs-primary), 0.25);
    --bs-pagination-active-color: #fff;
    --bs-pagination-active-bg: var(--bs-primary);
    --bs-pagination-active-border-color: var(--bs-primary);
    --bs-pagination-disabled-color: var(--bs-gray-400);
    --bs-pagination-disabled-bg: #fff;
    --bs-pagination-disabled-border-color: var(--bs-gray-300);
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    padding-left: 0;
    list-style: none;
}
button:disabled {
    background-color: -internal-light-dark(rgba(239, 239, 239, 0.3), rgba(19, 1, 1, 0.3));
    color: -internal-light-dark(rgba(16, 16, 16, 0.3), rgba(255, 255, 255, 0.3));
    border-color: -internal-light-dark(rgba(118, 118, 118, 0.3), rgba(195, 195, 195, 0.3));
}

</style>
