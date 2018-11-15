<template>
    <nav style="margin-top: 50px">
        <ul class="pagination" v-if="shouldPaginate">
            <li class="page-item" v-show="prevPageUrl">
                <a class="page-link" href="#" aria-label="Previous" rel="prev" @click.prevent="prevPage">
                    <span aria-hidden="true">&laquo;</span>
                    <span class="sr-only">Previous</span>
                </a>
            </li>
            <li class="page-item" :class="{ 'active': page == currentPage }" v-for="(page, index) in pageRange" :key="index">
                <a class="page-link" @click.prevent="selectPage(page)" :href="specificLink(page)" v-text="page"></a>
            </li>
            <li class="page-item" v-show="nextPageUrl">
                <a class="page-link" href="#" aria-label="Next" rel="next" @click.prevent="nextPage">
                    <span aria-hidden="true">&raquo;</span>
                    <span class="sr-only">Next</span>
                </a>
            </li>
        </ul>
    </nav>
</template>

<script>
    export default {
        props: ['dataSet', 'limit'],
        data(){
            return {

            }
        },

        watch: {
            dataSet(){
                
            },
        },

        created() {
            window.onpopstate = (event) => {
                //console.log("location: " + document.location + ", state: " + JSON.stringify(event.state));
                if(event.state === null){
                    this.$emit('changed', 1);
                    return;
                }
                if(event.state.page != this.currentPage){
                    this.$emit('changed', event.state.page);     
                }
            };
        },

        computed: {
            shouldPaginate(){
                //return !! this.prevUrl || !! this.nextUrl;
                return this.total > this.perPage;
            },
            endpoint(){
                return this.dataSet.endpoint;
            },
            currentPage () {
                return this.dataSet.current_page;
            },
            firstPageUrl () {
                return null;
            },
            from () {
                return this.dataSet.from;
            },
            lastPage () {
                return this.dataSet.last_page;
            },
            lastPageUrl () {
                return null;
            },
            nextPageUrl () {
                return true;
                //return this.dataSet.next_page_url;
            },
            perPage () {
                return this.dataSet.per_page;
            },
            prevPageUrl () {
                return true;
                //return this.dataSet.prev_page_url;
            },
            to () {
                return this.dataSet.to;
            },
            total () {
                return this.dataSet.total;
            },
            pageRange () {
                if (this.limit === -1) {
                    return 0;
                }

                if (this.limit === 0) {
                    return this.lastPage;
                }

                var current = this.currentPage;
                var last = this.lastPage;
                var delta = this.limit;
                var left = current - delta;
                var right = current + delta + 1;
                var range = [];
                var pages = [];
                var l;

                for (var i = 1; i <= last; i++) {
                    if (i === 1 || i === last || (i >= left && i < right)) {
                        range.push(i);
                    }
                }

                range.forEach(function (i) {
                    if (l) {
                        if (i - l === 2) {
                            pages.push(l + 1);
                        } else if (i - l !== 1) {
                            pages.push('...');
                        }
                    }
                    pages.push(i);
                    l = i;
                });

                return pages;
            }
        },

        methods: {
            specificLink(page){
                let url = this.endpoint.replace('/replies', '') + '?page=' + page;
                let params = window.common.getParameters();
                url = window.common.addParams(params, url);

                return url;
            },
            prevPage () {
                this.selectPage((this.currentPage - 1));
            },
            nextPage () {
                this.selectPage((this.currentPage + 1));
            },
            selectPage (page) {
                if (page === '...') return;
                if (page > this.lastPage || page < 1) return;

                this.dataSet.current_page = page;
                this.updateUrl();
                this.$emit('changed', page);
            },
            updateUrl(){
                
                let url = '?page=' + this.currentPage;
                let params = window.common.getParameters();

                url = window.common.addParams(params, url);



                var stateObj = { page: this.currentPage };
                history.pushState(stateObj, null, url);
               
            },
        },
    }
</script>