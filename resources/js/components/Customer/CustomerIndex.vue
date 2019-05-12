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
                <v-btn flat>Cek Pemesanan</v-btn>
                <v-btn flat>Sparepart</v-btn>
            </v-toolbar-items>

        
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
                        <h3 style="text-align:center;">
                            Bengkel Atma Auto merupakan bengkel yang menyediakan jasa servis 
                            berbagai merk motor dan juga menyediakan sparepart sesuai kebutuhan 
                            motor anda. Pelayanan kami sangat ramah dan didukung dengan teknologi
                            modern yang bisa membantu anda untuk memantau progres servis motor anda.
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
                                        v-model="search.platenumber"
                                        label="Nomor Plat Motor"
                                        :counter="25"
                        
                                        required
                                        prepend-inner-icon="fa fa-motorcycle">
                                    </v-text-field>
                                    <v-text-field 
                                       v-model="search.handphone"
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
                                                {{search.totaltransaksi}}
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
                                            <td class="text-xs-center">{{ props.item.name_customer }}</td>
                                            <td class="text-xs-center">
                                                
                                                <v-chip v-if="props.item.status_process=='Unprocessed'" light color="red" text-color="white">{{ props.item.status_process }}</v-chip>
                                                <v-chip v-else-if="props.item.status_process=='On Process'" light color="orange" text-color="white">{{ props.item.status_process }}</v-chip>
                                                <v-chip v-else light color="green" text-color="white">{{ props.item.status_process }}</v-chip>

                                            </td>
                                            <td class="justify-center layout px-0">
                                                
                                            <v-icon
                                                small
                                                class="mr-2"
                                                
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
            <v-flex xs12>
                 <v-card-title class="justify-center ">
                    <h1 class="font-weight-bold">SPAREPART</h1>
                </v-card-title>
                <v-card-text>
                    <v-container fluid>
                        <v-card width="100%">
                            <v-layout row wrap>

                                <v-flex sm2>
                                     <v-select           
                                        item-text="name"
                                        item-value="id"
                                        label="Shorting"

                                        
                                        required
                                        prepend-inner-icon="fa fa-user">
                                    </v-select>
                                </v-flex>
                                <v-flex sm7>
                                </v-flex>
                                <v-spacer></v-spacer>
                                <v-flex sm3>
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
                                :items="spareparts"
                                
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
            headers: [
                { text: 'Id Transaksi', align: 'center', value: 'id_transaction' },
                { text: 'Tanggal', align: 'center', value: 'date_transaction' },
                { text: 'Pelanggan', align: 'center', value: 'name_customer' },
                { text: 'Status', align: 'center', value: 'status_process' },
                { text: 'Actions', align: 'center', sortable: false }
            ],
            transactionData:[],
            search:{
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

            datacount:0,
            page: 0,
            start: 0,
            end: 0,
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
            //             if(this.search != null) return sparepart.name.toLowerCase().includes(this.search.toLowerCase());
            //             if(index >= this.start && index < this.end) return true;
            //         });
            //     }
            // },
            pages () {
                return this.pagination.rowsPerPage ? Math.ceil(this.spareparts.length / this.pagination.rowsPerPage) : 0
            },

        //INIT===============================
            inittransaction () {
                this.transactionData = this.transactions;
                
                return this.transactionData
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
                            
                            if(this.customers[i].motorcycle.data[j].plate == this.search.platenumber
                                && this.customers[i].motorcycle.data[j].customer.phone_number == this.search.handphone)
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
                    this.search.totaltransaksi = this.transactionData.length
                    
                    console.log(this.search.totaltransaksi)
                }
                else{
                    // console.log("masuk")
                    this.showAlert('error','Data Tidak Ditemukan !')
                }
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
