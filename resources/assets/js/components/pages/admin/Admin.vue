<template>
  <div class="container">
    <h3>Panel Administrativo</h3>
    <hr>

    <div class="row">
      <div class="col-sm-2">
        <ul class="nav nav-pills nav-stacked">
          <RouterLink v-slot="{ navigate, href, isActive }" custom to="/admin/dashboard">
            <li :class="{active: isActive}">
              <a :href="href" @click="navigate">Panel</a>
            </li>
          </RouterLink>
          <RouterLink v-slot="{ navigate, href, isActive }" custom to="/admin/users">
            <li :class="{active: isActive}">
              <a :href="href" @click="navigate">Usuarios</a>
            </li>
          </RouterLink>
          <RouterLink v-if="me.role == 'admin'" v-slot="{ navigate, href, isActive }" custom to="/admin/entries">
            <li :class="{active: isActive}">
              <a :href="href" @click="navigate">Estadísticas</a>
            </li>
          </RouterLink>
        </ul>
      </div>
      <div class="col-sm-10">
        <router-view />
      </div>
    </div>
  </div>
</template>

<script>
import { mapState } from 'vuex'

export default {

  data () {
    return {}
  },

  computed: {
    ...mapState({
      me: state => state.auth.me,
    }),
  },

  methods: {},
}
</script>
