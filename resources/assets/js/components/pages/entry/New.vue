<template>
  <div class="container">
    <h3>Nueva Estadística</h3>
    <hr>

    <p>
      <a href="#" class="btn btn-primary" @click.prevent="$router.go(-1)">Volver</a>
    </p>

    <div class="row">
      <div class="col-md-8 col-md-offset-2">
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
import { mapActions } from 'vuex'
import EntryForm from './partials/Form.vue'

export default {

  components: {
    EntryForm,
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

  computed: {},

  methods: {

    ...mapActions([
      'storeEntry',
      'addToastMessage',
    ]),

    onSubmit (form) {
      this.storeEntry(form)
        .then(() => {
          this.addToastMessage({
            text: 'El nuevo registro fue ingresado correctamente',
            type: 'success',
          })
          this.$router.go(- 1)
        })
        .catch((data) => {
          this.errors = data.errors || {}
        })
    },

  },
}
</script>
