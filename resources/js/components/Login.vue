<template>
  <v-app id="login" class="secondary">
    <v-content>
      <v-container fluid fill-height>
        <v-layout align-center justify-center>
          <v-flex xs12 sm8 md4 lg4>
            <v-card class="elevation-1 pa-3">
              <v-card-text>
                <div class="layout column align-center">
                  <img src="http://localhost:8000/images/logo.png" alt="SIBENTO Login Panel" width="180" height="180">
                  <h1 class="flex my-4 primary--text">SIBENTO Login Panel</h1>
                </div>
                <v-form>
                  <v-text-field
                    append-icon="person"
                    name="login"
                    label="Username"
                    type="text"
                    v-model="username"
                    :error="error"
                    :rules="[rules.required]"/>
                  <v-text-field
                    :type="hidePassword ? 'password' : 'text'"
                    :append-icon="hidePassword ? 'visibility_off' : 'visibility'"
                    name="password"
                    label="Password"
                    id="password"
                    :rules="[rules.required]"
                    v-model="password"
                    :error="error"
                    @click:append="hidePassword = !hidePassword"/>
                </v-form>
              </v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn block color="primary" @click="login" :loading="loading">Login</v-btn>
              </v-card-actions>
            </v-card>
          </v-flex>
        </v-layout>
      </v-container>
      <v-snackbar
        v-model="showResult"
        :timeout="2000"
        top>
        {{ result }}
      </v-snackbar>
      <!-- Alert -->
      <v-snackbar right bottom :color="alert.type"  value="true" v-if="alert.type">
        <v-icon>{{alert.icon}}</v-icon>{{alert.message}}
      </v-snackbar>
    </v-content>
  </v-app>
</template>

<script>
import auth from '../service/Auth'
export default {
  data() {
    return {
      loading: false,
      username: '',
      password: '',
      hidePassword: true,
      error: false,
      showResult: false,
      result: '',
      alert:{
        type: null,
        message: null,
        icon: null,
      },
      rules: {
        required: value => !!value || 'Required.'
      }
    }
  },

  methods: {
    async login() {
        try {
          const data= {
            username : this.username,
            password : this.password,
          }


          await auth.authenticate(data)
          this.$router.push({ name: 'AdminDashboard' })
        } catch (err) {
           this.showAlert('error','Gagal Login, Username atau Password salah!')
        }
    },
    showAlert (type,alert_message) {

        if(type == 'success'){
          this.alert.icon = 'fas fa-check-circle'
        }
        else if(type == 'error'){
          this.alert.icon = 'fas fa-exclamation-circle'
        }

        this.alert.type = type
        this.alert.message = alert_message
        
        let timer = this.showAlert.timer
        if (timer) {
          clearTimeout(timer)
        }
        this.showAlert.timer = setTimeout(() => {
            this.alert.type = null
            this.alert.icon = null
            this.alert.message = null
        }, 3000)
        
      }
  }
}
</script>

<style scoped lang="css">
  #login {
    height: 50%;
    width: 100%;
    position: absolute;
    top: 0;
    left: 0;
    content: "";
    z-index: 0;
    
  }
  .secondary{
      background-color:#1565C0 !important;
  }
</style>
