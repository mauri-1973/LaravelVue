<template>
  <div id="dashboard" class="container">
    <h3>Resumen</h3>
    <hr>

    <div class="row">
      <div class="col-sm-6">

        <div class="panel panel-default">
          <div class="panel-heading">Por Semana</div>
          <div class="panel-body">
            <p>Registros: <strong>{{ dashboard.weekly_count }}</strong></p>
            <p>Velocidad Media: <strong>{{ Number(dashboard.weekly_avg_speed).toFixed(2) }} km/h</strong></p>
            <p>Promedio: <strong>{{ Number(dashboard.weekly_avg_pace).toFixed(2) }} min/km</strong></p>
          </div>
        </div>

        <div class="panel panel-default">
          <div class="panel-heading">Mejores Resultados</div>
          <div class="panel-body">
            <p>Mejor Velocidad: <strong>{{ Number(dashboard.max_speed).toFixed(2) }} km/h</strong></p>
            <p>Distancia más Larga: <strong>{{ dashboard.max_distance }} km</strong></p>
            <p>Mejor Tiempo: <strong>{{ dashboard.max_time }}</strong></p>
          </div>
        </div>

      </div>
      <div class="col-sm-6">

        <div class="panel panel-default">
          <div class="panel-heading">Datos</div>
          <Line
            :chart-options="{responsive: true, maintainAspectRatio: false}"
            :chart-data="chartData"
            :height="250"
          />
        </div>

        <div class="panel panel-default">
          <div class="panel-heading">Agregar nuevo registro</div>
          <div class="panel-body">
            <entry-form :form="form" :errors="errors" @onSubmit="onSubmit" />
          </div>
        </div>

      </div>
    </div>

  </div>
</template>

<script>
import { mapState, mapActions } from 'vuex'
import EntryForm from '../entry/partials/Form'
import 'chart.js/auto'
import { Line } from 'vue-chartjs'

export default {

  components: {
    EntryForm,
    Line,
  },

  data () {
    return {
      errors: {},
      form: {
        date: '',
        distance: '',
        time_hours: '00',
        time_minutes: '00',
        time_seconds: '00',
      },
    }
  },

  computed: {
    ...mapState({
      me: state => state.auth.me,
      dashboard: state => state.general.dashboard,
    }),

    chartData () {
      if (! this.dashboard.week_chart) return {}
      return {
        labels: this.dashboard.week_chart.map(i => i[0]),
        datasets: [
          {
            label: 'Velocidad',
            borderColor: '#f87979',
            data: this.dashboard.week_chart.map(i => i[1]),
            tension: 0.2,
          },
          {
            label: 'Disttancia',
            borderColor: '#7acbf9',
            data: this.dashboard.week_chart.map(i => i[2]),
            tension: 0.2,
          },
        ],
      }
    },
  },

  mounted () {
    this.loadDashboard()
  },

  methods: {
    ...mapActions([
      'loadDashboard',
      'storeEntry',
      'addToastMessage',
    ]),

    onSubmit (form) {
      this.storeEntry(form)
        .then(() => {
          this.loadDashboard()
          this.addToastMessage({
            text: 'Nuevo registro ingresado',
            type: 'success',
          })
          this.form = {
            date: '',
            distance: '',
            time_minutes: '00',
            time_seconds: '00',
          }
          this.errors = {}
        })
        .catch((data) => {
          this.errors = data.errors || {}
        })
    },
  },
}
</script>
