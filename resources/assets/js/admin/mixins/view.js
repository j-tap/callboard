// ToDo - add api routes

var mixins = {
    data() {
        return {
            pageTitle: '',
            breadcrumbs: [],
            errors: [],
        };
    },

    mounted() {
        this.onCreated();
    },

    methods: {
        onCreated() {
            if (this._uid != 0) {
                this.breadcrumbs = [];

                if (this.$route.meta.breadcrumbs !== null) {
                    this.breadcrumbs = Object.assign([], this.$route.meta.breadcrumbs);
                } else
                    this.breadcrumbs = [];

                this.pageTitle = this.$route.meta.title;

                this.setTitle(this.pageTitle);
                this.setBreadcrumbs(this.breadcrumbs);

                if (this.$route.meta.permission) {
                    if (!_.get(this.$root.profile.permissions, this.$route.meta.permission)) {
                        this.$router.push({name: 'home'});
                    }
                }
            }
        },

        setTitle(title) {
            this.$root.$emit('setTitle', title);
        },

        setBreadcrumbs(crumbs) {
            this.$root.$emit('setBreadcrumbs', crumbs);
        },

        addBreadcrumb(crumb) {
            this.$root.$emit('addBreadcrumb', crumb);
        },

        clearBreadcrumbs() {
            this.$root.$emit('clearBreadcrumbs');
        },

        showAlert(message) {
            this.$message({
                message: message,
                type: 'info',
                showClose: true
            })
        },

        showError(message) {
            this.$message({
                message: message,
                type: 'error',
                showClose: true
            })
        },

        messageSaved() {
            this.$message({
                message: 'Успешно сохранено',
                type: 'success',
                showClose: true
            })
        },

        messageCreatedDeal(id) {
            this.$message({
                message: 'Успешно создана заявка '+id,
                type: 'success',
                showClose: true
            })
        },

        messageSuccessModeration() {
            this.$message({
                message: 'Сделка опубликована',
                type: 'success',
                showClose: true
            })
        },

        messageFailsModeration() {
            this.$message({
                message: 'Сделка отклонена',
                type: 'error',
                showClose: true
            })
        },

        messageDeleted() {
            this.$message({
                message: 'Элемент был удален',
                type: 'success',
                showClose: true
            })
        },

        messageCreated() {
            this.$message({
                message: 'Элемент успешно создан',
                type: 'success',
                showClose: true
            })
        },

        messageFormError() {
            this.$message({
                message: 'Ошибка заполнения формы',
                type: 'error',
                showClose: true
            })
        },

        messageLoadError() {
            this.$message({
                message: 'Ошибка загрузки данных',
                type: 'error',
                showClose: true
            })
        },

        goToNotFound() {
            this.$router.push('/admin/404');
        },

        handleErrorResponse(error) {
            if (error.response && error.response.data.errors)
                this.errors = error.response.data.errors;
        }

    },

    computed: {}
}

export default mixins;