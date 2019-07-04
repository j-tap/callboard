<script>
    import {Bar} from 'vue-chartjs'

    export default {
        extends: Bar,
        props: ['chartdata', 'options'],
        data() {
            return {
                gradient: null,
                gradient2: null
            }
        },
        mounted() {
            this.gradient = this.$refs.canvas.getContext('2d').createLinearGradient(0, 0, 0, 450)

            this.gradient.addColorStop(0, 'rgba(255, 0,0, 0.5)')
            this.gradient.addColorStop(0.5, 'rgba(255, 0, 0, 0.25)');
            this.gradient.addColorStop(1, 'rgba(255, 0, 0, 0)');

            this.renderChart({
                labels: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
                datasets: [
                    {
                        label: 'Data One',
                        pointBackgroundColor: 'white',
                        borderWidth: 1,
                        pointBorderColor: 'white',
                        backgroundColor: this.gradient,
                        backgroundColor: '#f87979',
                        data: [20, 12, 39, 10, 40, 39, 80, 40, 20, 12, 11]
                    }
                ]
            }, {responsive: true, maintainAspectRatio: false})
        }
    }
</script>

<style scoped>

</style>