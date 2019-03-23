<template>
    <div>
        <v-toolbar flat color="white">

          <v-toolbar-title>MANAJEMEN JASA SERVICE</v-toolbar-title>
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
                        v-model="editedItem.name_service" 
                        label="Nama Jasa"
                        :counter="25"
                        :error-messages="nameErrors"
                        required
                        @input="$v.editedItem.name_service.$touch()"
                        @blur="$v.editedItem.name_service.$touch()"
                        prepend-inner-icon="fas fa-wrench">
                      </v-text-field>
                      </v-flex>
                      <v-flex xs12 sm6 md8>
                      <v-text-field 
                        v-model="editedItem.price_service" 
                        label="Harga Jasa" 
                        :counter="12"
                        :error-messages="priceErrors"
                        required
                        @input="$v.editedItem.price_service.$touch()"
                        @blur="$v.editedItem.price_service.$touch()"
                        prepend-inner-icon="fas fa-coins">
                      </v-text-field>
                      </v-flex>
                
                  </v-layout>
                  </v-container>
              </v-card-text>

              <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="blue darken-1" flat @click="close">Batal</v-btn>
                  <v-btn v-if="editedIndex!=-1" color="blue darken-1" flat @click="updateservice()">Simpan</v-btn>
                  <v-btn v-else color="blue darken-1" :disabled="$v.editedItem.$invalid" flat @click="addservice()">Tambah</v-btn>
              </v-card-actions>
              
              </v-card>
          </v-dialog>

          <!-- dialog box delete -->
          <v-dialog v-model="delDialog" max-width="500px">
            <v-card>
              <v-card-title>
                <span class="headline">Hapus Pegawai</span>
              </v-card-title>
              <v-card-text>
                <h3 class="text-sm-center">Apakah Anda yakin akan menghapus data ini ?</h3>
              </v-card-text>
              <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="blue darken-1" flat @click="deleteservice()">Ya</v-btn>
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
          :items="initservice"
          :search="search"
          class="elevation-1">

          <template v-slot:items="props">
              <td>{{ props.index+1 }}</td>
              <td class="text-xs-left">{{ props.item.name_service }}</td>
              <td class="text-xs-left">Rp. {{ props.item.price_service }}</td>
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
  import serviceService from '../../service/Service'
  import { required, maxLength, numeric } from 'vuelidate/lib/validators'


  export default {
    validations: {
       editedItem: {
        name_service: { required, maxLength: maxLength(50) },
        price_service: { required, numeric },
       },   
    },

    data: () => ({
      
      dialog: false,
      delDialog: false,
      search: '',
      i:0,
      headers: [
        { text: 'No', align: 'left',sortable: false},
        { text: 'Nama Jasa', align: 'center', value: 'name_service' },
        { text: 'Harga', align: 'center', value: 'price_service' },
        { text: 'Actions', align: 'center',value: 'name', sortable: false }
      ],
      serviceData: [],
      editedIndex: -1,
      editedItem: {
        id_service:'',
        name_service: '',
        price_service: '',
      },
      defaultItem: {
        id_service:'',
        name_service: '',
        price_service: '',
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
        return this.editedIndex === -1 ? 'Tambah Service' : 'Edit Service'
      },
      ...mapState({
        loading: state => state.Service.loading,
        error: state => state.Service.error,
        services: state => state.Service.services,

      }),
      initservice () {
        this.serviceData = this.services
        return this.serviceData
      },

      //VALIDATION ERROR
      nameErrors () {
        const errors = []
        if (!this.$v.editedItem.name_service.$dirty) return errors
        !this.$v.editedItem.name_service.maxLength && errors.push('Nama jasa tidak boleh melebihi 25 karakter')
        !this.$v.editedItem.name_service.required && errors.push('Nama jasa diperlukan.')
        return errors
      },
      priceErrors () {
        const errors = []
        if (!this.$v.editedItem.price_service.$dirty) return errors
        !this.$v.editedItem.price_service.numeric && errors.push('Harga jasa harus numerik')        
        !this.$v.editedItem.price_service.required && errors.push('Harga jasa diperlukan.')
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
      this.getService()
    },

    methods: {
      initialize () {

      },
      
      ...mapActions({
          getService: 'Service/get',
          storeService: 'Service/store',
          deleteService: 'Service/delete',
          updateService: 'Service/update',
          
      }),

      async addservice () {
        try {
            const data ={
              name_service: this.editedItem.name_service,
              price_service : this.editedItem.price_service,
            }        
            this.storeService(data)
            this.serviceData.push(this.editedItem)
            this.getService()
            this.close()
            this.showAlert('success','Success Add Service')
        } catch (err) {
            console.log(err)
            this.showAlert('error','Failed Add Service')
        }
            
      },

      async updateservice () {
        try {
            const data ={
              id_service: this.serviceData[this.editedIndex].id_service,
              name_service: this.editedItem.name_service,
              price_service : this.editedItem.price_service,
            }
            console.log(data)
            // const response = await Controller.updateService(this.payload,id_service)
            this.updateService(data)
            Object.assign(this.serviceData[this.editedIndex], this.editedItem)
            this.getService()
            this.close()
            this.showAlert('success','Success Update Service')

        } catch (err) {
            console.log(err)
            this.showAlert('error','Failed Update Service')
        }
      },

      async deleteservice () {
         try {
            var id_service = this.serviceData[this.editedIndex].id_service
            await this.deleteService(id_service)
            this.getService()
            this.close()
            this.showAlert('success','Success Delete Service')

          } catch (err) {
              console.log(err)
            this.showAlert('error','Failed Delete Service')

          }
      },



      editItem (item) {
        this.editedIndex = this.serviceData.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialog = true
      },

      deleteItem (item) {
        this.delDialog = true
        this.editedIndex = this.serviceData.indexOf(item)
        // this.deleteService()
        // confirm('Are you sure you want to delete this item?') && this.serviceData.splice(this.editedIndex, 1)
        // confirm('Are you sure you want to delete this item?') && this.deleteService()
        
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
          Object.assign(this.serviceData[this.editedIndex], this.editedItem)
        } else {
          this.serviceData.push(this.editedItem)
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
