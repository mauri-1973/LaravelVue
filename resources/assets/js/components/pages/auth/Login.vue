<template>
  <div class="container">
    <h3>Ingreso al Demo</h3>
    <hr>

    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
          <div class="panel-heading">Ingreso</div>
          <div class="panel-body">

            <div v-if="error" class="alert alert-danger">
              {{ error }}
            </div>

            <form id="login_form" class="form-horizontal" role="form" @submit.prevent="onSubmit">

              <div class="form-group" :class="{ 'has-error': errors.email }">
                <label for="email" class="col-md-4 control-label">E-Mail</label>
                <div class="col-md-6">
                  <input id="email" v-model.trim="form.email" type="email" class="form-control" required autofocus>
                  <div v-if="errors.email" class="help-block">
                    <div v-for="(err, index) in errors.email" :key="index"><strong>{{ err }}</strong></div>
                  </div>
                </div>
              </div>

              <div class="form-group" :class="{ 'has-error': errors.password }">
                <label for="password" class="col-md-4 control-label">Contraseña</label>
                <div class="col-md-6">
                  <input id="password" v-model.trim="form.password" type="password" class="form-control" required>
                  <div v-if="errors.password" class="help-block">
                    <div v-for="(err, index) in errors.password" :key="index"><strong>{{ err }}</strong></div>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <div class="col-md-8 col-md-offset-4">
                  <button type="submit" class="btn btn-primary">Ingreso</button>
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
        email: Laravel.demoMode ? 'admin@gmail.com' : '',
        password: Laravel.demoMode ? '123456' : '',
      },
      error: '',
      errors: {},
    }
  },

  computed: {
    ...mapState({
      me: state => state.auth.me,
    }),
  },

  methods: {

    ...mapActions([
      'login',
      'addToastMessage',
    ]),

    onSubmit () {
      this.errors = {}
      this.login(this.form)
        .then(() => {
          this.addToastMessage({
            text: 'Usuario Registrado',
            type: 'success',
          })
          this.$router.replace('/dashboard')
        })
        .catch((data) => {
          this.error = data.message
          this.errors = data.errors || {}
        })
    },

  },
}
</script>
