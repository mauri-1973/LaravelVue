<template>
  <div>
    <h3>Usuarios</h3>
    <hr>

    <div class="row marginbot10">
      <div class="col-sm-6 form-inline">
        <div class="input-group">
          <input v-model="search" type="text" class="form-control">
          <span class="input-group-btn">
            <button class="btn btn-primary" @click="onSearch">Buscar</button>
          </span>
        </div>
      </div>
      <div class="col-sm-6 text-right">
        <span class="page-info">Página {{ users.current_page }} de {{ users.last_page }}</span>
      </div>
    </div>

    <div class="panel panel-default">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Nombre</th>
            <th>Email</th>
            <th>Rol</th>
            <th>Fecha de Ingreso</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <row v-for="user in users.data" :key="user.id" :row="user" @onDelete="onDelete" />
        </tbody>
      </table>
    </div>

    <div v-if="users.last_page > 1" class="text-right">
      <ul class="pagination marginpulltop15">
        <li v-for="page in range(1, users.last_page)" :key="page" :class="{active: page == users.current_page}">
          <a href="#" @click.prevent="onLoadEntries(page)">{{ page }}</a>
        </li>
      </ul>
    </div>

  </div>
</template>

<script>
import { mapState, mapActions } from 'vuex'
import Row from './partials/Row'

export default {

  components: {
    Row,
  },

  data () {
    return {
      search: '',
    }
  },

  computed: {
    ...mapState({
      users: state => state.users.users,
    }),

    params () {
      return {
        page: this.users.current_page,
        query: this.search,
      }
    },
  },

  mounted () {
    this.loadUsers(this.params)
  },

  methods: {

    ...mapActions([
      'loadUsers',
      'deleteUser',
      'addToastMessage',
    ]),

    onLoadEntries (page) {
      this.loadUsers({ ...this.params, page })
    },

    onSearch () {
      this.loadUsers({ ...this.params, page: 1 })
    },

    onDelete (id) {
      this.deleteUser(id).then(() => {
        this.addToastMessage({
          text: 'Usuario eliminado correctamente',
          type: 'success',
        })
        this.loadUsers(this.params)
      })
    },

  },
}
</script>
