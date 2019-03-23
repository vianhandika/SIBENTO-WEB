<template>
    <div>
        <v-toolbar flat color="white">

          <v-toolbar-title>MANAJEMEN SALES</v-toolbar-title>
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
                        <v-select
                          v-model="editedItem.supplier"
                          :items="initsupplier"
                          :error-messages="supplierErrors"                          
                          item-text="name"
                          item-value="name"
                          label="Perusahaan"

                          required
                          @change="$v.editedItem.supplier.$touch()"
                          @blur="$v.editedItem.supplier.$touch()"
                          prepend-inner-icon="fas fa-truck">
                        </v-select>
                      </v-flex>
                      
                  </v-layout>
                  </v-container>
              </v-card-text>

              <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="blue darken-1" flat @click="close">Batal</v-btn>
                  <v-btn v-if="editedIndex!=-1" color="blue darken-1" flat @click="updatesales">Simpan</v-btn>
                  <v-btn v-else color="blue darken-1" :disabled="$v.editedItem.$invalid" flat @click="addsales">Tambah</v-btn>
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
                  <v-btn color="blue darken-1" flat @click="deletesales()">Ya</v-btn>
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
          :items="initsales"
          :search="search"
          class="elevation-1">

          <template v-slot:items="props">
              <td>{{ props.index+1}}</td>
              <td>{{ props.item.name }}</td>
              <td class="text-xs-center">{{ props.item.phone_number }}</td>
              <td class="text-xs-center">{{ props.item.supplier.name }}</td>
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
  import salesService from '../../service/Sales'
  import supplierService from '../../service/Supplier'
  import { required, maxLength, numeric } from 'vuelidate/lib/validators'


  export default {
    validations: {
       editedItem: {
        name: { required, maxLength: maxLength(25) },
        phone_number: { required, numeric, maxLength: maxLength(12) },
        supplier: { required},
       },   
    },

    data: () => ({
      
      dialog: false,
      delDialog: false,
      search: '',
      i:0,
      headers: [
        { text: 'No', align: 'left',sortable: false },
        { text: 'Nama Sales', align: 'left', value: 'name' },
        { text: 'Nomor Telepon', align: 'center', value: 'phone_number', sortable: false },
        { text: 'Perusahaan', align: 'center', value: 'supplier.name', sortable: false },
        { text: 'Actions', align: 'center', sortable: false }
      ],
      salesData: [],
      dropdown_supplier:[],
      editedIndex: -1,
      editedItem: {
        name: '',
        phone_number: '',
        address: '',
        supplier:'',
      },
      defaultItem: {
        name: '',
        phone_number: '',
        address: '',
        supplier:'',
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
        return this.editedIndex === -1 ? 'Tambah Sales' : 'Edit Sales'
      },
      ...mapState({
        loading: state => state.Sales.loading,
        error: state => state.Sales.error,
        manySales: state => state.Sales.manySales,
        suppliers: state => state.Supplier.suppliers,

      }),
      initsales () {
        this.salesData = this.manySales;
        return this.salesData
      },
      initsupplier(){
          this.dropdown_supplier = this.suppliers
          return this.dropdown_supplier
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
      supplierErrors () {
        const errors = []
        if (!this.$v.editedItem.supplier.$dirty) return errors
        !this.$v.editedItem.supplier.required && errors.push('Perusahaan diperlukan.')
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
      this.getSales()
      this.getSupplier()

    },

    methods: {
      initialize () {


      },
      
      ...mapActions({
          getSales: 'Sales/get',
          getSupplier: 'Supplier/get',
          storeSales: 'Sales/store',
          deleteSales: 'Sales/delete',
          updateSales: 'Sales/update',

          
      }),

      async addsales () {
        try {
            const data ={
              name_sales: this.editedItem.name,
              phone_number_sales : this.editedItem.phone_number,
              address_sales : this.editedItem.address,
              id_supplier : (this.dropdown_supplier.find(obj => obj.name == this.editedItem.supplier)).id
            }

            await this.storeSales(data)
            this.salesData.push(this.editedItem)
            this.getSales()
            this.close()
            this.showAlert('success','Success Add Sales')
        } catch (err) {
            console.log(err)
            this.showAlert('error','Failed Add Sales')
        }
            
      },

      async updatesales () {
        try {
            const data ={
              id_sales: (this.salesData[this.editedIndex]).id,
              name_sales: this.editedItem.name,
              phone_number_sales : this.editedItem.phone_number,
              id_supplier : (this.dropdown_supplier.find(obj => obj.name == this.editedItem.supplier)).id              
            }
            console.log(data)
            await this.updateSales(data)
            Object.assign(this.salesData[this.editedIndex], this.editedItem)
            this.getSales()
            this.close()
            this.showAlert('success','Success Update Sales')

        } catch (err) {
            console.log(err)
            this.showAlert('error','Failed Update Sales')
        }
      },

      async deletesales () {
         try {
            var id_sales = (this.salesData[this.editedIndex]).id
            await this.deleteSales(id_sales)
            this.getSales()
            this.close()
            this.showAlert('success','Success Delete Sales')

          } catch (err) {
              console.log(err)
            this.showAlert('error','Failed Delete Sales')

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
        this.editedIndex = this.salesData.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.editedItem.supplier = item.supplier.name
        this.dialog = true
      },

      deleteItem (item) {
        this.delDialog = true
        this.editedIndex = this.salesData.indexOf(item)
        // this.deletesales()
        // confirm('Are you sure you want to delete this item?') && this.salesData.splice(this.editedIndex, 1)
        // confirm('Are you sure you want to delete this item?') && this.deletesales()
        
      },

      close () {
        this.dialog = false
        this.delDialog = false
        setTimeout(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
        //   this.salesSales =null
          this.$v.$reset()
        }, 300)
      },


      save () {
        if (this.editedIndex > -1) {
          Object.assign(this.salesData[this.editedIndex], this.editedItem)
        } else {
          this.salesData.push(this.editedItem)
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
