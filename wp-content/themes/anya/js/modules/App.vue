<script>
    export default {
        name: 'App',
        el: '#calculator',
        components: {
            // HelloWorld
        },
        data() {
            return {
                busy: false,
                tab: 1,
                cityFrom: null,
                cityTo: null,
                type: "store-door",
                parameters: null,
                length: null,
                width: null,
                height: null,
                weight: null,
                monthShips: null,
                declaredPrice: null,
                errors: [],
                maxSideSize: 180,
                maxSize: 180,
                declaredCoefficient: 0.005,
                cityPrice: 400,
                regionPrice: 650,
                anotherCityPrice: 100,
                anotherRegionPrice: 150,
                emailData: {
                    name: null,
                    email: null,
                    phone: null,
                    site: null,
                },
                emailSend: false,
            }
        },
        computed: {
            price: function () {

            },
        },
        watch: {
            length: function () {
                this.length = Number(this.length.replace(/[^0-9.]/g, ''))
            },
        },
        mounted() {


        },
        methods: {
            setCityFrom(data) {
                console.log(data)
                this.cityFrom = data

                if (this.cityFrom) {
                    document.querySelector('#cityFrom input').value = this.cityFrom.value
                }
            },
            sendEmail() {

                fetch("/wp-admin/admin-ajax.php",
                    {
                        method: "POST",
                        body: data,
                    })
                    .then(response => response.json())
                    .then((data) => {
                        this.busy = false
                        console.log(data)
                        this.emailData = {
                            name: null,
                            email: null,
                            phone: null,
                            site: null,
                        }
                        this.emailSend = true
                        setTimeout(() => {
                            this.emailSend = false
                        }, 5000)
                        // if (data.code === 200) {
                        // }
                    })
                    .catch((e) => {
                        this.busy = false
                        console.log('ошибка', e)
                    })
            },
        }
    }
</script>
