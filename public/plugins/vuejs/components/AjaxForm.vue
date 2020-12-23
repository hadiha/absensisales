<template lang="html">
    <div class="ui form">
        <div v-if="reloading !== null && loading" class="ui active inverted dimmer">
            <div class="ui text loader">Loading</div>
        </div>
        <form @submit.prevent="onSubmit()">
            <slot></slot>
        </form>
    </div>
</template>

<script>
import Fillable from './mixins/FillableMixins.js'

export default {
    mixins: [Fillable],
    props: {
        apiUrl: {},
        populating: {
            default: null,
        },
        redirection: {},
        method: {
            default: "post",
        },
        reloading: {
            default: null,
        },
    },
    data () {
        return {
            loading: false,
        }
    },
    computed: {
        isPopulating() {
            if (this.populating !== null) {
                return true
            }

            return false
        }
    },
    methods: {
        init() {
            if (this.isPopulating) {
                const self = this
                this.$http.get(this.apiUrl).then((response) => {
                    const els = $(this.$el).find(':input')
                    const self = this
                    const data = response.data

                    self.fillElements(els, data)

                    this.id = data.id
                })
            }
        },
        onSubmit() {
            var formData = new FormData($(this.$el).find('form')[0])
            const self = this
            this.loading = true

            if (this.method == 'put') {
                formData.append('_method', 'PUT');
            }

            this.$http.post(this.apiUrl, formData).then((response) => {
                $(this.$el).find('.errorMsg').remove()
                $(':input').removeClass('error')
                self.$dispatch(
                    'pop-message',
                    'success',
                    'Transaksi data berhasil!',
                    response.data.msg
                )

                self.processing = false
                self.$broadcast('form:success', self.name, response.data)

                if (self.redirection) {
                    window.location.replace(self.redirection)
                    // window.location.href = self.redirection
                }
                this.loading = false
            }, (response) => {
                self.notifyFields(response.data)
                this.loading = false
            })
        },
        notifyFields(data) {
            this.$broadcast('form:error', data)
            $(this.$el).find('.errorMsg').remove()
            $(':input').removeClass('error')
            var focused = false
            _.each(data, (val, key) => {
                var input = $(this.$el).find('[name='+key+']')
                if (!focused) {
                    focused = true
                    input.focus()
                }
                input.addClass('error')
                input.closest('.field').append('<small class="errorMsg" style="color: red">'+val+'</small>')
            })

            //Force custom, Sorry :-(. @bekatama
            if($(".daftar_alat").length){ 
                $(".daftar_alat").show()
            } 
        }
    },
    ready() {
        this.init()
    }
}
</script>

<style lang="css">
    .error {
        border-color: red !important;
    }
</style>
