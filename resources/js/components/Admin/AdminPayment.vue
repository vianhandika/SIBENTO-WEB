<template>
    <div>
        <v-toolbar flat color="white">

          <v-toolbar-title>PEMBAYARAN</v-toolbar-title>
          <v-divider
              class="mx-2"
              inset
              vertical
          ></v-divider>

         <!-- dialog box add/edit -->
          <v-dialog v-model="dialog" fullscreen hide-overlay transition="dialog-bottom-transition" max-width="1200px">

              <v-card>
                <v-toolbar dark :color="$root.themeColor">
                    <v-btn icon dark @click="dialog = false">
                        <v-icon>close</v-icon>
                    </v-btn>
                    <v-toolbar-title>{{ formTitle }}</v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-toolbar-items>
                        <div class="text-xs-center subheading mt-3 mr-5">
                          Status Pembayaran: {{editedItem.status_paid}}
                        </div>
                    </v-toolbar-items>
                </v-toolbar>
                <br>
                <hr>
                <!-- Pelanggan dan Motor -->
                <v-layout row wrap>
                  <v-card width="100%" ml-5 mr-5>
                    <v-layout row wrap>

                    <!-- Pelanggan -->
                    <v-flex sm3 pr-3 pl-5> 
                    <v-card height="100%">
                        <v-card-title class="grey lighten-2 theme--light justify-center">
                            <span class="headline">Data Pelanggan</span>
                        </v-card-title>
                        <v-card-text>
                            <v-container grid-list-md>
                            <v-layout wrap v-if="setcustomer"> 
                                

                                <v-flex xs12>
                                    <v-select
                                        v-model="editedItem.id_customer"
                                        :items="initcustomer"             
                                        item-text="name"
                                        item-value="id"
                                        label="Nama Pelanggan"
                                        disabled
                                        required
                                        prepend-inner-icon="fa fa-user">
                                    </v-select>
                                </v-flex>

                                <v-flex xs12>
                                    <v-text-field 
                                        v-model="editedCustomer.phone_number" 
                                        label="Nomor Telepon" 
                                        :counter="12"
                                        disabled
                                        required
                                        prepend-inner-icon="fa fa-phone">
                                    </v-text-field>
                                </v-flex>

                                <v-flex xs12>
                                    <v-text-field 
                                        v-model="editedCustomer.address" 
                                        label="Alamat"
                                        :counter="100"
                                        disabled
                                        required
                                        prepend-inner-icon="fas fa-map-marker-alt">
                                    </v-text-field>
                                </v-flex>
                                
                            </v-layout>
                            </v-container>
                        </v-card-text>
                    </v-card>
                    </v-flex>
                    
                    <!-- Tipe Transaksi -->
                    <v-flex sm3 pr-3>
                    <v-card height="100%">
                        <v-card-title class="grey lighten-2 theme--light justify-center">
                            <span class="headline">Jenis Transaksi</span>
                        </v-card-title>
                        <v-card-text>
                            <v-container grid-list-md>
                            <v-layout wrap>

                                <v-flex>
                                    <v-select
                                        v-model="editedItem.type_transaction"
                                        :items="dropdown_tipe"
                                                                    
                                        item-text="text"
                                        item-value="id"
                                        label="Transaksi"
                                        required
                                        disabled
                                
                                        prepend-inner-icon="fas fa-flag">
                                </v-select>
                                </v-flex>
                                
                            </v-layout>
                            </v-container>
                        </v-card-text>
                        <hr>
                        <v-card-title class="grey lighten-2 theme--light justify-center">
                            <span class="headline">Status Transaksi</span>
                        </v-card-title>
                        <v-card-text>
                            <v-container grid-list-md>
                            <v-layout wrap>

                                <v-flex>
                                    <v-select
                                        v-model="editedItem.status_process"
                                        :items="dropdown_status"
                                                                  
                                        item-text="text"
                                        item-value="text"
                                        label="Status"
                                        required
                                        disabled
                              
                                        prepend-inner-icon="fas fa-flag">
                                    </v-select>
                                </v-flex>
                                
                            </v-layout>
                            </v-container>
                        </v-card-text>
                    </v-card>
                    </v-flex>

                    <!-- Tipe Transaksi -->
                    <v-flex sm6 pr-5>
                    <v-card height="100%" width="100%">
                        <v-card-title class="green lighten-2 theme--light justify-center">
                            <span class="headline font-weight-bold">Pembayaran</span>
                        </v-card-title>
                        <v-card-text>
                            <v-container grid-list-md>
                            <v-layout wrap>

                                <v-flex sm12>
                                  <div class="text-xs-center subheading font-weight-bold">
                                    Kode Transaksi
                                  </div>
                                  <div class="text-xs-center headline">
                                    {{editedItem.id_transaction}}
                                  </div>
                                  <div  class="text-xs-center subheading font-weight-bold mt-2">
                                    Total Transaksi
                                  </div>
                                  <div class="text-xs-center headline">
                                    Rp. {{editedItem.total_transaction}}
                                  </div>
                                </v-flex>

                                <v-flex sm6>
                                  <v-text-field 
                                      v-model="editedItem.discount_transaction"
                                      prepend-inner-icon="fas fa-coins"
                                      label="Diskon"
                                      :disabled="editedItem.status_paid=='Paid'"
                                      :error-messages="discountErrors"
                                      @input="$v.editedItem.discount_transaction.$touch(),countCharge()"
                                      @blur="$v.editedItem.discount_transaction.$touch()">
                                      
                                  </v-text-field>
                                </v-flex>
                                <v-flex sm6>
                                  <v-text-field v-if="editedItem.status_paid!='Paid'"
                                      v-model="bayar"
                                      prepend-inner-icon="fas fa-coins"
                                      label="Bayar"
                                      :error-messages="paidErrors"
                                      @input="$v.bayar.$touch(),countCharge()"
                                      @blur="$v.bayar.$touch()">
                                      
                                  </v-text-field>
                                </v-flex>

                                <v-flex sm6>
                                  <v-text-field v-if="editedItem.status_paid!='Paid'"
                                      v-model="kembalian"
                                      prepend-inner-icon="fas fa-coins"
                                      label="Kembalian"
                                      disabled>
                                      
                                  </v-text-field>
                                </v-flex>
                                 <v-flex sm6>
                                   <v-btn v-if="editedItem.status_paid!='Paid'"
                                        small block color="primary"  
                                        style="text-transform:none !important;"
                                        class="mt-4"
                                        @click="payment()"
                                        :disabled="$v.editedItem.$invalid || $v.bayar.$invalid">
                                        PROSES DAN CETAK NOTA
                                    </v-btn>
                                </v-flex>
                                
                            </v-layout>
                            </v-container>
                        </v-card-text>
                       
                    </v-card>
                    </v-flex>
                    </v-layout>
                  
                  </v-card>

                </v-layout>
                
               <!-- Sparepart -->
                <v-layout row wrap v-if="editedItem.type_transaction == 'Sparepart' || editedItem.type_transaction == 'Sparepart dan Service'">
                <br>
                <hr>
                    <v-flex sm12 ml-5 mr-5>
                    <v-card>
                        <v-card-title class="grey lighten-2 theme--light justify-center">
                            <span class="headline">Sparepart</span>
                        </v-card-title>
                        <v-card-text>
                            <v-data-table
                            :headers="sparepartheaders"
                            :rows-per-page-items="[3]"
                            :items="editedItem.sparepart.data">

                                <template v-slot:items="props">
                                    <td>{{ props.item.brand_sparepart}}</td>
                                    <td class="text-xs-center">{{ props.item.name_sparepart }}</td>
                                  
                                    <td class="text-xs-center">{{ props.item.price_transaction_sparepart }}</td> 

                                    <td class="text-xs-center">{{ props.item.amount_transaction_sparepart }}</td>

                                    <td class="text-xs-center">{{ props.item.plate_number }}</td>
        
                                    <td class="text-xs-center">{{ props.item.mechanic_name }}</td>

                                    <td class="text-xs-center">{{ props.item.subtotal_transaction_sparepart }}</td>
                                    
                                   
                                </template> 
                            </v-data-table>  
                        </v-card-text>
                    </v-card>
                    </v-flex>
                </v-layout>

               <!-- Service -->
                <v-layout row wrap v-if="editedItem.type_transaction == 'Service' || editedItem.type_transaction == 'Sparepart dan Service'">
                <br>
                <hr>
                    <v-flex sm12 ml-5 mr-5>
                    <v-card>
                        <v-card-title class="grey lighten-2 theme--light justify-center">
                            <span class="headline">Jasa Service</span>
                        </v-card-title>
                        <v-card-text>
                            <v-data-table
                            :headers="serviceheaders"
                            :rows-per-page-items="[3]"
                            :items="editedItem.service.data">

                                <template v-slot:items="props">
                                    <td>{{ props.item.service_name}}</td>
                                    
                                    <td class="text-xs-center">{{ props.item.plate_number }}</td>
                                        
                                    <td class="text-xs-center">{{ props.item.mechanic_name }}</td>
                                    
                                    <td class="text-xs-center">{{ props.item.price_transaction_service }}</td>
                                    
                                </template>
                               
                            </v-data-table>  
                        </v-card-text>
                    </v-card>
                    </v-flex>
                </v-layout>
                <br>
                <hr>

              </v-card>
          </v-dialog>
         <!-- END dialog box add/edit -->

         

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
          v-if="inittransaction"
          :headers="headers"
          :items="inittransaction"
          :search="search"
          class="elevation-1">

          <template v-slot:items="props">
              <td>{{ props.item.id_transaction }}</td>
              <td class="text-xs-center">{{ props.item.date_transaction }}</td>
              <td class="text-xs-center">{{ props.item.name_customer }}</td>
              <td class="text-xs-center">{{ props.item.type_transaction }}</td>
              <td class="text-xs-center">
                
                <v-chip v-if="props.item.status_paid=='Unpaid'" light color="orange" text-color="white"> {{ props.item.status_paid }}</v-chip>
                <v-chip v-else light color="green" text-color="white"> {{ props.item.status_paid }}</v-chip>
               

              </td>
              <td class="text-xs-center">Rp. {{ props.item.total_transaction }}</td>

              <td class="text-xs-center">
                   <v-btn v-if="props.item.status_paid=='Paid'"
                    depressed small color="success" dark 
                    style="text-transform:none !important;"
                    @click="detailItem(props.item)">
                    Detail
                  </v-btn>
                  <v-btn v-else
                    depressed small color="primary" dark 
                    style="text-transform:none !important;"
                    @click="payItem(props.item)">
                    Bayar
                  </v-btn>
              </td>
              <td class="justify-center layout px-0">
               <v-icon
                  small
                  
              >
                  print
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
        <!-- END Tabel -->
        <!-- Alert -->
        <v-snackbar right bottom :color="alert.type"  value="true" v-if="alert.type">
          <v-icon>{{alert.icon}}</v-icon>{{alert.message}}
        </v-snackbar>
    </div>
</template>


<script>
  import Controller from '../../httpController'
  import { mapState, mapActions } from 'vuex'
  import transactionService from '../../service/Transaction'
  import employeeService from '../../service/Employee'
  import sparepartService from '../../service/Sparepart'
  import serviceService from '../../service/Service'
  import motorService from '../../service/MotorCustomer'
  import customerService from '../../service/Customer'
  import motorBrandService from '../../service/MotorBrand'
  import motorTypeService from '../../service/MotorType'
  import { mapGetters } from 'vuex'


  import { required, maxLength, numeric, sameAs, not} from 'vuelidate/lib/validators'

  function payErrors () {
    if(this.bayar>=(this.editedItem.total_transaction-this.editedItem.discount_transaction))
    {
      return true
    }
    else
    {
      return false
    }
  }

  export default {
    validations: {
        editedItem: {
          discount_transaction: { required,numeric },
        },
        bayar:{required,numeric,payErrors},
        
    },

    data: () => ({
      
      dialog: false,
      delDialog: false,
      dateDialog: false,
      verifMode:false,
      detailMode:false,
      addmotor:false,
      
      // sparepartDialog:false,
      search: '',
      i:0,
      headers: [
        { text: 'Id Transaksi', align: 'center', value: 'id_transaction' },
        { text: 'Tanggal', align: 'center', value: 'date_transaction' },
        { text: 'Pelanggan', align: 'center', value: 'name_customer' },
        { text: 'Tipe Transaksi', align: 'center', value: 'type_transaction' },
        { text: 'Status', align: 'center', value: 'status_process' },
        { text: 'Total', align: 'center', value: 'total_transaction' },
        { text: 'Bayar', align: 'center',sortable: false},
        { text: 'Actions', align: 'center', sortable: false }
      ],

      dropdown_status: [
        { id: "Unprocessed", text: 'Unprocessed' },
        { id: "On Process", text: 'On Process' },
        { id: "Finish", text: 'Finish' }
      ],
      dropdown_tipe: [
        { id: "Sparepart", text: 'Sparepart' },
        { id: "Sparepart dan Service", text: 'Sparepart dan Service' },
        { id: "Service", text: 'Service' }
      ],
      serviceheaders: [
        { text: 'Jasa Service', align: 'left', value: 'service_name' },
        { text: 'Motor Pelanggan', align: 'center', value: 'plate_number', sortable: false },
        { text: 'Montir', align: 'center', value: 'mechanic_name', sortable: false },
        { text: 'Harga', align: 'center', value: 'price_transaction_service', sortable: false },

      ],
      sparepartheaders: [
        { text: 'Merk', align: 'left', value: 'brand_sparepart', sortable: false },
        { text: 'Sparepart', align: 'center', value: 'name_sparepart' },
        { text: 'Harga Satuan', align: 'center', value: 'price_transaction_sparepart', sortable: false },
        { text: 'Jumlah', align: 'center', value: 'amount_transaction_sparepart', sortable: false },
        { text: 'Motor Pelanggan', align: 'center', value: 'amount_transaction_sparepart', sortable: false },
        { text: 'Montir', align: 'center', value: 'mechanic_name', sortable: false },
        { text: 'Subtotal', align: 'center', value: 'subtotal_transaction_sparepart', sortable: false },

      ],

      dropdown_sales:[],
      dropdown_sparepart:[],
      transactionData: [],
    //CUSTOMER VAR==============
      newCustomer:false,
      customerData:[],
      editedCustomer: {
        name: '',
        phone_number: '',
        address: '',
      },
    //==========================
     
      editedIndex: -1,
    
      total:0,
      selectedTransaction: {
        name: '',
        phone_number: '',
        address: '',
      },

      editedItem: {
        date_transaction: '',
        status_process: 'Unprocessed',
        type_transaction:'',
        discount_transaction: '',
        total_transaction: '',
        id_customer: '',
        name_customer: '',
        sparepart:{
          data:[],
        },
        service:{
          data:[],
        },
        employee:{
          data:[],
        },
  
  
      },
      defaultItem: {
        date_transaction: '',
        status_process: 'Unprocessed',
        type_transaction:'',
        discount_transaction: '',
        total_transaction: '',
        id_customer: '',
        name_customer: '',
        sparepart:{
          data:[],
        },
        service:{
          data:[],
        },
        employee:{
          data:[],
        },


      },
      employee:[],
      discount:'',
      bayar:0,
      kembalian:0,

    
      alert:{
        type: null,
        message: null,
        icon: null,
      }
      // elapse: null
    }),

    computed: {
      formTitle () {
        if(this.detailMode == true)
        {
          return 'Detail Transaksi'
        }
        else
        {
          return 'Proses Pembayaran'
        }
        // return this.editedIndex === -1 ? 'Tambah Transaksi Penjualan' : 'Edit Transaksi Penjualan'
      },

      ...mapState({
        loading: state => state.Transaction.loading,
        error: state => state.Transaction.error,
        transactions: state => state.Transaction.transactions,
        employees: state => state.Employee.employees,
        services: state => state.Service.services,
        spareparts: state => state.Sparepart.spareparts,
        customers: state => state.Customer.customers,
        motorcustomers: state => state.MotorCustomer.motorcustomers,
        motorbrands: state => state.MotorBrand.motorbrands,
        motortypes: state => state.MotorType.motortypes,


      }),

       ...mapGetters({
        id: 'LoggedUser/id',
        name: 'LoggedUser/name',
        username: 'LoggedUser/username',
        role: 'LoggedUser/role'
      }),


      inittransaction () {
        this.transactionData = this.transactions;
        return this.transactionData
      },

      initcustomer() {
        this.customerData = this.customers;
        return this.customerData
      },
      
      setcustomer(){
        if(this.editedItem.id_customer !='')
        {
            this.editedCustomer = this.customers.find(obj=>obj.id == this.editedItem.id_customer);
            this.editedItem.employee.data[0] = {
                id_employee : this.id
            }
        }
        
        return this.editedCustomer
      },

      //VALIDATION ERROR
      discountErrors () {
        const errors = []
        if (!this.$v.editedItem.discount_transaction.$dirty) return errors
        !this.$v.editedItem.discount_transaction.required && errors.push('Diskon diperlukan.')
        !this.$v.editedItem.discount_transaction.numeric && errors.push('Diskon harus numerik.')

        return errors
      },

      paidErrors () {
        const errors = []
        if (!this.$v.bayar.$dirty) return errors
        !this.$v.bayar.required && errors.push('Uang diperlukan.')
        !this.$v.bayar.numeric && errors.push('Uang harus numerik.')
        !this.$v.bayar.payErrors && errors.push('Uang kurang.')


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
      
    },

    created () {
      // this.loaddata ()
      // this.showAlert('error','Failed Update Transaction');
      //  console.log(this.dropdown_role);
      // this.topayload()
    },
    mounted(){
      this.getTransaction()
      this.getSparepart()
      this.getService()
      this.getCustomer()
      this.getEmployee()
      this.getMotorCustomer()
      this.getMotorBrand()
      this.getMotorType()
      // this.initialize()
    },

    methods: {
      initialize () {

      },
      ...mapActions({
        getTransaction: 'Transaction/get',  
        storeTransaction: 'Transaction/store',  
        updateTransaction: 'Transaction/update',
        deleteTransaction: 'Transaction/delete',
        paymentTransaction: 'Transaction/payment',

        getEmployee: 'Employee/get',  
        getSparepart: 'Sparepart/get',
        getService : 'Service/get',

        getCustomer : 'Customer/get',
        storeCustomer: 'Customer/store',
        deleteCustomer: 'Customer/delete',
        updateCustomer: 'Customer/update',

        getMotorCustomer : 'MotorCustomer/get',
        storeMotorcycle : 'MotorCustomer/store',
        updateMotorcycle : 'MotorCustomer/update',
        deleteMotorcycle : 'MotorCustomer/delete',

        getMotorBrand : 'MotorBrand/get',
        getMotorType : 'MotorType/get'

      }),

      countCharge(){
          if(this.bayar>=this.editedItem.total_transaction - this.editedItem.discount_transaction){
            this.kembalian = this.bayar - (this.editedItem.total_transaction - this.editedItem.discount_transaction)
          } 
      },

      async payment() {
        try {
          this.employee[0] = {
                id_employee : this.id
          }

          const data ={
            id_transaction: this.editedItem.id_transaction,            
            discount_transaction:this.editedItem.discount_transaction,
            total_transaction: this.editedItem.total_transaction,
            employee: this.employee,
          }

          console.log(data)

          await this.paymentTransaction(data)
          this.transactionData.push(this.editedItem)
          await this.getTransaction()
          this.editedItem = Object.assign({},this.transactions.find(obj=>obj.id_transaction == this.editedItem.id_transaction))
          this.employee = []
          this.discount = 0
          this.bayar = 0
          this.kembalian = 0
          this.close()
          this.showAlert('success','Berhasil Tambah Transaksi')
        } catch (err) {
          console.log(err)
          this.showAlert('error','Gagal Tambah Transaksi')
        }
            
      },
      
      //MAIN MODAL AND TABLE====================

        detailItem(item){
            this.detailMode = true
            this.editedIndex = this.transactions.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialog = true
        },
        payItem(item){
            this.editedIndex = this.transactions.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialog = true
        },
        
        close () {
            this.dialog = false
            this.delDialog = false

            // this.sparepartDialog = false
            setTimeout(() => {
            this.editedItem = Object.assign({}, this.defaultItem)
            this.editedSparepart = Object.assign({},this.defaultSparepart)
            this.selectedSparepart = Object.assign({},this.defaultSparepart)
            this.editedIndex = -1
            this.sparepartIndex = -1
            this.addsparepart =false
            this.verifMode = false
            this.detailMode = false
            this.$v.$reset()
            }, 300)
        },
      
      //========================================

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
