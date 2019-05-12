<template>
    <div>
        <v-toolbar flat color="white">

          <v-toolbar-title>MANAJEMEN PELANGGAN</v-toolbar-title>
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
                  <v-btn v-if="editedIndex!=-1" color="blue darken-1" flat @click="updatecustomer">Simpan</v-btn>
                  <v-btn v-else color="blue darken-1" :disabled="$v.editedItem.$invalid" flat @click="addcustomer">Tambah</v-btn>
              </v-card-actions>
              
              </v-card>
          </v-dialog>

          <!-- dialog box delete -->
          <v-dialog v-model="delDialog" max-width="500px">
            <v-card>
              <v-card-title>
                <span class="headline">Hapus Pelanggan</span>
              </v-card-title>
              <v-card-text>
                <h3 class="text-sm-center">Apakah Anda yakin akan menghapus data ini ?</h3>
              </v-card-text>
              <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="blue darken-1" flat @click="deletecustomer()">Ya</v-btn>
                  <v-btn color="blue darken-1" flat @click="close">Tidak</v-btn>
                  <v-spacer></v-spacer>

                
              </v-card-actions>
            </v-card>
          </v-dialog>

        <!-- dialog box motor -->
        <v-dialog v-model="motorDialog" max-width="700px" width="700px">
            <v-card>
            <v-card-title>
                <span class="headline">List Motor</span>
            </v-card-title>

            <v-card-text>
                <!-- <v-container grid-list-md> -->
                <!-- <v-layout wrap> -->
                <v-data-table
                  :headers="motorheaders"
                  :items="initmotorcustomer">

                  <template v-slot:items="props">
                      <td v-if="selectedMotor.id != props.item.id  || addmotor || props.item.id==''">{{ props.item.plate }}</td>
                      <td v-else> 
                        <v-text-field
                          v-model="editedMotor.plate"
                          label="Nomor Plat"
                          single-line
                          counter
                          :error-messages="plateErrors"
                          @input="$v.editedMotor.plate.$touch()"
                          @blur="$v.editedMotor.plate.$touch()"
                          required
                        ></v-text-field>
                      </td>   
                      <td class="text-xs-center" v-if="selectedMotor.id != props.item.id || addmotor">{{ props.item.brand }}</td>
                        <td v-else> 
                          <v-select
                            v-model="editedMotor.brand"
                            :items="dropdown_brand"             
                            item-text="name"
                            item-value="name"
                            label="Brand"
                            :error-messages="brandErrors"
                            @change="$v.editedMotor.brand.$touch()"
                            @blur="$v.editedMotor.brand.$touch()"
                            required>
                          </v-select>
                        </td>          
                      <td class="text-xs-center"  v-if="selectedMotor.id != props.item.id || addmotor">{{ props.item.type }}</td>
                      <td v-else>
                        <v-select
                            v-model="editedMotor.type"
                            :items="typefilter"               
                            item-text="name"
                            item-value="name"
                            label="Tipe"
                            :error-messages="typeErrors"
                            @change="$v.editedMotor.type.$touch()"
                            @blur="$v.editedMotor.type.$touch()"
                            required>
                        </v-select> 
                      </td> 
                      <td class="justify-center layout px-0">
                        <v-icon v-if="selectedMotor.id != props.item.id  || addmotor"
                            small
                            
                            class="mr-2"
                            @click="motorEdit(props.item)"
                        >
                            edit
                        </v-icon>
                        <v-icon v-else
                            small
                            class="mr-2"
                            @click="updatemotorcycle()"
                        >
                            done
                        </v-icon>
                        <v-icon v-if="selectedMotor.id != props.item.id  || addmotor"
                            small
                            
                            @click="motorDelete(props.item)"
                        >
                            delete
                        </v-icon>
                          <v-icon v-else
                            small
                            class="mr-2"
                            @click="motorEditClose()"
                            
                        >
                            close
                        </v-icon>
                      </td>
                  </template>
                  <template v-slot:footer>
                    <td :colspan="motorheaders[0].length">
                      <v-text-field v-if="addmotor"
                        v-model="editedMotor.plate"
                        label="Nomor Plat"
                        single-line
                        counter
                        :error-messages="plateErrors"
                        @input="$v.editedMotor.plate.$touch()"
                        @blur="$v.editedMotor.plate.$touch()"
                        required
                        
                      ></v-text-field>
                    </td>
                    <td :colspan="motorheaders[1].length"> 
                       <v-select v-if="addmotor"
                          v-model="editedMotor.brand"
                          :items="dropdown_brand"
                                                  
                          item-text="name"
                          item-value="name"
                          label="Brand"
                          :error-messages="brandErrors"
                          @change="$v.editedMotor.brand.$touch()"
                          @blur="$v.editedMotor.brand.$touch()"
                          required>
                        </v-select>
                    </td>
                    <td :colspan="motorheaders[2].length"> 
                       <v-select v-if="addmotor"
                            v-model="editedMotor.type"
                            :items="typefilter"
                                                   
                            item-text="name"
                            item-value="name"
                            label="Tipe"
                            :error-messages="typeErrors"
                            @change="$v.editedMotor.type.$touch()"
                            @blur="$v.editedMotor.type.$touch()"
                            required>
                        </v-select> 
                    </td >
                     <td :colspan="motorheaders[3].length" class="justify-center layout px-0">
                        <v-icon v-if="!addmotor"
                            small
                            class="mr-2"
                            @click="motorAdd()"
                        >
                            add
                        </v-icon>
                        <v-icon v-if="addmotor"
                            small
                            class="mr-2"
                            @click ="addmotorcycle()"
                            :disabled="$v.editedMotor.$invalid"
                        >
                            done
                        </v-icon>
                        <v-icon v-if="addmotor"
                            small
                            class="mr-2"
                            @click="motorAddClose()"
                        >
                            close
                        </v-icon>
                      </td>       
                  </template>
                </v-data-table>                      
                    
                <!-- </v-layout> -->
                <!-- </v-container> -->
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
          v-if="initcustomer"
          :headers="headers"
          :items="initcustomer"
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
                    @click="showMotor(props.item)">
                    Lihat Motor
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
  import customerService from '../../service/Customer'
  import motorService from '../../service/MotorCustomer'
  import { required, maxLength, numeric } from 'vuelidate/lib/validators'


  export default {
    validations: {
       editedItem: {
        name: { required, maxLength: maxLength(25) },
        phone_number: { required, numeric, maxLength: maxLength(12) },
        address: { required, maxLength: maxLength(100) },
       }, 
       editedMotor:{
        plate: { required, maxLength: maxLength(12) },
        brand: { required },
        type: { required },
       }  
    },

    data: () => ({
      
      dialog: false,
      delDialog: false,
      motorDialog:false,
      search: '',
      i:0,
      headers: [
        { text: 'No', align: 'left',sortable: false },
        { text: 'Nama Pelanggan', align: 'left', value: 'name' },
        { text: 'Nomor Telepon', align: 'center', value: 'phone_number', sortable: false },
        { text: 'Alamat', align: 'center', value: 'address', sortable: false },
        { text: 'Motor', align: 'center',sortable: false },
        { text: 'Actions', align: 'center', sortable: false }
      ],
      motorheaders: [
        { text: 'Nomor Plat', align: 'left', value: 'plate' },
        { text: 'Brand', align: 'center', value: 'brand', sortable: false },
        { text: 'Tipe', align: 'center', value: 'tipe', sortable: false },
        { text: 'Actions', align: 'center', sortable: false },


      ],
      customerData: [],
      motorData: [],
      motorCustomer:[],
      addmotor:false,
      dropdown_brand: [],
      selectedMotor:{
        id:'',
        plate: '',
        brand:'',
        type: '',
      },
      dropdown_type: [],
      editedIndex: -1,
      editedMotor:{
        id:'',
        plate: '',
        brand:'',
        type: '',
      },
      addedMotor:{
        id:'',
        plate: '',
        brand:'',
        type: '',
      },
      defaultdMotor:{
        id:'',
        plate: '',
        brand:'',
        type: '',
      },
      selectedCustomer: {
        name: '',
        phone_number: '',
        address: '',
      },
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
        return this.editedIndex === -1 ? 'Tambah Pelanggan' : 'Edit Pelanggan'
      },
      ...mapState({
        loading: state => state.Customer.loading,
        error: state => state.Customer.error,
        customers: state => state.Customer.customers,
        motorcustomers: state => state.MotorCustomer.motorcustomers,

      }),
      typefilter(){
          // console.log(this.editedMotor.brand)

          let type = this.dropdown_type.filter( obj => obj.brand.name === this.editedMotor.brand)
            
          return type
      },
      initcustomer () {
        this.customerData = this.customers;
        return this.customerData
      },
      initmotorcustomer(){
        this.motorCustomer = this.motorcustomers.filter(obj=>obj.customer.id == this.selectedCustomer.id);
        return this.motorCustomer
      },
      //VALIDATION ERROR
      nameErrors () {
        const errors = []
        if (!this.$v.editedItem.name.$dirty) return errors
        !this.$v.editedItem.name.maxLength && errors.push('Name tidak lebih dari 25 karakter.')
        !this.$v.editedItem.name.required && errors.push('Name diperlukan.')
        return errors
      },
      phoneErrors () {
        const errors = []
        if (!this.$v.editedItem.phone_number.$dirty) return errors
        !this.$v.editedItem.phone_number.maxLength && errors.push('Nomor Telepon tidak lebih dari 12 karakter.')
        !this.$v.editedItem.phone_number.numeric && errors.push('Nomor Telepo harus numerik.')        
        !this.$v.editedItem.phone_number.required && errors.push('Nomor Telepon diperlukan.')
        return errors
      },
      addressErrors () {
        const errors = []
        if (!this.$v.editedItem.address.$dirty) return errors
        !this.$v.editedItem.address.maxLength && errors.push('Alamat tidak lebih dari 100 karakter.')
        !this.$v.editedItem.address.required && errors.push('Alamat diperlukan.')
        return errors
      },
      plateErrors () {
        const errors = []
        if (!this.$v.editedMotor.plate.$dirty) return errors
        !this.$v.editedMotor.plate.maxLength && errors.push('Plat tidak lebih dari 12 karakter.')
        !this.$v.editedMotor.plate.required && errors.push('Plat diperlukan.')
        return errors
      },
      brandErrors () {
        const errors = []
        if (!this.$v.editedMotor.brand.$dirty) return errors
        !this.$v.editedMotor.brand.required && errors.push('Brand diperlukan.')
        return errors
      },
      typeErrors () {
        const errors = []
        if (!this.$v.editedMotor.type.$dirty) return errors
        !this.$v.editedMotor.type.required && errors.push('Type diperlukan.')
        return errors
      },

    },

    watch: {
      dialog (val) {
        val || this.close()
      },
      delDialog (val) {
        val || this.close()
      },
      motorDialog (val) {
        val || this.close()
      }            
      
    },

    created () {
      // this.loaddata ()
      // this.showAlert('error','Failed Update Customer');
      //  console.log(this.dropdown_role);
      // this.topayload()
    },
    mounted(){
      this.getCustomer()
      this.getMotorCustomer()
      this.getMotorBrand()
      this.getMotorType()
      // this.initialize()
    },

    methods: {
      initialize () {

      },
      async getMotorType(){
        try {
            this.dropdown_type = (await Controller.getallmotortype())
          } catch (err) {
              console.log(err)
          }
      },
      async getMotorBrand(){
        try {
            this.dropdown_brand= (await Controller.getallmotorbrand())
          } catch (err) {
              console.log(err)
          }
      },
      
      ...mapActions({
          getCustomer: 'Customer/get',
          getMotorCustomer: 'MotorCustomer/get',
          storeCustomer: 'Customer/store',
          storeMotorcycle :'MotorCustomer/store',
          deleteCustomer: 'Customer/delete',
          deleteMotorcycle :'MotorCustomer/delete',
          updateCustomer: 'Customer/update',
          updateMotorcycle :'MotorCustomer/update',
  
      }),
      filtertype(brand){
        this.dropdown_type  = this.dropdown_type.filter( obj => obj.brand.name === this.editedMotor.brand)
        return this.dropdown_type
      },
      async addcustomer () {
        try {
            const data ={
              name_customer: this.editedItem.name,
              address_customer : this.editedItem.phone_number,
              phone_number_customer : this.editedItem.address,
            }
            console.log(data)
            await this.storeCustomer(data)
            this.customerData.push(this.editedItem)
            this.getCustomer()
            this.close()
            this.showAlert('success','Success Add Customer')
        } catch (err) {
            console.log(err)
            this.showAlert('error','Failed Add Customer')
        }
            
      },
      async addmotorcycle() {
        try {
          // console.log(this.editedMotor)
            const data ={
              plate_number: this.editedMotor.plate,
              id_motorcycle_type : this.dropdown_type.find(obj=>obj.name == this.editedMotor.type).id,
              id_customer : this.selectedCustomer.id,
            }
            console.log(data)
            await this.storeMotorcycle(data)
            this.getCustomer()
            this.getMotorCustomer()
            this.motorAddClose()
            this.showAlert('success','Berhasil Menambahkan Motor')
        } catch (err) {
            console.log(err)
            this.showAlert('error','Gagal Menambahkan Motor')
        }
            
      },
      

      async updatecustomer () {
        try {
            const data ={
              id_customer: this.customerData[this.editedIndex].id,
              name_customer: this.editedItem.name,
              phone_number : this.editedItem.phone_number,
              address_customer : this.editedItem.address,

            }
            await this.updateCustomer(data)
            Object.assign(this.customerData[this.editedIndex], this.editedItem)
            this.getCustomer()
            this.close()
            this.showAlert('success','Success Update Customer')

        } catch (err) {
            console.log(err)
            this.showAlert('error','Failed Update Customer')
        }
      },

      async updatemotorcycle () {
        try {
            const data ={
              id_motorcycle: this.selectedMotor.id,
              plate_number: this.editedMotor.plate,
              id_motorcycle_type : this.dropdown_type.find(obj => obj.name == this.editedMotor.type).id,
              id_customer : this.selectedCustomer.id,

            }
            // console.log(data)
            await this.updateMotorcycle(data)
            Object.assign(this.customerData[this.editedIndex], this.editedItem)
            this.getCustomer()
            this.getMotorCustomer()
            this.motorEditClose()
            this.showAlert('success','Success Update Customer')

        } catch (err) {
            console.log(err)
            this.showAlert('error','Failed Update Customer')
        }
      },

      async deletecustomer () {
         try {
            var id_customer = this.customerData[this.editedIndex].id
            await this.deleteCustomer(id_customer)
            this.getCustomer()
            this.close()
            this.showAlert('success','Success Delete Customer')

          } catch (err) {
              console.log(err)
            this.showAlert('error','Failed Delete Customer')

          }
      },
      async deletemotorcycle() {
        try {

            await this.deleteMotorcycle(this.editedItem.id)
            
            this.getCustomer()
            this.getMotorCustomer()
            this.editedItem = Object.assign({},this.defaultdMotor)

            this.showAlert('success','Berhasil Menghapus Motor')
        } catch (err) {
            console.log(err)
            this.showAlert('error','Gagal Menghapus Motor')
        }
            
      },


      editItem (item) {
        this.editedIndex = this.customerData.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialog = true
      },
      
      motorDelete (item) {
        this.editedItem = item
        this.deletemotorcycle()
      },
      motorEdit (item) {
        this.addmotor =false
        this.editedMotor = item
        this.selectedMotor = item
        this.editedIndex = this.motorCustomer.indexOf(item)
        
      },
      motorEditClose(){
        this.editedMotor = Object.assign({},this.defaultdMotor)
        this.selectedMotor = Object.assign({},this.defaultdMotor)
        this.editedIndex = -1
      },
      motorAdd(){
        this.addmotor =true
        this.editedMotor = Object.assign({},this.defaultdMotor)
        this.selectedMotor = Object.assign({},this.defaultdMotor)
        this.editedIndex = -1

      },
      motorAddClose(){
        this.addmotor = false
        this.editedMotor = Object.assign({},this.defaultdMotor)
        this.selectedMotor = Object.assign({},this.defaultdMotor)

        this.editedIndex = -1
      },

      deleteItem (item) {
        this.delDialog = true
        this.editedIndex = this.customerData.indexOf(item)
      },

      close () {
        this.dialog = false
        this.delDialog = false
        this.motorDialog = false
        setTimeout(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedMotor = Object.assign({},this.defaultdMotor)
          this.selectedMotor = Object.assign({},this.defaultdMotor)
          this.selectedCustomer = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
          this.addmotor =false
          this.$v.$reset()
        }, 300)
      },

      save () {
        if (this.editedIndex > -1) {
          Object.assign(this.customerData[this.editedIndex], this.editedItem)
        } else {
          this.customerData.push(this.editedItem)
        }
        this.close()
      },
      showMotor(item){
        this.motorDialog=true
        this.selectedCustomer = item
        // this.motorCustomer = this.motorData.filter(obj => obj.customer.id == item.id);
        this.motorCustomer = item.motorcycle.data
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
