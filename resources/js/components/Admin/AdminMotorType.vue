<template>
    <div>
        <v-toolbar flat color="white">

          <v-toolbar-title>MANAJEMEN MERK MOTOR</v-toolbar-title>
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
                        label="Nama Tipe"
                        :counter="25"
                        :error-messages="nameErrors"
                        required
                        @input="$v.editedItem.name.$touch()"
                        @blur="$v.editedItem.name.$touch()"
                        prepend-inner-icon="fas fa-motorcycle">
                      </v-text-field>
                      </v-flex>
                    
                  </v-layout>
                    <v-layout wrap>
                      <v-flex xs12>
                        <v-select
                          v-model="editedItem.brand"
                          :items="motorbrands"
                          :error-messages="brandErrors"                          
                          item-text="name"
                          item-value="id"
                          label="Merk Motor"
                          required
                          @change="$v.editedItem.brand.$touch()"
                          @blur="$v.editedItem.brand.$touch()"
                          prepend-inner-icon="fas fa-motorcycle">
                        </v-select>
                      </v-flex>
                    
                  </v-layout>

                  </v-container>
              </v-card-text>

              <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="blue darken-1" flat @click="close">Batal</v-btn>
                  <v-btn v-if="editedIndex!=-1" color="blue darken-1" flat @click="updatemotortype()">Simpan</v-btn>
                  <v-btn v-else color="blue darken-1" :disabled="$v.editedItem.$invalid" flat @click="addmotortype()">Tambah</v-btn>
              </v-card-actions>
              
              </v-card>
          </v-dialog>

          <!-- dialog box delete -->
          <v-dialog v-model="delDialog" max-width="500px">
            <v-card>
              <v-card-title>
                <span class="headline">Hapus Type</span>
              </v-card-title>
              <v-card-text>
                <h3 class="text-sm-center">Apakah Anda yakin akan menghapus data ini ?</h3>
              </v-card-text>
              <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="blue darken-1" flat @click="deletemotortype()">Ya</v-btn>
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
          :items="initmotortype"
          :search="search"
          class="elevation-1">

          <template v-slot:items="props">
              <td>{{ props.index+1 }}</td>
              <td class="text-xs-left">{{ props.item.name }}</td>
              <td class="text-xs-left">{{ props.item.brand.name }}</td>
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
  import serviceMotorType from '../../service/MotorType'
  import { required, maxLength, numeric } from 'vuelidate/lib/validators'


  export default {
    validations: {
       editedItem: {
        name: { required, maxLength: maxLength(25) },
        brand: { required},
       },   
    },

    data: () => ({
      
      dialog: false,
      delDialog: false,
      search: '',
      i:0,
      headers: [
        { text: 'No', align: 'left',sortable: false},
        { text: 'Nama Tipe', align: 'center', value: 'name' },
        { text: 'Merk', align: 'center', value: 'name' },
        { text: 'Actions', align: 'center',value: 'name', sortable: false }
      ],
      motortypeheaders: [
        { text: 'Tipe Motor', align: 'left', value: 'name_motorcycle_type' },
      ],
      motortypeData: [],
      typeMotorType:[],
      editedIndex: -1,
      editedItem: {
        id:'',
        name: '',
        brand:'',
      },
      defaultItem: {
        id:'',
        name: '',
        brand:'',
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
        return this.editedIndex === -1 ? 'Tambah Tipe' : 'Edit Tipe'
      },
      ...mapState({
        loading: state => state.MotorType.loading,
        error: state => state.MotorType.error,
        motortypes: state => state.MotorType.motortypes,
        motorbrands: state=> state.MotorBrand.motorbrands,

      }),
      initmotortype () {
        this.motortypeData = this.motortypes
        return this.motortypeData
      },

      //VALIDATION ERROR
      nameErrors () {
        const errors = []
        if (!this.$v.editedItem.name.$dirty) return errors
        !this.$v.editedItem.name.maxLength && errors.push('Nama Tipe tidak boleh melebihi 25 karakter')
        !this.$v.editedItem.name.required && errors.push('Nama Tipe diperlukan.')
        return errors
      },

      brandErrors () {
        const errors = []
        if (!this.$v.editedItem.brand.$dirty) return errors
        !this.$v.editedItem.brand.required && errors.push('Merk diperlukan.')
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
        this.getMotorType()
        this.getMotorBrand()
    },
    mounted(){
      
    },

    methods: {
      initialize () {

      },
      
      ...mapActions({
          getMotorType: 'MotorType/get',
          getMotorBrand: 'MotorBrand/get',
          storeMotorType: 'MotorType/store',
          deleteMotorType: 'MotorType/delete',
          updateMotorType: 'MotorType/update',
          
      }),

      async addmotortype () {
        try {
            const data ={
              name_motorcycle_type: this.editedItem.name,
              id_motorcycle_brand: this.editedItem.brand
            }        
            await this.storeMotorType(data)
            this.motortypeData.push(this.editedItem)
            await this.getMotorType()
            this.close()
            this.showAlert('success','Sukses Menambahkan Tipe')
        } catch (err) {
            console.log(err)
            this.showAlert('error','Gagal Menambahkan Tipe')
        }
            
      },

      async updatemotortype () {
        try {
            const data ={
              id_motorcycle_type: this.motortypeData[this.editedIndex].id,
              name_motorcycle_type: this.editedItem.name,
              id_motorcycle_brand: this.editedItem.brand
            }
            console.log(data)   
            await this.updateMotorType(data)
            Object.assign(this.motortypeData[this.editedIndex], this.editedItem)
            await this.getMotorType()
            this.close()
            this.showAlert('success','Sukses Mengubah Tipe')

        } catch (err) {
            console.log(err)
            this.showAlert('error','Gagal Mengubah Tipe')
        }
      },

      async deletemotortype () {
         try {
            var id = this.motortypeData[this.editedIndex].id
            await this.deleteMotorType(id)
            this.getMotorType()
            this.close()
            this.showAlert('success','Sukses Menghapus Tipe')

          } catch (err) {
              console.log(err)
            this.showAlert('error','Gagal Menghapus Tipe')

          }
      },



      editItem (item) {
        this.editedIndex = this.motortypeData.indexOf(item)

        // this.editedItem = Object.assign({}, item)
        this.editedItem.id = item.id
        this.editedItem.name = item.name
        this.editedItem.brand = item.brand.id
        this.dialog = true
      },

      deleteItem (item) {
        this.delDialog = true
        this.editedIndex = this.motortypeData.indexOf(item)
        
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
          Object.assign(this.motortypeData[this.editedIndex], this.editedItem)
        } else {
          this.motortypeData.push(this.editedItem)
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
