<template>
  <div>
    <h3>Tiempos Registrados</h3>
    <hr>

    <div class="row marginbot10">
      <div class="col-sm-6 filters">
        <div class="input-group">
          <span class="input-group-addon">Desde:</span>
          <input v-model="dateFrom" type="date" class="form-control date-filter" placeholder="Fecha Desde">
          <span class="input-group-addon">Hasta:</span>
          <input v-model="dateTo" type="date" class="form-control date-filter" placeholder="Fecha hasta">
          <span class="input-group-btn">
            <button class="btn btn-primary" @click="onFilter">Filtrar</button>
          </span>
          <span class="input-group-btn">
            <button class="btn btn-default" @click="onFilterClear">Limpiar</button>
          </span>
        </div>
      </div>
      <div class="col-sm-6 text-right">
        <span class="page-info">Página {{ entries.current_page }} de  {{ entries.last_page }}</span>
      </div>
    </div>

    <div class="panel panel-default">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Usuario</th>
            <th>Fecha</th>
            <th>Distancia</th>
            <th>Tiempo</th>
            <th>Velocidad Media</th>
            <th>Promedio</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <row v-for="entry in entries.data" :key="entry.id" :row="entry" @onDelete="onDelete" />
        </tbody>
      </table>
    </div>

    <div v-if="entries.last_page > 1" class="text-right">
      <ul class="pagination marginpulltop15">
        <li v-for="page in range(1, entries.last_page)" :key="page" :class="{active: page == entries.current_page}">
          <a href="#" @click.prevent="onLoadEntries(page)">{{ page }}</a>
        </li>
      </ul>
    </div>

  </div>
</template>

<script>
import { mapState, mapActions } from 'vuex'
import Row from './partials/Row.vue'

export default {

  components: {
    Row,
  },

  data () {
    return {
      dateFrom: '',
      dateTo: '',
    }
  },

  computed: {
    ...mapState({
      entries: state => state.all_entries.entries,
    }),

    params () {
      return {
        page: this.entries.current_page,
        dateFrom: this.dateFrom,
        dateTo: this.dateTo,
      }
    },
  },

  mounted () {
    this.loadAllEntries(this.params)
  },

  methods: {

    ...mapActions([
      'loadAllEntries',
      'deleteEntry',
      'addToastMessage',
    ]),

    onLoadEntries (page) {
      this.loadAllEntries({ ...this.params, page })
    },

    onFilter () {
      this.loadAllEntries({ ...this.params, page: 1 })
    },

    onFilterClear () {
      this.dateFrom = ''
      this.dateTo = ''
      this.loadAllEntries(this.params)
    },

    onDelete (id) {
      this.deleteEntry(id).then(() => {
        this.addToastMessage({
          text: 'Registro eliminado',
          type: 'success',
        })
        this.loadAllEntries(this.params)
      })
    },

  },
}
</script>
