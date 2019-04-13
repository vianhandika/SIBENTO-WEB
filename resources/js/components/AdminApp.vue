<template>
<v-app id="inspire">
<div class="application">
  <!-- toolbar   -->
  <v-toolbar 
    dark 
    app 
    :color="$root.themeColor"
    v-if="!isLoginPage">
    <v-toolbar-title>
      <v-toolbar-side-icon @click.stop="drawer = !drawer"></v-toolbar-side-icon>
    </v-toolbar-title>

    <v-spacer></v-spacer>

    <v-dialog v-model="dialogSettings"
      width="700">
      <v-card>
        <v-card-title class="headline"
          primary-title>
          Pengaturan Akun
        </v-card-title>

        <v-card-text>
          Ubah Password 
          <v-form>
            <v-container>
              <v-layout row wrap>

                <v-flex xs12 xs6 md1 />

                <v-flex xs12 sm6 md11>
                  <v-text-field
                    v-model="password"
                    :append-icon="showPassword ? 'visibility_off' : 'visibility'"
                    :type="showPassword ? 'text' : 'password'"
                    label="Password Baru"
                    @input="$v.password.$touch()"
                    @blur="$v.password.$touch()"
                    :error-messages="passwordErrors" />
                </v-flex>

                <v-flex xs12 sm6 md1 />

                <v-flex xs12 sm6 md11>
                  <v-text-field
                    v-model="passwordConfirm"
                    :append-icon="showPasswordConfirm ? 'visibility_off' : 'visibility'"
                    :type="showPasswordConfirm ? 'text' : 'password'"
                    label="Konfirmasi Password Baru"
                    @input="$v.passwordConfirm.$touch()"
                    @blur="$v.passwordConfirm.$touch()"
                    :error-messages="confirmpasswordErrors" />
                </v-flex>

                <v-flex xs12 sm6 md1 />

                <v-flex xs12 xs6 md1 />

              </v-layout>
            </v-container>
          </v-form>
        </v-card-text>

        <v-divider></v-divider>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="primary"
            flat
            :disabled="$v.passwordConfirm.$invalid"
            @click="savepassword">
            Save Changes
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>


    <v-menu offset-y origin="center center" :nudge-bottom="10" transition="scale-transition">

      <v-btn icon flat slot="activator" @click="notifications.map(x => x.isActive = false)">
        <v-badge color="green" overlap>
          <span slot="badge" v-if="notifications.filter(x => x.isActive).length > 0">
             {{ notifications.filter(x => x.isActive).length }}
          </span>
          <v-icon medium>notifications</v-icon>
        </v-badge>
      </v-btn>

      <v-card class="elevation-0">
        <v-toolbar card dense color="transparent">
          <v-toolbar-title><h5>You have {{ notifications.length }} new notification(s)</h5></v-toolbar-title>
        </v-toolbar>
        <v-card-text class="pa-0">
          <v-list two-line class="pa-0">
          <template v-for="(item, index) in notifications">
            <v-divider :key="index" />
            <v-list-tile avatar :key="item.title">
            <!-- <v-list-tile avatar :key="item.title" @click.parent="item.onClick"> -->
            <v-list-tile-avatar :color="item.color">
              <v-icon dark>{{item.icon}}</v-icon>
            </v-list-tile-avatar>
            <v-list-tile-content>
              <v-list-tile-sub-title v-html="item.title"></v-list-tile-sub-title>
            </v-list-tile-content>
            <v-list-tile-action class="caption">
              {{item.actionAt}}
            </v-list-tile-action>
            </v-list-tile>
          </template>
          </v-list>
          <v-divider></v-divider>
          <v-btn block flat v-if="false">See all notifications</v-btn>
          <v-divider></v-divider>
        </v-card-text>
      </v-card>
    </v-menu>

    <v-menu offset-y origin="center center" :nudge-bottom="10" transition="scale-transition">
      <v-btn icon large flat slot="activator" :ripple="false">
        <v-avatar size="42px">
          <img src="https://avataaars.io/?avatarStyle=Circle&topType=ShortHairShortFlat&accessoriesType=Sunglasses&hairColor=Black&facialHairType=Blank&clotheType=CollarSweater&clotheColor=Black&eyeType=Default&eyebrowType=Default&mouthType=Smile&skinColor=Light"/>
        </v-avatar>
      </v-btn>
      <v-list>
        <v-list-tile
          v-for="(item,index) in items"
          :key="index"
          :to="!item.href ? { name: item.name } : null"
          :href="item.href"
          ripple="ripple"
          :disabled="item.disabled"
          :target="item.target"
          @click="item.click">
          <v-list-tile-action v-if="item.icon">
            <v-icon>{{ item.icon }}</v-icon>
          </v-list-tile-action>
          <v-list-tile-content>
            <v-list-tile-title>{{ item.title }}</v-list-tile-title>
          </v-list-tile-content>
        </v-list-tile>
      </v-list>
    </v-menu>
  </v-toolbar>

  <!-- side menu -->
  <v-navigation-drawer

    v-model="drawer"
    fixed app
    v-if="!isLoginPage && panel !=null && selectedMenu">
    <v-toolbar flat dark :color="$root.themeColor" class="toolbar">
      <router-link :to="{ name: 'AdminDashboard' }">
        <img src="http://localhost:8000/images/logo.png" width="36px">
      </router-link>
      <router-link :to="{ name: 'AdminDashboard' }" class="text">
         {{panel.title}}
      </router-link>
    </v-toolbar>
    <v-list>

      <v-list-tile 
        v-for="menu in panel.menu"
        :key="menu.id"
        @click="changeRoute(menu.route, menu.id)">
        <v-list-tile-action>
          <v-icon>{{menu.icon}}</v-icon>
        </v-list-tile-action>
        <v-list-tile-title :class="[{'active': selectedIndex === menu.id}, 'item-title' ]" >{{menu.name}}</v-list-tile-title>
      </v-list-tile>
      <!--------------------------------->
        <!-- <v-list-tile @click="changeRoute('AdminDashboard', 1)">
          <v-list-tile-action>
            <v-icon>dashboard</v-icon>
          </v-list-tile-action>
          <v-list-tile-title :class="[{'active': selectedIndex === 1}, 'item-title' ]" >Dashboard</v-list-tile-title>
        </v-list-tile>

        <v-list-tile @click="changeRoute('AdminEmployee', 2)">
          <v-list-tile-action>
            <v-icon>fas fa-users</v-icon>
          </v-list-tile-action>
          <v-list-tile-title :class="[{'active': selectedIndex === 2}, 'item-title' ]">Pegawai</v-list-tile-title>
        </v-list-tile>

        <v-list-tile @click="changeRoute('AdminUser', 3)">
          <v-list-tile-action>
            <v-icon>fas fa-user</v-icon>
          </v-list-tile-action>
          <v-list-tile-title :class="[{'active': selectedIndex === 3}, 'item-title' ]">Akun User</v-list-tile-title>
        </v-list-tile>

        <v-list-tile @click="changeRoute('AdminService', 4)">
          <v-list-tile-action>
            <v-icon>fas fa-wrench</v-icon>
          </v-list-tile-action>
          <v-list-tile-title :class="[{'active': selectedIndex === 4}, 'item-title' ]">Jasa Servis</v-list-tile-title>
        </v-list-tile>
        
        <v-list-tile @click="changeRoute('AdminSparepart', 5)">
          <v-list-tile-action>
            <v-icon>fas fa-box-open</v-icon>
          </v-list-tile-action>
          <v-list-tile-title :class="[{'active': selectedIndex === 5}, 'item-title' ]">Sparepart</v-list-tile-title>
        </v-list-tile>

        <v-list-tile @click="changeRoute('AdminSupplier', 6)">
          <v-list-tile-action>
            <v-icon>fas fa-truck</v-icon>
          </v-list-tile-action>
          <v-list-tile-title :class="[{'active': selectedIndex === 6}, 'item-title' ]">Supplier</v-list-tile-title>
        </v-list-tile>

        <v-list-tile @click="changeRoute('AdminSales', 7)">
          <v-list-tile-action>
            <v-icon>fas fa-user-tie</v-icon>
          </v-list-tile-action>
          <v-list-tile-title :class="[{'active': selectedIndex === 7}, 'item-title' ]">Sales</v-list-tile-title>
        </v-list-tile> -->

        <!-- <v-list-group
            prepend-icon="pageview">
            <v-list-tile slot="activator">
              <v-list-tile-title class="item-title">Widgets</v-list-tile-title>
            </v-list-tile>
            <v-list-tile @click="changeRoute('Social', 4)">
              <v-list-tile-action>
                <v-icon>group</v-icon>
              </v-list-tile-action>
              <v-list-tile-title :class="[{'active': selectedIndex === 4}, 'item-title' ]">Social</v-list-tile-title>
            </v-list-tile>
            <v-list-tile @click="changeRoute('Chart', 5)">
              <v-list-tile-action>
                <v-icon>bar_chart</v-icon>
              </v-list-tile-action>
              <v-list-tile-title :class="[{'active': selectedIndex === 5}, 'item-title' ]">Charts</v-list-tile-title>
            </v-list-tile>
            <v-list-tile @click="changeRoute('Media', 6)">
              <v-list-tile-action>
                <v-icon>perm_media</v-icon>
              </v-list-tile-action>
              <v-list-tile-title :class="[{'active': selectedIndex === 6}, 'item-title' ]">Media</v-list-tile-title>
            </v-list-tile>
        </v-list-group>

        <v-list-group
            prepend-icon="select_all">
            <v-list-tile slot="activator">
              <v-list-tile-title class="item-title">Overlays</v-list-tile-title>
            </v-list-tile>
            <v-list-tile @click="changeRoute('Snackbar', 7)">
              <v-list-tile-action>
                <v-icon>event_note</v-icon>
              </v-list-tile-action>
              <v-list-tile-title :class="[{'active': selectedIndex === 7}, 'item-title' ]">Snackbar</v-list-tile-title>
            </v-list-tile>
        </v-list-group>

        <v-list-group
            prepend-icon="fingerprint">
            <v-list-tile slot="activator">
              <v-list-tile-title class="item-title">Authorization</v-list-tile-title>
            </v-list-tile>

            <v-list-tile @click="$router.push({ name: 'Error', params: { errorCode: '403' } })">
              <v-list-tile-action>
                <v-icon>cancel</v-icon>
              </v-list-tile-action>
              <v-list-tile-title class="item-title">403</v-list-tile-title>
            </v-list-tile>

            <v-list-tile @click="$router.push({ name: 'Error', params: { errorCode: '404' } })">
              <v-list-tile-action>
                <v-icon>cancel</v-icon>
              </v-list-tile-action>
              <v-list-tile-title class="item-title">404</v-list-tile-title>
            </v-list-tile>

            <v-list-tile @click="$router.push({ name: 'Error', params: { errorCode: '500' } })">
              <v-list-tile-action>
                <v-icon>cancel</v-icon>
              </v-list-tile-action>
              <v-list-tile-title class="item-title">500</v-list-tile-title>
            </v-list-tile>

            <v-list-tile @click="$router.push({ name: 'Login' })">
              <v-list-tile-action>
                <v-icon>cancel</v-icon>
              </v-list-tile-action>
              <v-list-tile-title class="item-title">Login</v-list-tile-title>
            </v-list-tile>
        </v-list-group> -->

        <!-- <v-list-group
          prepend-icon="account_circle">
          <v-list-tile slot="activator">
            <v-list-tile-title class="item-title">Users</v-list-tile-title>
          </v-list-tile>
              <v-list-tile
                v-for="(admin, i) in admins"
                :key="i"
                @click="">
                <v-list-tile-action>
                  <v-icon v-text="admin[1]"></v-icon>
                </v-list-tile-action>
                <v-list-tile-title v-text="admin[0]"></v-list-tile-title>
              </v-list-tile>
        </v-list-group> -->

    </v-list>
  </v-navigation-drawer>

  <!-- content -->
  <v-content>
    <router-view/>
  </v-content>
  <!-- Alert -->
  <v-snackbar right bottom :color="alert.type"  value="true" v-if="alert.type">
    <v-icon>{{alert.icon}}</v-icon>{{alert.message}}
  </v-snackbar>
</div>
</v-app>
</template>


<script>
import Controller from '../httpController'
import { mapGetters } from 'vuex'
import Auth from '../service/Auth'
import { required, minLength, numeric,sameAs } from 'vuelidate/lib/validators'

export default {
  validations: {
      password: { required, minLength: minLength(8)},
      passwordConfirm: { required, minLength: minLength(8), sameAsPassword: sameAs('password')},
  },
  
  props: {
    toggle: {
        type: Boolean,
        required: false,
        default: true
    }
  },
  created(){
    // console.log('Created '+this.role)
  },
  beforeMount(){
    // console.log('Before Mounted '+this.role)
  },
  mounted(){
    // console.log('Mounted '+this.role)
  },
  watch: {
    dialogSettings (val) {
      val || this.close()
    },
  },
  computed: {
      ...mapGetters({
        id: 'LoggedUser/id',
        name: 'LoggedUser/name',
        username: 'LoggedUser/username',
        role: 'LoggedUser/role'
      }),
       passwordErrors () {
        const errors = []
        if (!this.$v.password.$dirty) return errors
        !this.$v.password.minLength && errors.push('Minimal 8 karakter') 
        !this.$v.password.required && errors.push('Password diperlukan')
        return errors
      },
      confirmpasswordErrors () {
        const errors = []
        if (!this.$v.passwordConfirm.$dirty) return errors 
        !this.$v.passwordConfirm.required && errors.push('Konfirmasi diperlukan')
        !this.$v.passwordConfirm.sameAsPassword && errors.push('Password harus sama')
        return errors
      },
      isLoginPage() {
        return this.$route.meta.page === 'login'
      },

      panel () {
        if(this.role!=null){
          // console.log('Masuk Pak eko '+this.role )
          switch (this.role) {
            case 'Admin': 
              return {
                title:'SIBENTO Admin Panel',
                menu:[
                  { id: 1, route: 'AdminDashboard', icon: 'dashboard', text: 'Dashboard', name: 'Dashboard'},
                  { id: 2, route: 'AdminEmployee', icon: 'fas fa-user-friends', text: 'Pegawai', name: 'Pegawai'},
                  { id: 3, route: 'AdminUser', icon: 'fas fa-user', text: 'Akun User', name: 'Akun User'},
                  { id: 4, route: 'AdminService', icon: 'fas fa-wrench', text: 'Jasa Service', name: 'Jasa Service'},
                  { id: 5, route: 'AdminSparepart', icon: 'fas fa-box-open', text: 'Sparepart', name: 'Sparepart'},
                  { id: 6, route: 'AdminSupplier', icon: 'fas fa-truck', text: 'Supplier', name: 'Supplier'},
                  { id: 7, route: 'AdminSales', icon: 'fas fa-user-tie', text: 'Sales', name: 'Sales'},
                  { id: 8, route: 'AdminCustomer', icon: 'fas fa-users', text: 'Pelanggan', name: 'Pelanggan'},
                ]
              }
              break

            case 'Customer Service': 
              return {
                title:'SIBENTO CS Panel',
                menu:[
                  { id: 1, route: 'AdminDashboard', icon: 'dashboard', text: 'Dashboard', name: 'Dashboard'},
                ]
              }
              break

            case 'Cashier': 
              return {
                title:'SIBENTO Chasier Panel',
                menu:[
                  { id: 1, route: 'AdminDashboard', icon: 'dashboard', text: 'Dashboard', name: 'Dashboard'},               
                ]
              }
              break
          }
        }
      },
      selectedMenu(){
        return this.selectedIndex= this.$route.meta.menu
      }

  },  
  data() {
    return {
      rating: null,
      dialog: false,
      dialogSettings: false,
      switchEmailNotification: true,
      showPassword: null,
      showPasswordConfirm: null,
      userEmail: null,
      password: null,
      passwordConfirm: null,
      error: false,
      showResult: false,
      result: '',
      menu:'',
      items: [
        {
          icon: 'account_circle',
          href: '#',
          title: 'Profile',
          click: (e) => {

          }
        },
        {
          icon: 'settings',
          href: '#',
          title: 'Settings',
          click: () => {
            const vm = this;

            vm.dialogSettings = true;
          }
        },
        {
          icon: 'exit_to_app',
          href: '#',
          title: 'Log Out',
          click: () => {
            // const vm = this;

            // vm.$router.push({ name: 'Login' });
            this.logoutHandler();
          }
        },
        
      ],
      notifications:[
        {
          title: 'New mail from Adam Joe',
          color: 'light-blue',
          icon: 'email',
          actionAt: '12 min ago',
          isActive: true,
          onClick: () => {
            const vm = this;

            vm.$router.push({ name: 'Mailbox' });
          }
        },
        {
          title: 'Scheculed meeting',
          color: 'red',
          icon: 'calendar_today',
          actionAt: '46 min ago',
          isActive: true,
          onClick: () => {
            const vm = this;

            vm.$router.push({ name: 'Calendar' });
          }
        },
        {
          title: 'New mail from Github',
          color: 'light-blue',
          icon: 'email',
          isActive: true,
          timeLabel: '2 hour ago',
          onClick: () => {
            const vm = this;

            vm.$router.push({ name: 'Mailbox' });
          }
        }
      ],
      selectedIndex: this.$route.meta.menu,
      // admins: [
      //   ['Management', 'people_outline'],
      //   ['Settings', 'settings']
      // ],
      drawer: null,
      alert:{
        type: null,
        message: null,
        icon: null,
      }
    }
  },

  methods: {
    toggleNavigationBar() {
      const vm = this;

      vm.$emit('toggleNavigationBar');
    },
    async savepassword(){
      try {
        const data ={
          newPassword: this.password,

        }
        console.log
        await Controller.changepassword(data, this.id)
        this.close()
        this.showAlert('success','Berhasil Ubah Password')
      } catch (err) {
        console.log(err)
        this.showAlert('error','Gagal Ubah Password')
      }
    },

    setUpSettings() {
      const vm = this;

      if (vm.userEmail === null || vm.password === null || vm.passwordConfirm === null) {

        vm.result = "Email and Password can't be null.";
        vm.showResult = true;

        return;
      }

      if (vm.password !== vm.passwordConfirm) {

        vm.error = true;
        vm.result = "Passwords does not match the confirm password.";
        vm.showResult = true;

        return;
      }

      vm.$root.userEmail = vm.userEmail;
      vm.$root.userPassword = vm.password;

      vm.result = "Email and password changed succesfully.";
      vm.showResult = true;

      vm.dialogSettings = false;
    },
    close () {
      this.dialogSettings = false

      setTimeout(() => {
        this.password=''
        this.passwordConfirm=''
        this.$v.$reset()
      }, 300)
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
        
      },
    logoutHandler() {
        Auth.logout()
        this.$router.push({ name: 'Login' })
    },
    changeRoute(routeName, selectedIndex) {
      const vm = this;

      vm.selectedIndex = selectedIndex;

      return vm.$router.push({ name: routeName });
    },
  }
};
</script>
