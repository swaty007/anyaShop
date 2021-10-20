<script>
    export default {
        name: 'Product discount',
        el: '#product_discount_vue',
        components: {
            // HelloWorld
        },
        data() {
            return {
                busy: false,
                tab: 'discount',
                products: [],
                page: 1,
                total_posts: 0,
                total_pages: 0,
            }
        },
        computed: {
            price: function () {

            },
        },
        watch: {
            tab: function (data) {
                this.page = 1
                this.products = []
                this.loadPosts()
            },
        },
        mounted() {
            this.loadPosts()

        },
        methods: {
            loadMore() {
                this.page++
                this.loadPosts()
            },

            loadPosts() {
                if (this.busy) return
                this.busy = true
                $.ajax({
                    url: '/wp-json/v1/products/get',
                    data: {
                        security: iteaData.nonce,
                        language: iteaData.language,
                        data: {
                            filter: this.tab,
                            page: this.page,
                        }
                    },
                    type: 'GET',
                    success: (data) => {
                        console.log(data)
                        if (data.data) {
                            this.products = this.products.concat(data.data)
                        }
                        this.total_posts = data.found_posts
                        this.total_pages = data.max_num_pages
                    },
                    complete: () => {
                        this.busy = false
                    }
                })
            }
        }
    }
</script>
