<script>
import VueCharts from 'vue-chartjs'
import { Line } from 'vue-chartjs'

export default {
    extends: Line,
    props: ['data', 'options', 'labels'],
    mounted () {
      this.renderChart({
        labels: this.labels,
        datasets: this.data,
      }, {responsive: true, maintainAspectRatio: false})
    }
}
</script>
