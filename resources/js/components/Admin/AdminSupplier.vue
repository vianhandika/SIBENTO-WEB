<template>
    <div>
        <v-toolbar flat color="white">

          <v-toolbar-title>MANAJEMEN SUPPLIER</v-toolbar-title>
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
                          label="Nama"
                          :counter="25"
                          :error-messages="nameErrors"
                          required
                          @input="$v.editedItem.name.$touch()"
                          @blur="$v.editedItem.name.$touch()"
                          prepend-inner-icon="fa fa-user">
                        </v-text-field>
                      </v-flex>
                      <v-flex xs12 sm6 md8>
                        <v-text-field 
                          v-model="editedItem.phone_number" 
                          label="Nomor Telepon" 
                          :counter="12"
                          :error-messages="phoneErrors"
                          required
                          @input="$v.editedItem.phone_number.$touch()"
                          @blur="$v.editedItem.phone_number.$touch()"
                          prepend-inner-icon="fa fa-phone">
                        </v-text-field>
                      </v-flex>
                      <v-flex xs12>
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
                  <v-btn v-if="editedIndex!=-1" color="blue darken-1" flat @click="updatesupplier">Simpan</v-btn>
                  <v-btn v-else color="blue darken-1" :disabled="$v.editedItem.$invalid" flat @click="addsupplier">Tambah</v-btn>
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
                  <v-btn color="blue darken-1" flat @click="deletesupplier()">Ya</v-btn>
                  <v-btn color="blue darken-1" flat @click="close">Tidak</v-btn>
                  <v-spacer></v-spacer>

                
              </v-card-actions>
            </v-card>
          </v-dialog>

          <!-- dialog box sales -->
           <v-dialog v-model="salesDialog" max-width="500px">
              <v-card>
              <v-card-title>
                  <span class="headline">List Sales</span>
              </v-card-title>

              <v-card-text>
                  <v-container grid-list-md>
                  <v-layout wrap>
                    <v-data-table
                
                    :headers="salesheaders"
                    :items="this.salesSupplier">

                    <template v-slot:items="props">
                        <td>{{ props.item.name_sales }}</td>
                        <td class="text-xs-center">{{ props.item.phone_number_sales }}</td>
                    </template>
                    </v-data-table>                      
                      
                  </v-layout>
                  </v-container>
              </v-card-text>

              <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="blue darken-1" flat @click="close">Keluar</v-btn>
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
          :items="initsupplier"
          :search="search"
          class="elevation-1">

          <template v-slot:items="props">
              <td>{{ props.index+1}}</td>
              <td>{{ props.item.name }}</td>
              <td class="text-xs-center">{{ props.item.phone_number }}</td>
              <td class="text-xs-left">{{ props.item.address }}</td>
              <td class="text-xs-center">
                  <v-btn depressed small color="grey" dark 
                    style="text-transform:none !important;"
                    @click="showSales(props.item)">
                    Lihat Sales
                  </v-btn>
              </td>
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
  import supplierService from '../../service/Supplier'
  import { required, maxLength, numeric } from 'vuelidate/lib/validators'


  export default {
    validations: {
       editedItem: {
        name: { required, maxLength: maxLength(25) },
        phone_number: { required, numeric, maxLength: maxLength(12) },
        address: { required, maxLength: maxLength(100) },
       },   
    },

    data: () => ({
      
      dialog: false,
      delDialog: false,
      salesDialog: false,
      search: '',
      i:0,
      headers: [
        { text: 'No', align: 'left',sortable: false },
        { text: 'Nama Supplier', align: 'left', value: 'name' },
        { text: 'Nomor Telepon', align: 'center', value: 'phone_number', sortable: false },
        { text: 'Alamat', align: 'center', value: 'address', sortable: false },
        { text: 'Sales', align: 'center', sortable: false },
        { text: 'Actions', align: 'center', sortable: false }
      ],
      salesheaders: [
        { text: 'Nama Sales', align: 'left', value: 'name_sales' },
        { text: 'Nomor Telepon', align: 'center', value: 'phone_number_sales', sortable: false },
      ],
      supplierData: [],
      salesSupplier:[],
      editedIndex: -1,
      editedItem: {
        name: '',
        phone_number: '',
        address: '',
      },
      defaultItem: {
        name: '',
        phone_number: '',
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
        return this.editedIndex === -1 ? 'Tambah Supplier' : 'Edit Supplier'
      },
      ...mapState({
        loading: state => state.Supplier.loading,
        error: state => state.Supplier.error,
        suppliers: state => state.Supplier.suppliers,

      }),
      initsupplier () {
        this.supplierData = this.suppliers;
        return this.supplierData
      },
      //VALIDATION ERROR
      nameErrors () {
        const errors = []
        if (!this.$v.editedItem.name.$dirty) return errors
        !this.$v.editedItem.name.maxLength && errors.push('Nama tidak lebih dari 25 karakter.')
        !this.$v.editedItem.name.required && errors.push('Nama diperlukan.')
        return errors
      },
      phoneErrors () {
        const errors = []
        if (!this.$v.editedItem.phone_number.$dirty) return errors
        !this.$v.editedItem.phone_number.maxLength && errors.push('Nomor telepon tidak lebih dari 12 karakter.')
        !this.$v.editedItem.phone_number.numeric && errors.push('Nomor telepon harus numerik.')        
        !this.$v.editedItem.phone_number.required && errors.push('Nomor telepon diperlukan.')
        return errors
      },
      addressErrors () {
        const errors = []
        if (!this.$v.editedItem.address.$dirty) return errors
        !this.$v.editedItem.address.maxLength && errors.push('Alamat tidak lebih dari 100 karakter.')
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
      this.getSupplier()

    },

    methods: {
      initialize () {


      },
      
      ...mapActions({
          getSupplier: 'Supplier/get',
          storeSupplier: 'Supplier/store',
          deleteSupplier: 'Supplier/delete',
          updateSupplier: 'Supplier/update'
          
      }),

      async addsupplier () {
        try {
            const data ={
              name_supplier: this.editedItem.name,
              phone_number_supplier : this.editedItem.phone_number,
              address_supplier : this.editedItem.address,
            }

            await this.storeSupplier(data)
            this.supplierData.push(this.editedItem)
            this.getSupplier()
            this.close()
            this.showAlert('success','Success Add Supplier')
        } catch (err) {
            console.log(err)
            this.showAlert('error','Failed Add Supplier')
        }
            
      },

      async updatesupplier () {
        try {
            const data ={
              id_supplier: this.supplierData[this.editedIndex].id,
              name_supplier: this.editedItem.name,
              phone_number_supplier : this.editedItem.phone_number,
              address_supplier : this.editedItem.address,
            }

            await this.updateSupplier(data)
            Object.assign(this.supplierData[this.editedIndex], this.editedItem)
            this.getSupplier()
            this.close()
            this.showAlert('success','Success Update Supplier')

        } catch (err) {
            console.log(err)
            this.showAlert('error','Failed Update Supplier')
        }
      },

      async deletesupplier () {
         try {
            var id_supplier = this.supplierData[this.editedIndex].id
            await this.deleteSupplier(id_supplier)
            this.getSupplier()
            this.close()
            this.showAlert('success','Success Delete Supplier')

          } catch (err) {
              console.log(err)
            this.showAlert('error','Failed Delete Supplier')

          }
      },

      createUsername(fullname){
        var username = fullname
        
        // username = username.replace(/\s/g,''); //remove space
        username = username.replace(/ .*/,'');
        // console.log(username);
        username = username.toLowerCase(); //to lowercase
        // console.log(username);
        username = username+Math.floor(Math.random()*100)
        console.log(username);

        return username;

      },

      editItem (item) {
        this.editedIndex = this.supplierData.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialog = true
      },

      deleteItem (item) {
        this.delDialog = true
        this.editedIndex = this.supplierData.indexOf(item)
        // this.deletesupplier()
        // confirm('Are you sure you want to delete this item?') && this.supplierData.splice(this.editedIndex, 1)
        // confirm('Are you sure you want to delete this item?') && this.deletesupplier()
        
      },
      showSales(item){
        this.salesDialog=true
        this.editedIndex = this.supplierData.indexOf(item)
        this.salesSupplier = this.supplierData[this.editedIndex].sales
      },
      close () {
        this.dialog = false
        this.delDialog = false
        this.salesDialog= false
        setTimeout(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
        //   this.salesSupplier =null
          this.$v.$reset()
        }, 300)
      },


      save () {
        if (this.editedIndex > -1) {
          Object.assign(this.supplierData[this.editedIndex], this.editedItem)
        } else {
          this.supplierData.push(this.editedItem)
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
