<template>
<v-app id="inspire">
    <div class="application">
        <v-toolbar
            dark 
            app 
            :color="$root.themeColor"
        >
            <v-container mx-auto py-0>
             <v-layout>
                <v-img
                    src="http://localhost:8000/images/logo.png" 
                    class="mr-3"
                    contain
                    width="36"
                    max-width="36"
                />
                <div class="pt-2 center subheading font-weight-bold"> Sistem Informasi Bengkel Atma Auto</div>
             </v-layout>
            </v-container>
            <v-toolbar-items class="hidden-sm-and-down">
                <v-btn flat>Tentang</v-btn>
                <v-btn flat>Cek Transaksi</v-btn>
                <v-btn flat>Sparepart</v-btn>
            </v-toolbar-items>

        <!-- dialog box add/edit -->
          <v-dialog v-model="dialog" fullscreen hide-overlay transition="dialog-bottom-transition" max-width="1200px">

              <v-card>
                <v-toolbar dark :color="$root.themeColor">
                    <v-btn icon dark @click="dialog = false">
                        <v-icon>close</v-icon>
                    </v-btn>
                    <v-toolbar-title>Detail Transaksi</v-toolbar-title>
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
                            <span class="headline font-weight-bold">Informasi</span>
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
                                      disabled
                                    >
                                      
                                  </v-text-field>
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
        </v-toolbar>
        <v-content>
        <!-- <v-container> -->
         <v-layout row wrap>
        

          <v-flex xs12 class="MainBanner">
            <v-card dark>
                <v-img
                class="grey lighten-2"
                height="400"
                width="100%"
                src="http://localhost:8000/images/Banner.jpg" 
                >
                    <v-layout
                        fill-height
                        align-center
                        
                        pa-3
                    >
                        <v-flex
                            xs12
                            style="text-align:center;"
                            
                        >
                 
                            <img
                                src="http://localhost:8000/images/logo.png" 
                            
                                
                                width="100"
                                max-width="100"
                            />
                            
                            
                            <h1 class="display-3 font-weight-light">
                                Bengkel Atma Auto
                            </h1>
                            <div class="subheading text-uppercase pl-2 mb-4">
                                The Art of Mechanism
                            </div>
                            
                        </v-flex>
                    </v-layout>
                </v-img>

            </v-card>
          </v-flex>
          
          <v-flex xs12 >
            <v-card  height="400px" flat class="grey lighten-3 pt-5">
                
                <v-card-title class="justify-center ">
                    <h1 class="font-weight-bold">TENTANG</h1>
                </v-card-title>
                <v-card-text>
                    <v-container >
                        <!-- <h3 style="text-align:center;">
                            Bengkel Atma Auto merupakan bengkel yang menyediakan jasa servis 
                            berbagai merk motor dan juga menyediakan sparepart sesuai kebutuhan 
                            motor anda. Pelayanan kami sangat ramah dan didukung dengan teknologi
                            modern yang bisa membantu anda untuk memantau progres servis motor anda.
                        </h3> -->
                        <h3 style="text-align:center;">
                            Bengkel Atma Auto merupakan sebuah bengkel sepeda motor yang menyediakan jasa service dan  
                            penjualan  spareparts  yang  berada  di  Kota  Yogyakarta.  Atma  Auto  menyediakan  spareparts  
                            motor  dari  berbagai  merk  sepeda  motor  yang  ada  di  Indonesia.  Selain  menjual  spareparts,  
                            Atma Auto juga menyediakan beberapa jasa service pada sepeda motor. Atma Auto bekerja  
                            sama  dengan  beberapa  supplier  dalam  penyediaan  stok  spareparts  yang  dijual. Pelayanan kami sangat ramah 
                            dan didukung dengan teknologi modern yang bisa membantu anda untuk memantau progres servis motor anda.
                        </h3>
                    </v-container>    
                </v-card-text>

               
            </v-card>
          </v-flex>
          <v-flex xs12 mt-3>
            <v-card flat >
                
                <v-card-title class="justify-center ">
                    <h1 class="font-weight-bold">CEK TRANSAKSI</h1>
                </v-card-title>
                <v-card-text>
                    <v-container>
                        <v-layout row wrap >
                            <v-card width="100%"> 

                            <v-layout row wrap >
                            <v-flex sm4>
                                <v-card-text style="text-align:center">
                                    
                                    <span class="headline font-weight-bold">
                                        Cek Riwayat Transaksi Anda
                                    </span>
                                    <hr>
                                    <v-text-field class="mt-3"
                                        v-model="searchcustomer.platenumber"
                                        label="Nomor Plat Motor"
                                        :counter="25"
                        
                                        required
                                        prepend-inner-icon="fa fa-motorcycle">
                                    </v-text-field>
                                    <v-text-field 
                                       v-model="searchcustomer.handphone"
                                        label="Nomor Handphone"
                                        :counter="25"
                        
                                        required
                                        prepend-inner-icon="fa fa-phone">
                                    </v-text-field>
                                    <v-btn 
                                        small dark block color="blue darken-3"  
                                        style="text-transform:none !important;"
                                        @click="findCustomer()"
                                        
                                    >
                                        Cari
                                    </v-btn>
                                </v-card-text>
                            </v-flex>
                            <v-flex sm8>
                                <v-card-text style="text-align:center">
                                    <span class="headline font-weight-bold">
                                            Profil Pelanggan
                                    </span>
                                    <hr>
                                    <v-layout row wrap>
                                        
                                        <v-flex sm4>
                                            <div class="mt-3 text-xs-left subheading font-weight-bold">
                                                Nama Pelanggan
                                            </div>
                                            <div class="ml-3 text-xs-left subheading">
                                                {{customer.name}}
                                            </div>
                                            <div  class="text-xs-left subheading font-weight-bold mt-2">
                                                Alamat
                                            </div>
                                            <div class="ml-3 text-xs-left subheading">
                                                {{customer.address}}
                                            </div>
                                            <div  class="text-xs-left subheading font-weight-bold mt-2">
                                                Handphone
                                            </div>
                                            <div class="ml-3 text-xs-left subheading">
                                                {{customer.phone_number}}
                                            </div>
                                        </v-flex>
                                        <v-flex sm4>
                                            <div class="mt-3 text-xs-left subheading font-weight-bold">
                                                Motor Pelanggan
                                            </div>
                                            <div class="ml-3 text-xs-left subheading">
                                                <ul>
                                                    <li v-for="(motor,index) of customer.motorcycle.data" v-bind:key="index">
                                                        {{ motor.plate }}
                                                    </li>
                                                </ul>

                                            </div>
                              
                                        </v-flex>
                                        <v-flex sm4>
                                            <div class="mt-3 text-xs-left subheading font-weight-bold">
                                                Total Transaksi
                                            </div>
                                            <div class="ml-3 text-xs-left subheading">
                                                {{searchcustomer.totaltransaksi}}
                                            </div>
                              
                                        </v-flex>
                                        </v-layout>
                                </v-card-text>
                            </v-flex>
                            </v-layout>

                            <v-flex xs12>
                               
                                <v-card-text>
                                    <v-toolbar flat color="grey lighten-3">
                                    <v-toolbar-title class="headline font-weight-bold">Riwayat Transaksi</v-toolbar-title>
                                    
                                    </v-toolbar>
                                    <!-- <v-card> -->
                                    <v-data-table
                                        :headers="headers"
                                        :items="transactionData"
                                        class="elevation-1">

                                        <template v-slot:items="props">
                                            <td class="text-xs-center">{{ props.item.id_transaction }}</td>
                                            <td class="text-xs-center">{{ props.item.date_transaction }}</td>
                                            <td class="text-xs-center">Rp. {{ props.item.total_transaction }}</td>
                                            <td class="text-xs-center">
                                                
                                                <v-chip v-if="props.item.status_process=='Unprocessed'" light color="red" text-color="white">{{ props.item.status_process }}</v-chip>
                                                <v-chip v-else-if="props.item.status_process=='On Process'" light color="orange" text-color="white">{{ props.item.status_process }}</v-chip>
                                                <v-chip v-else light color="green" text-color="white">{{ props.item.status_process }}</v-chip>

                                            </td>
                                            <td class="justify-center layout px-0">
                                                
                                            <v-icon
                                                small
                                                class="mr-2"
                                                @click="detailItem(props.item)"
                                            >
                                                remove_red_eye
                                            </v-icon>
                                            </td>
                                        </template>
                                    </v-data-table>
                                    <!-- </v-card> -->
                                    <!-- END Tabel -->
                                </v-card-text>
                            </v-flex>

                           

                            </v-card>
                        </v-layout>
                    </v-container>    
                </v-card-text>

               
            </v-card>
          </v-flex>
            <v-flex xs12 class="grey lighten-3 ">
                <v-card-title class="justify-center ">
                    <h1 class="font-weight-bold">KATALOG SPAREPART</h1>
                </v-card-title>
                <v-card-text >
                    <v-container fluid >
                        <v-card width="100%" min-height="600px">
                            <v-layout row wrap>
                                <v-flex sm7>
                                </v-flex>
                                <v-flex sm2 class="mt-3 pl-3 pr-3">
                                        <v-select       
                                        v-model="shorting" 
                                        :items="dropdown_shorting"   
                                        item-text="text"
                                        item-value="id"
                                        label="Shorting"
                                        required
                                        prepend-inner-icon="swap_vert">
                                    </v-select>
                                </v-flex>
                                
                                
                                <v-flex sm3 class="mt-3 pl-3 pr-3">
                                        <v-text-field 
                                        v-model="search"
                                        append-icon="search"
                                        label="Cari"
                                        single-line
                                        hide-details>
                                    </v-text-field>
                                </v-flex>

                                
                            </v-layout>
                                <v-data-iterator
                                :items="initsparepart"
                                
                                :search="search"
                                :pagination.sync="pagination"
                                content-tag="v-layout"
                                hide-actions
                                row
                                wrap
                                >
                                <template v-slot:item="data">
                                <!-- <v-flex v-for="data of filters" v-bind:key="data['id']" -->
                                <v-flex
                                sm2 class="pl-3 pr-3 mt-3 mb-3">
                                        <v-card color="grey lighten-3">
                                        <v-img 
                                            :src="data.item.image"
                                            aspect-ratio="1"
                                        ></v-img>

                                        <v-card-title  primary-title>
                                        <div>
                                            <h4 class="subheading font-weight-bold mb-0">{{data.item.name}}</h4>
                                            <div><v-icon color="orange">star</v-icon> {{data.item.brand}}</div>
                                            <div><v-icon color="red">swap_vert</v-icon> Stok {{data.item.stock}}</div>
                                            <div><v-icon color="green">attach_money</v-icon> Rp. {{data.item.sell_price}}</div>
                                            

                                        </div>
                                        </v-card-title>

                                        </v-card>
                                </v-flex>
                                </template>
                                </v-data-iterator>
                                    <div class="text-xs-center pt-2">
                                        <v-pagination v-model="pagination.page" :length="pages"></v-pagination>
                                    </div>
                                <!-- <div class="text-xs-center container-fluid text-right">
                                    <v-pagination
                                    v-model="page"
                                    :length="4"
                                    prev-icon="mdi-menu-left"
                                    next-icon="mdi-menu-right"
                                    ></v-pagination>
                                </div> -->
                        </v-card>
                    </v-container>
                </v-card-text>
            </v-flex>
        
         </v-layout>
        <!-- </v-container> -->
        </v-content>
        <v-snackbar right bottom :color="alert.type"  value="true" v-if="alert.type">
          <v-icon>{{alert.icon}}</v-icon>{{alert.message}}
        </v-snackbar>
    </div>
</v-app>
</template>

<script>
  import Controller from '../../httpController'
  import { mapState, mapActions,mapGetters } from 'vuex'
  import transactionService from '../../service/Transaction'

  import employeeService from '../../service/Employee'
  import sparepartService from '../../service/Sparepart'
  import serviceService from '../../service/Service'
  import motorService from '../../service/MotorCustomer'
  import customerService from '../../service/Customer'
  import motorBrandService from '../../service/MotorBrand'
  import motorTypeService from '../../service/MotorType'


    export default {
        data: () => ({
            dialog:false,
            headers: [
                { text: 'Id Transaksi', align: 'center', value: 'id_transaction' },
                { text: 'Tanggal', align: 'center', value: 'date_transaction' },
                { text: 'Total Harga', align: 'center', value: 'total_transaction' },
                { text: 'Status', align: 'center', value: 'status_process' },
                { text: 'Actions', align: 'center', sortable: false }
            ],
            dropdown_shorting: [
                { id: "None", text: 'None' },
                { id: "Harga Tertinggi", text: 'Harga Tertinggi' },
                { id: "Harga Terendah", text: 'Harga Terendah' },
                { id: "Stok Tertinggi", text: 'Stok Tertinggi' },
                { id: "Stok Terendah", text: 'Stok Terendah' }
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
            transactionData:[],
            sparepartData:[],
            searchcustomer:{
                platenumber:'',
                handphone:'',
                totaltransaksi:'',

            },
            customer: {
                id:'-',
                name: '-',
                phone_number: '-',
                address: '-',
                motorcycle:[],

            },
            search:'',
            shorting:'None',

            datacount:0,
            page: 0,
            start: 0,
            end: 0,

            editedIndex: -1,

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
                    // rowsPerPageItems: [4, 8, 12],
            // pagination: {
            //     rowsPerPage: 12
            // },
            pagination:{},
            alert:{
                type: null,
                message: null,
                icon: null,
            }
        }),
        computed:{
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

            // filters: function(){
            //     if(this.spareparts.length) {
            //         // console.log(this.spareparts.length)
            //         return this.spareparts.filter((sparepart, index) => {
            //             if(this.search != null) return sparepart.name.toLowerCase().includes(this.searchcustomer.toLowerCase());
            //             if(index >= this.start && index < this.end) return true;
            //         });
            //     }
            // },
            pages () {
                return this.pagination.rowsPerPage ? Math.ceil(this.spareparts.length / this.pagination.rowsPerPage) : 0
            },

        //INIT===============================
            inittransaction () {
                this.transactionData = this.transactions
                
                return this.transactionData
            },
            initsparepart(){
                if(this.shorting=='None')
                {
                    this.sparepartData = this.spareparts
                }
                else if(this.shorting=='Harga Tertinggi'){
                    this.sparepartData =  this.spareparts.sort(function(obj1, obj2) {
                                                // Ascending: first age less than the previous
                                                return obj2.sell_price - obj1.sell_price;
                                            });
                }
                else if(this.shorting=='Harga Terendah'){
                    this.sparepartData =  this.spareparts.sort(function(obj1, obj2) {
                                                // Descending: first age less than the previous
                                                return obj1.sell_price - obj2.sell_price;
                                            });
                }
                else if(this.shorting=='Stok Tertinggi'){
                    this.sparepartData =  this.spareparts.sort(function(obj1, obj2) {
                                                // Ascending: first age less than the previous
                                                return obj2.stock - obj1.stock;
                                            });
                }
                else if(this.shorting=='Stok Terendah'){
                    this.sparepartData =  this.spareparts.sort(function(obj1, obj2) {
                                                // Descending: first age less than the previous
                                                return obj1.stock - obj2.stock;
                                            });
                }

                return this.sparepartData
            }
        },
        watch: {
            dialog (val) {
                val || this.close()
            },     
        },

        mounted() {
            this.getTransaction()
            this.getSparepart()
            this.getService()
            this.getCustomer()
            this.getEmployee()
            this.getMotorCustomer()
            this.getMotorBrand()
            this.getMotorType()
            this.setdatacount()
        },

        methods:{
            ...mapActions({
                getTransaction: 'Transaction/get',  
                storeTransaction: 'Transaction/store',  
                updateTransaction: 'Transaction/update',
                deleteTransaction: 'Transaction/delete',

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
            setdatacount(){
                this.datacount = this.spareparts.length
            },
            pageChange(page, start, end) {
                this.page = page;
                this.start = start;
                this.end = end;
            },
            findCustomer(){
                // this.customer = this.customers.find(obj=>obj.phone_number)
                var i = 0,j=0
                for(var data in this.customers)
                {
                    if(this.customers[i].motorcycle.data !=null)
                    {
                        // console.log(this.customers[i])
                        for(var motor in this.customers[i].motorcycle.data)
                        {
                            
                            if(this.customers[i].motorcycle.data[j].plate == this.searchcustomer.platenumber
                                && this.customers[i].motorcycle.data[j].customer.phone_number == this.searchcustomer.handphone)
                            {
                                this.customer = this.customers[i]
                            }
                            j++;
                        }
                        j=0
                    }
                   
                    i++;
                }
                i=0
                if(this.customer.id!='-')
                {
                    // console.log("masuk1")
                    this.transactionData = this.transactions.filter(obj=>obj.id_customer == this.customer.id)
                    this.searchcustomer.totaltransaksi = this.transactionData.length
                    
                    console.log(this.searchcustomer.totaltransaksi)
                }
                else{
                    // console.log("masuk")
                    this.showAlert('error','Data Tidak Ditemukan !')
                }
            },
            detailItem(item){
                this.detailMode = true
                this.editedIndex = this.transactions.indexOf(item)
                this.editedItem = Object.assign({}, item)
                this.dialog = true
            },
            close () {
                this.dialog = false
              
                
                setTimeout(() => {
                    this.editedItem = Object.assign({}, this.defaultItem)
                    this.editedIndex = -1
                    this.detailMode = false

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
