<template>
  <nav class="navbar navbar-default navbar-static-top">
    <div class="container">
      <div class="navbar-header">

        <!-- Collapsed Hamburger -->
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
          <span class="sr-only">Toggle Navigation</span>
          <span class="icon-bar" />
          <span class="icon-bar" />
          <span class="icon-bar" />
        </button>

        <!-- Branding Image -->
        <RouterLink class="navbar-brand" to="/">Demo Oscar Zambrano</RouterLink>
      </div>

      <div id="app-navbar-collapse" class="collapse navbar-collapse">
        <!-- Left Side Of Navbar -->
        <ul class="nav navbar-nav">
          &nbsp;
        </ul>

        
        <!-- Right Side Of Navbar -->
        <ul v-if="me" class="nav navbar-nav navbar-right">
          <!-- Authentication Links -->
          <RouterLink v-slot="{ navigate, href, isActive }" custom to="/dashboard">
            <li :class="{active: isActive}">
              <a :href="href" @click="navigate">Inicio</a>
            </li>
          </RouterLink>
          <RouterLink v-slot="{ navigate, href, isActive }" custom to="/entries">
            <li :class="{active: isActive}">
              <a :href="href" @click="navigate">Entradas</a>
            </li>
          </RouterLink>

          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
              Reportes <span class="caret" />
            </a>

            <ul class="dropdown-menu" role="menu">
              <RouterLink v-slot="{ navigate, href, isActive }" custom to="/report/weekly">
                <li :class="{active: isActive}">
                  <a :href="href" @click="navigate">Semanal</a>
                </li>
              </RouterLink>
            </ul>
          </li>

          <RouterLink
            v-if="me.role === 'admin' || me.role === 'manager'"
            v-slot="{ navigate, href, isActive }"
            custom
            to="/admin"
          >
            <li :class="{active: isActive}">
              <a :href="href" @click="navigate">Panel Administrador</a>
            </li>
          </RouterLink>

          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
              {{ me.name }} <span class="caret" />
            </a>

            <ul class="dropdown-menu" role="menu">
              <RouterLink v-slot="{ navigate, href, isActive }" custom to="/profile">
                <li :class="{active: isActive}">
                  <a :href="href" @click="navigate">Perfil</a>
                </li>
              </RouterLink>
              <RouterLink v-slot="{ navigate, href, isActive }" custom to="/logout">
                <li :class="{active: isActive}">
                  <a :href="href" @click="navigate">Salir</a>
                </li>
              </RouterLink>
            </ul>
          </li>
        </ul>

        <!-- Right Side Of Navbar -->
        <ul v-else class="nav navbar-nav navbar-right">
          <!-- Authentication Links -->
          <RouterLink v-slot="{ navigate, href, isActive }" custom to="/login">
            <li :class="{active: isActive}">
              <a :href="href" @click="navigate">Ingreso</a>
            </li>
          </RouterLink>
          <RouterLink v-slot="{ navigate, href, isActive }" custom to="/register">
            <li :class="{active: isActive}">
              <a :href="href" @click="navigate">Registro</a>
            </li>
          </RouterLink>
        </ul>

      </div>
    </div>
  </nav>
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
      route: state => state.route,
    }),
  },

  watch: {
    route () {
      this.$forceUpdate() 
    },
  },

  mounted () {
    
  },

  methods: {
    
  },
}
</script>
