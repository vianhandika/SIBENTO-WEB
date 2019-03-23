<template>
    <div>
        <v-toolbar flat color="white">
          <v-toolbar-title>MANAJEMEN AKUN USER</v-toolbar-title>
          <v-divider
              class="mx-2"
              inset
              vertical
          ></v-divider>

          <!-- dialog box delete -->
          <v-dialog v-model="delDialog" max-width="500px">
            <v-card>
              <v-card-title>
                <span class="headline">Hapus Akun</span>
              </v-card-title>
              <v-card-text>
                <h3 class="text-sm-center">Apakah Anda yakin akan menghapus data ini ?</h3>
              </v-card-text>
              <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="blue darken-1" flat @click="deleteuser()">Ya</v-btn>
                  <v-btn color="blue darken-1" flat @click="close">Tidak</v-btn>
                  <v-spacer></v-spacer>

                
              </v-card-actions>
            </v-card>
          </v-dialog>          

          <!-- Search -->
          <v-spacer></v-spacer>
          <v-flex xs4 sm4 md4>
            <v-text-field 
                v-model="search"
                append-icon="search"
                label="Cari"
                single-line
                hide-details>
            </v-text-field>
          </v-flex>

        </v-toolbar>

        <!-- Tabel -->
        <v-data-table
          :headers="headers"
          :items="initialize"
          :search="search"
          class="elevation-1">
          <template v-slot:items="props">
              <td>{{ props.index+1 }}</td>
              <td>{{ props.item.name }}</td>
              <td class="text-xs-center">{{ props.item.username }}</td>
              <td class="text-xs-left">{{ props.item.role }}</td>
              <td class="text-xs-left">{{ props.item.branch }}</td>
              <td class="justify-center layout px-0">
              <v-icon
                  small
                  @click="deleteItem(props.item)"
              >
                  delete
              </v-icon>
              </td>
          </template>
          <v-alert v-slot:no-results :value="true" color="error" icon="warning">
              Your search for "{{ search }}" found no results.
          </v-alert>
          <!-- <template v-slot:no-data>
              <v-btn color="primary" @click="initialize">Reset</v-btn>
          </template> -->
        </v-data-table>

        <!-- Alert -->
        <v-snackbar right bottom :color="alert.type"  value="true" v-if="alert.type">
          <v-icon>{{alert.icon}}</v-icon>{{alert.message}}
        </v-snackbar>
    </div>
</template>


<script>
  import Controller from '../../httpController'
  import { mapState, mapActions } from 'vuex'
  import userService from '../../service/User'

  export default {
    data: () => ({
      delDialog: false,
      search: '',
      i:0,
      headers: [
        { text: 'No', align: 'left', sortable: false },
        { text: 'Nama Pegawai', align: 'left', value: 'name' },
        { text: 'Username', align: 'center', value: 'username', sortable: false },
        { text: 'Jabatan', align: 'center',value: 'role' },
        { text: 'Cabang', align: 'center',value: 'branch' },
        { text: 'Actions', align: 'center',value: 'name', sortable: false }
      ],
      userData: [],
      userDataFiltered:[],
      editedIndex: -1,
      alert:{
        type: null,
        message: null,
        icon: null,
      }
    }),

    computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'Add Employee' : 'Edit Employee'
      },
      ...mapState({
        users: state => state.User.users,
      }),
      initialize () {
        this.userData = this.users.filter(obj => obj.role != "Admin");
        return this.userData
      },

    },

    watch: {
      dialog (val) {
        val || this.close()
      },
      delDialog (val) {
        val || this.close()
      }
    },

    mounted () {
      // this.loaddata ()
      this.getUser()
      // this.userfiltered()
    
    },

    methods: {
      ...mapActions({
          getUser: 'User/get',
          deleteUser: 'User/delete',
          
      }),
      async loaddata () {
        try {
            const data = (await Controller.getalluser()).data
            this.userData = data.filter(obj => obj.role != "Admin");
        } catch (err) {
            console.log(err)
        }
      },
      async deleteuser(){
        try {
            var id_user = this.userData[this.editedIndex].id
            await this.deleteUser(id_user)
            this.getUser()
            this.close()
            // console.log(id_user)
            // this.loaddata()
            // await Controller.deleteuser(id_user)
        } catch (err) {
            console.log(err)
        }
      },

      userfiltered(){
        // console.log(this.userData)
        this.userDataFiltered = this.userData.filter(item => console.log(item));
        // console.log(this.userDataFiltered);
      },

      deleteItem (item) {
        this.editedIndex = this.userData.indexOf(item)
        this.delDialog =true
        // confirm('Are you sure you want to delete this item?') && this.userData.splice(this.editedIndex, 1)
        // confirm('Are you sure you want to delete this item?') && this.deleteuser()
      },

      close () {
        // this.dialog = false
        this.delDialog = false
        setTimeout(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
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
        
      }
      
    }
  }
</script>
