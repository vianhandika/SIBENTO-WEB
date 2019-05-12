<template>
    <div>
        <v-toolbar flat color="white">

          <v-toolbar-title>MANAJEMEN CABANG</v-toolbar-title>
          <v-divider
              class="mx-2"
              inset
              vertical
          ></v-divider>

          <!-- dialog box add/edit -->
          <v-dialog v-model="dialog" max-width="500px">
              <template v-slot:activator="{ on }">
              <v-btn color="primary" dark class="mb-2" v-on="on">Tambah</v-btn>
              </template>
              <v-card>
              <v-card-title>
                  <span class="headline">{{ formTitle }}</span>
              </v-card-title>

              <v-card-text>
                  <v-container grid-list-md>
                  <v-layout wrap>
                      <v-flex xs12>
                      <v-text-field 
                        v-model="editedItem.name" 
                        label="Nama Cabang"
                        :counter="25"
                        :error-messages="nameErrors"
                        required
                        @input="$v.editedItem.name.$touch()"
                        @blur="$v.editedItem.name.$touch()"
                        prepend-inner-icon="fas fa-building">
                      </v-text-field>
                      </v-flex>
                      <v-flex xs12 sm6 md8>
                      <v-text-field 
                        v-model="editedItem.address" 
                        label="Alamat" 
                        :counter="100"
                        :error-messages="addressErrors"
                        required
                        @input="$v.editedItem.address.$touch()"
                        @blur="$v.editedItem.address.$touch()"
                        prepend-inner-icon="fas fa-map-marker-alt">
                      </v-text-field>
                      </v-flex>
                
                  </v-layout>
                  </v-container>
              </v-card-text>

              <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="blue darken-1" flat @click="close">Batal</v-btn>
                  <v-btn v-if="editedIndex!=-1" color="blue darken-1" flat @click="updatebranch()">Simpan</v-btn>
                  <v-btn v-else color="blue darken-1" :disabled="$v.editedItem.$invalid" flat @click="addbranch()">Tambah</v-btn>
              </v-card-actions>
              
              </v-card>
          </v-dialog>

          <!-- dialog box delete -->
          <v-dialog v-model="delDialog" max-width="500px">
            <v-card>
              <v-card-title>
                <span class="headline">Hapus Cabang</span>
              </v-card-title>
              <v-card-text>
                <h3 class="text-sm-center">Apakah Anda yakin akan menghapus data ini ?</h3>
              </v-card-text>
              <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="blue darken-1" flat @click="deletebranch()">Ya</v-btn>
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
          <VCardText
            v-if="loading || error"
            class="text-xs-center"
          >
            <VAlert
              v-if="error"
              type="error"
              dismissible
              :value="true"
            >
              {{ error.message }}
            </VAlert>
            <VProgressCircular
              :size="45"
              indeterminate
              class="loading-section"
            />
          </VCardText>
        <!-- Tabel -->
        <v-data-table
          :headers="headers"
          :items="initbranch"
          :search="search"
          class="elevation-1">

          <template v-slot:items="props">
              <td>{{ props.index+1 }}</td>
              <td class="text-xs-left">{{ props.item.name }}</td>
              <td class="text-xs-left">{{ props.item.address }}</td>
              <td class="justify-center layout px-0">
              <v-icon
                  small
                  class="mr-2"
                  @click="editItem(props.item)"
              >
                  edit
              </v-icon>
              <v-icon
                  small
                  @click="deleteItem(props.item)"
              >
                  delete
              </v-icon>
              </td>
          </template>
          <v-alert v-slot:no-results :value="true" color="error" icon="warning">
              Pencarian untuk "{{ search }}" tidak ditemukan.
          </v-alert>
          <!-- <template v-slot:no-data>
              <v-btn color="primary" @click="initialize" >Reset</v-btn>
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
  import serviceBranch from '../../service/Branch'
  import { required, maxLength, numeric } from 'vuelidate/lib/validators'


  export default {
    validations: {
       editedItem: {
        name: { required, maxLength: maxLength(25) },
        address: { required, maxLength: maxLength(100) },
       },   
    },

    data: () => ({
      
      dialog: false,
      delDialog: false,
      search: '',
      i:0,
      headers: [
        { text: 'No', align: 'left',sortable: false},
        { text: 'Nama Cabang', align: 'center', value: 'name' },
        { text: 'Alamat', align: 'center', value: 'address' },
        { text: 'Actions', align: 'center',value: 'name', sortable: false }
      ],
      branchData: [],
      editedIndex: -1,
      editedItem: {
        id:'',
        name: '',
        address: '',
      },
      defaultItem: {
        id:'',
        name: '',
        address: '',
      },
      alert:{
        type: null,
        message: null,
        icon: null,
      }
      // elapse: null
    }),

    computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'Tambah Cabang' : 'Edit Cabang'
      },
      ...mapState({
        loading: state => state.Branch.loading,
        error: state => state.Branch.error,
        branches: state => state.Branch.branches,

      }),
      initbranch () {
        this.branchData = this.branches
        return this.branchData
      },

      //VALIDATION ERROR
      nameErrors () {
        const errors = []
        if (!this.$v.editedItem.name.$dirty) return errors
        !this.$v.editedItem.name.maxLength && errors.push('Nama Cabang tidak boleh melebihi 25 karakter')
        !this.$v.editedItem.name.required && errors.push('Nama Cabang diperlukan.')
        return errors
      },
      addressErrors () {
        const errors = []
        if (!this.$v.editedItem.address.$dirty) return errors
        !this.$v.editedItem.address.maxLength && errors.push('Alamat tidak boleh melebihi 100 karakter')        
        !this.$v.editedItem.address.required && errors.push('Alamat diperlukan.')
        return errors
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

    created () {
    },
    mounted(){
      this.getBranch()
    },

    methods: {
      initialize () {

      },
      
      ...mapActions({
          getBranch: 'Branch/get',
          storeBranch: 'Branch/store',
          deleteBranch: 'Branch/delete',
          updateBranch: 'Branch/update',
          
      }),

      async addbranch () {
        try {
            const data ={
              name_branch: this.editedItem.name,
              address_branch : this.editedItem.address,
            }        
            await this.storeBranch(data)
            this.branchData.push(this.editedItem)
            this.getBranch()
            this.close()
            this.showAlert('success','Sukses Menambahkan Cabang')
        } catch (err) {
            console.log(err)
            this.showAlert('error','Gagal Menambahkan Cabang')
        }
            
      },

      async updatebranch () {
        try {
            const data ={
              id: this.branchData[this.editedIndex].id,
              name_branch: this.editedItem.name,
              address_branch : this.editedItem.address,
            }
            console.log(data)
            await this.updateBranch(data)
            Object.assign(this.branchData[this.editedIndex], this.editedItem)
            this.getBranch()
            this.close()
            this.showAlert('success','Sukses Mengubah Cabang')

        } catch (err) {
            console.log(err)
            this.showAlert('error','Gagal Mengubah Cabang')
        }
      },

      async deletebranch () {
         try {
            var id = this.branchData[this.editedIndex].id
            await this.deleteBranch(id)
            this.getBranch()
            this.close()
            this.showAlert('success','Sukses Menghapus Cabang')

          } catch (err) {
              console.log(err)
            this.showAlert('error','Gagal Menghapus Cabang')

          }
      },



      editItem (item) {
        this.editedIndex = this.branchData.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialog = true
      },

      deleteItem (item) {
        this.delDialog = true
        this.editedIndex = this.branchData.indexOf(item)
        
      },

      close () {
        this.dialog = false
        this.delDialog = false
        setTimeout(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
          this.$v.$reset()
        }, 300)
      },

      save () {
        if (this.editedIndex > -1) {
          Object.assign(this.branchData[this.editedIndex], this.editedItem)
        } else {
          this.branchData.push(this.editedItem)
        }
        this.close()
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
