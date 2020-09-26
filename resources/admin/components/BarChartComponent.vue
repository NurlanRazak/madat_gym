<script>
import { Bar } from 'vue-chartjs'

export default {
  extends: Bar,
  props: ['labels', 'data'],
  computed: {
      //
  },
  mounted () {
    this.renderChart({
      labels: this.labels,
      datasets: this.data
    })
  }
}
</script>
