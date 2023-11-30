<template>
  <div id="admin-dashboard">
    <h3>Resumen</h3>
    <hr>

    <div class="row">
      <div class="col-sm-6">

        <div class="panel panel-default">
          <div class="panel-heading">Estado Usuarios</div>
          <div class="panel-body">
            <p>Total usuarios: <strong>{{ admin_dashboard.total_users }}</strong></p>
            <p>Nuevos usuarios semanales: <strong>{{ admin_dashboard.new_users_this_week }}</strong></p>
            <p>Nuevos usuarios mensuales: <strong>{{ admin_dashboard.new_users_this_month }}</strong></p>
          </div>
        </div>

      </div>

      <div class="col-sm-6">

        <div class="panel panel-default">
          <div class="panel-heading">Estado Entradas</div>
          <div class="panel-body">
            <p>Total entradas: <strong>{{ admin_dashboard.total_entries }}</strong></p>
            <p>Entradas medias por usuario: <strong>{{ admin_dashboard.avg_entries_per_user }}</strong></p>
            <p>Carrera más rápida: <strong>
              <RouterLink :to="'/entry/edit/' + admin_dashboard.fastest_run.id">
                {{ Number(admin_dashboard.fastest_run.speed).toFixed(2) }}
              </RouterLink>
              km/h
              (
              <RouterLink :to="'/admin/user/show/' + admin_dashboard.fastest_run.user.id">
                {{ admin_dashboard.fastest_run.user.name }}
              </RouterLink>
              )
            </strong></p>
            <p>Carrera más larga: <strong>
              <RouterLink :to="'/entry/edit/' + admin_dashboard.longest_run.id">{{
                admin_dashboard.longest_run.distance
              }}
              </RouterLink>
              km
              (
              <RouterLink :to="'/admin/user/show/' + admin_dashboard.longest_run.user.id">
                {{ admin_dashboard.longest_run.user.name }}
              </RouterLink>
              )
            </strong></p>
          </div>
        </div>

      </div>
    </div>

  </div>
</template>

<script>
import { mapState, mapActions } from 'vuex'

export default {

  data () {
    return {}
  },

  computed: {
    ...mapState({
      admin_dashboard: state => state.general.admin_dashboard,
    }),
  },

  mounted () {
    this.loadAdminDashboard()
  },

  methods: {
    ...mapActions([
      'loadAdminDashboard',
    ]),
  },
}
</script>
