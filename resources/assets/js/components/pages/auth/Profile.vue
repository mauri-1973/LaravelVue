<template>
  <div class="container">
    <h3>Mi Perfil</h3>
    <hr>

    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
          <div class="panel-heading">Mi perfil de Usuario</div>
          <div class="panel-body">
            <form id="profile_form" class="form-horizontal" role="form" @submit.prevent="onSubmit">

              <div class="form-group" :class="{ 'has-error': errors.name }">
                <label for="name" class="col-md-4 control-label">Name</label>
                <div class="col-md-6">
                  <input id="name" v-model="form.name" type="text" class="form-control" required autofocus>
                  <div v-if="errors.name" class="help-block">
                    <div v-for="(error, index) in errors.name" :key="index"><strong>{{ error }}</strong></div>
                  </div>
                </div>
              </div>

              <div class="form-group" :class="{ 'has-error': errors.email }">
                <label for="email" class="col-md-4 control-label">E-Mail</label>
                <div class="col-md-6">
                  <input id="email" v-model="form.email" type="email" class="form-control" required>
                  <div v-if="errors.email" class="help-block">
                    <div v-for="(error, index) in errors.email" :key="index"><strong>{{ error }}</strong></div>
                  </div>
                </div>
              </div>

              <div class="form-group" :class="{ 'has-error': errors.password }">
                <label for="password" class="col-md-4 control-label">Contraseña</label>

                <div class="col-md-6">
                  <input id="password" v-model="form.password" type="password" class="form-control">
                  <div v-if="errors.password" class="help-block">
                    <div v-for="(error, index) in errors.password" :key="index"><strong>{{ error }}</strong></div>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label for="password-confirm" class="col-md-4 control-label">Repita su Contraseña</label>
                <div class="col-md-6">
                  <input
                    id="password-confirm"
                    v-model="form.password_confirmation"
                    type="password"
                    class="form-control"
                  >
                </div>
              </div>

              <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                  <button type="submit" class="btn btn-primary">
                    Actualizar
                  </button>
                </div>
              </div>
            </form>
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
    return {
      form: {
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
      },
      errors: {},
    }
  },

  computed: {
    ...mapState({
      me: state => state.auth.me,
    }),
  },

  mounted () {
    this.form.name = this.me.name
    this.form.email = this.me.email
  },

  methods: {

    ...mapActions([
      'updateProfile',
      'addToastMessage',
    ]),

    onSubmit () {
      this.errors = {}
      this.updateProfile({ id: this.me.id, form: this.form })
        .then(() => {
          this.addToastMessage({
            text: 'Su perfil fue actualizado',
            type: 'success',
          })
        })
        .catch((data) => {
          this.errors = data.errors || {}
        })
    },

  },

}
</script>
