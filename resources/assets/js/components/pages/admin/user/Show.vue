<template>
  <div>
    <h3>User: {{ user.name }}</h3>
    <hr>

    <div class="row marginbot10">
      <div class="col-sm-6">
        <a href="#" class="btn btn-primary" @click.prevent="$router.go(-1)">Volver</a>
      </div>
      <div class="col-sm-6 text-right">
        <RouterLink :to="'/admin/user/edit/' + user.id" class="btn btn-primary">Editar</RouterLink>
      </div>
    </div>

    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
          <div class="panel-heading">Info Usuario</div>
          <div class="panel-body">
            <p>Name: <strong>{{ user.name }}</strong></p>
            <p>Email: <strong>{{ user.email }}</strong></p>
            <p>Role: <strong>{{ user.role }}</strong></p>
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
      user: state => state.users.user,
    }),

    id () {
      return this.$route.params.id
    },

  },

  mounted () {
    this.loadUser(this.id)
  },

  methods: {

    ...mapActions([
      'loadUser',
    ]),

  },
}
</script>
