window.ApiFilter = {

    async filterNews(filter) {
        return new Promise((resolve, reject) => {
            axios.get('/api/v1/filter/news' + Api.toQuery(filter)).then((resp) => {
                resolve(resp.data.data)
            }).catch((error) => {
                resolve(error)
            });
        });
    },

    async filterMarkers(filter) {
        return new Promise((resolve, reject) => {
            axios.get('/api/v1/filter/markers' + Api.toQuery(filter)).then((resp) => {
                resolve(resp.data.data)
            }).catch((error) => {
                resolve(error)
            });
        });
    },

};