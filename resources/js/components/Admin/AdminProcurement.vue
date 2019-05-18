<template>
    <div>
        <v-toolbar flat color="white">

          <v-toolbar-title>MANAJEMEN PENGADAAN SPAREPART</v-toolbar-title>
          <v-divider
              class="mx-2"
              inset
              vertical
          ></v-divider>

          <!-- dialog box add/edit -->
          <v-dialog v-model="dialog" max-width="800px">
              <template v-slot:activator="{ on }">
              <v-btn color="primary" dark class="mb-2" v-on="on">Tambah</v-btn>
              </template>
              <v-card>
              <v-card-title class="theme--light">
                  <span class="headline">{{ formTitle }}</span>
              </v-card-title>

              <v-card-text>
                <v-container grid-list-md>
                  <v-layout wrap>
                    <v-flex xs12 md6 sm6>
                      <v-menu
                        v-model="dateDialog"
                        :close-on-content-click="false"
                        :nudge-right="40"
                        lazy
                        transition="scale-transition"
                        offset-y
                        full-width
                        :disabled="detailMode == true && verifMode == true"
                        min-width="290px"
                      >
                        <template v-slot:activator="{ on }">
                          <v-text-field 
                            v-model="editedItem.date_procurement"
                            label="Tanggal"
                            prepend-inner-icon="event"
                            required
                            :error-messages="dateErrors"
                            @change="$v.editedItem.date_procurement.$touch()"
                            @blur="$v.editedItem.date_procurement.$touch()"
                            readonly
                            v-on="on"
                          ></v-text-field>
                        </template>
                        <v-date-picker v-model="editedItem.date_procurement" @input="dateDialog = false"></v-date-picker>
                      </v-menu>
                    </v-flex>
                    <v-flex xs12 sm6 md6>
                     <v-select
                        v-model="editedItem.status_procurement"
                        :items="dropdown_status"
                        :error-messages="statusErrors"                          
                        item-text="text"
                        item-value="id"
                        label="Status"
                        required
                        :disabled="detailMode == true || verifMode == true"
                        @change="$v.editedItem.status_procurement.$touch()"
                        @blur="$v.editedItem.status_procurement.$touch()"
                        prepend-inner-icon="fas fa-flag">
                      </v-select>
                    </v-flex>
                    <v-flex xs12 sm6 md6>
                     <v-select
                        v-model="editedItem.id_supplier"
                        :items="initsupplier"
                        :error-messages="supplierErrors"                          
                        item-text="name"
                        item-value="id"
                        label="Supplier"
                        required
                        :disabled="detailMode == true || verifMode == true"
                        @change="$v.editedItem.id_supplier.$touch()"
                        @blur="$v.editedItem.id_supplier.$touch()"
                        prepend-inner-icon="fas fa-truck">
                      </v-select>
                    </v-flex>
                    <v-flex xs12 sm6 md6>
                      <v-select
                        v-model="editedItem.id_sales"
                        :items="initsales"
                        :error-messages="salesErrors"                          
                        item-text="name"
                        item-value="id"
                        label="Sales"
                        required
                        :disabled="detailMode == true || verifMode == true"  
                        @change="$v.editedItem.id_sales.$touch()"
                        @blur="$v.editedItem.id_sales.$touch()"
                        prepend-inner-icon="fas fa-user-tie">
                      </v-select>
                    </v-flex>
                    <v-flex xs12 sm6 md6>
                      <v-text-field
                        v-model="countTotal"
                        
                        label="Total Harga"
                        disabled
                        required
                        prepend-inner-icon="fas fa-coins"
                      ></v-text-field>
                    </v-flex>
                  </v-layout>
                </v-container>

                <v-data-table
                  :headers="sparepartheaders"
                  :items="editedItem.detail.data">

                  <template v-slot:items="props">
                    <td>{{ props.index+1}}</td>
                    <td v-if="editedItem.detail.data[sparepartIndex] != props.item  || addsparepart ">{{ props.item.name_sparepart }}</td>
                    <td v-else> 
                      <v-select
                        v-model="editedSparepart.id_sparepart"
                        :items="initsparepart"             
                        item-text="name"
                        item-value="id"
                        label="Sparepart"
                        :error-messages="sparepartErrors"
                        @change="$v.editedSparepart.id_sparepart.$touch(),getSparepartObj()"
                        @blur="$v.editedSparepart.id_sparepart.$touch()"
                        required>
                      </v-select>
                    </td>  

                    <td class="text-xs-center" v-if="editedItem.detail.data[sparepartIndex] != props.item || addsparepart">{{ props.item.amount }}</td>
                    <td v-else> 
                      <v-text-field
                        v-model="editedSparepart.amount"
                        label="Jumlah"
                        :error-messages="amountErrors"
                        @change="$v.editedSparepart.amount.$touch()"
                        @blur="$v.editedSparepart.amount.$touch()"
                        required>
                      </v-text-field>
                    </td>

                    <td class="text-xs-center" v-if="editedItem.detail.data[sparepartIndex] != props.item || addsparepart">Rp. {{ props.item.price }}</td>
                    <td v-else> 
                      <v-text-field
                        v-model="editedSparepart.price"
                        label="Harga Beli"
                        :error-messages="priceErrors"
                        @change="$v.editedSparepart.price.$touch()"
                        @blur="$v.editedSparepart.price.$touch()"
                        required>
                      </v-text-field>
                    </td>    

                    <td class="justify-center layout px-0">
                      <v-icon v-if="editedItem.detail.data[sparepartIndex] != props.item || addsparepart"
                          small
                          class="mr-2"
                          :disabled="detailMode == true"  
                          @click="sparepartEdit(props.item)"
                      >
                          edit
                      </v-icon>
                      <v-icon v-else
                          small
                          class="mr-2"
                          :disabled="$v.editedSparepart.$invalid"
                          @click="sparepartDone()"
                      >
                          done
                      </v-icon>
                      
                      <v-icon v-if="editedItem.detail.data[sparepartIndex] != props.item || addsparepart"
                          small
                          :disabled="detailMode == true"  
                          @click="sparepartDelete(props.item)"
                      >
                          delete
                      </v-icon>
                      <v-icon v-else
                          small
                          class="mr-2"
                          @click="sparepartEditClose()"   
                      >
                          close
                      </v-icon>
                    </td>

                  </template>
                  <template v-slot:footer>
                    <td :colspan="sparepartheaders[0].length">
                    </td>
                    <td :colspan="sparepartheaders[1].length">
                      <v-select v-if="addsparepart"
                          v-model="editedSparepart.id_sparepart"
                          :items="initsparepart"             
                          item-text="name"
                          item-value="id"
                          label="Sparepart"
                          :error-messages="sparepartErrors"
                          @change="$v.editedSparepart.id_sparepart.$touch(),getSparepartObj()"
                          @blur="$v.editedSparepart.id_sparepart.$touch()"                          
                          required>
                      </v-select>
                    </td>
                    <td :colspan="sparepartheaders[2].length"> 
                       <v-text-field v-if="addsparepart"
                        v-model="editedSparepart.amount"
                        label="Jumlah"
                        :error-messages="amountErrors"
                        @change="$v.editedSparepart.amount.$touch()"
                        @blur="$v.editedSparepart.amount.$touch()"
                        required>
                      </v-text-field>
                    </td>
                    <td :colspan="sparepartheaders[3].length"> 
                      <v-text-field v-if="addsparepart"
                        v-model="editedSparepart.price"
                        label="Harga Beli"
                        :error-messages="priceErrors"
                        @change="$v.editedSparepart.price.$touch()"
                        @blur="$v.editedSparepart.price.$touch()"
                        required>
                      </v-text-field>
                    </td >
                     <td :colspan="sparepartheaders[4].length" class="justify-center layout px-0">
                        <v-icon v-if="!addsparepart"
                            small
                            class="mr-2"
                            @click="addsparepart=true"
                            :disabled="detailMode == true"  
                        >
                            add
                        </v-icon>

                        <v-icon v-if="addsparepart"
                            small
                            class="mr-2"
                            :disabled="$v.editedSparepart.$invalid"
                            @click ="sparepartAdd()"
                        >
                            done
                        </v-icon>
                        <v-icon v-if="addsparepart"
                            small
                            class="mr-2"
                            @click="sparepartAddClose()"
                        >
                            close
                        </v-icon>
                      </td>       
                  </template>
                </v-data-table>  
                
                    
              </v-card-text>

              <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="blue darken-1" flat @click="close()">Batal</v-btn>
                  <v-btn v-if="verifMode == true && detailMode == false" color="blue darken-1" flat @click="verifyprocurement">Verifikasi</v-btn>
                  <v-btn v-else-if="editedIndex!=-1 && detailMode == false" color="blue darken-1" flat @click="updateprocurement">Simpan</v-btn>
                  <v-btn v-else-if="editedIndex==-1 && detailMode == false" color="blue darken-1" :disabled="$v.editedItem.$invalid" flat @click="addprocurement">Tambah</v-btn>
              </v-card-actions>
              
              </v-card>
          </v-dialog>

          <!-- dialog box delete -->
          <v-dialog v-model="delDialog" max-width="500px">
            <v-card>
              <v-card-title>
                <span class="headline">Hapus Pengadaan Sparepart</span>
              </v-card-title>
              <v-card-text>
                <h3 class="text-sm-center">Apakah Anda yakin akan menghapus data ini ?</h3>
              </v-card-text>
              <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="blue darken-1" flat @click="deleteprocurement()">Ya</v-btn>
                  <v-btn color="blue darken-1" flat @click="close()">Tidak</v-btn>
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
          v-if="initprocurement"
          :headers="headers"
          :items="initprocurement"
          :search="search"
          class="elevation-1">

          <template v-slot:items="props">
              <td>{{ props.index+1}}</td>
              <td>{{ props.item.date_procurement }}</td>
              <td class="text-xs-center">{{ props.item.name_supplier }}</td>
              <td class="text-xs-center">{{ props.item.status_procurement }}</td>
              <td class="text-xs-center">
                   <v-btn v-if="props.item.status_procurement=='Finish'"
                    depressed small color="success" dark 
                    style="text-transform:none !important;"
                    @click="detailItem(props.item)">
                    Detail
                  </v-btn>
                  <v-btn v-else
                    depressed small color="primary" dark 
                    style="text-transform:none !important;"
                    @click="verifyItem(props.item)">
                    Verif
                  </v-btn>
              </td>
              <td class="justify-center layout px-0">
              <v-icon
                  small
                  class="mr-2"
                  :disabled="props.item.status_procurement=='Finish' || props.item.status_procurement=='On Process' "  
                  @click="editItem(props.item)"
              >
                  edit
              </v-icon>
              <v-icon
                  small
                  class="mr-2"
                  @click="deleteItem(props.item)"
              >
                  delete
              </v-icon>
               <v-icon
                  small
                  :disabled="props.item.status_procurement=='Finish'"  
                  @click="printprocurement(props.item)"
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

        <!-- Alert -->
        <v-snackbar right bottom :color="alert.type"  value="true" v-if="alert.type">
          <v-icon>{{alert.icon}}</v-icon>{{alert.message}}
        </v-snackbar>
    </div>
</template>


<script>
  import Controller from '../../httpController'
  import { mapState, mapActions } from 'vuex'
  import procurementService from '../../service/Procurement'
  import sparepartService from '../../service/Sparepart'
  import supplierService from '../../service/Supplier'
  import { required, maxLength, numeric, sameAs, not} from 'vuelidate/lib/validators'

  function sparepartSameErrors () {
    var i = 0
        for(var sparepart in this.editedItem.detail.data)
        {
        
            if(this.sparepartIndex!= -1)
            {
              if(this.editedItem.detail.data[i].id_sparepart==this.editedSparepart.id_sparepart
                  && this.editedItem.detail.data[i].id_sparepart != this.editedItem.detail.data[this.sparepartIndex].id_sparepart)
              {
                return false
              }
            }
            else if(this.editedItem.detail.data[i].id_sparepart==this.editedSparepart.id_sparepart)
            {
                return false
            }
            
            i++;
        }
        return true
  }

  export default {
    validations: {
       editedItem: {
        date_procurement: { required },
        status_procurement: { required },
        id_sales: { required },
        id_supplier: { required },
       },
       editedSparepart:{
        id_sparepart:  { required,sparepartSameErrors},
        amount:  { required, numeric},
        price:  { required, numeric },

       }   
    },

    data: () => ({
      
      dialog: false,
      delDialog: false,
      dateDialog: false,
      addsparepart:false,
      verifMode:false,
      detailMode:false,
      // sparepartDialog:false,
      search: '',
      i:0,
      headers: [
        { text: 'No', align: 'left',sortable: false },
        { text: 'Tanggal', align: 'left', value: 'date_procurement' },
        { text: 'Supplier', align: 'center', value: 'name_supplier' },
        { text: 'Status', align: 'center', value: 'status_procurement' },
        { text: 'Verifikasi', align: 'center',sortable: false},
        { text: 'Actions', align: 'center', sortable: false }
      ],
      sparepartheaders: [
        { text: 'No', align: 'left',sortable: false },
        { text: 'Sparepart', align: 'left', value: 'name_sparepart',sortable: false },
        { text: 'Jumlah', align: 'center', value: 'amount', sortable: false  },
        { text: 'Harga Beli', align: 'center', value: 'price', sortable: false  },
        { text: 'Actions', align: 'center', sortable: false }
      ],
      dropdown_status: [
        { id: "Unprocessed", text: 'Unprocessed' },
        { id: "On Process", text: 'On Process' },
        { id: "Finish", text: 'Finish' }
      ],
      dropdown_supplier:[],
      dropdown_sales:[],
      dropdown_sparepart:[],
      procurementData: [],
      editedIndex: -1,
      sparepartIndex: -1,
      total:0,
      selectedProcurement: {
        name: '',
        phone_number: '',
        address: '',
      },
      editedItem: {
        date_procurement: '',
        status_procurement: 'Unprocessed',
        id_sales:'',
        id_supplier: '',
        detail:{
          data:[],
        }
      },
      defaultItem: {
        date_procurement: '',
        status_procurement: 'Unprocessed',
        id_sales:'',
        id_supplier: '',
        detail:{
          data:[],
        }
      },
      editedSparepart:{
        id_sparepart: '',
        name_sparepart:'',
        amount: '',
        price: '',
        subtotal: ''
      },
      selectedSparepart:{
        id_sparepart: '',
        name_sparepart:'',
        amount: '',
        price: '',
        subtotal: ''
      },
      defaultSparepart:{
        id_sparepart: '',
        name_sparepart:'',
        amount: '',
        price: '',
        subtotal: ''
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
        if(this.verifMode == true)
        {
          return 'Verifikasi Pengadaan Sparepart'
        }
        else if(this.editedIndex==-1)
        {
          return 'Tambah Pengadaan Sparepart'
        }
        else
        {
          return 'Edit Pengadaan Sparepart'
        }
        // return this.editedIndex === -1 ? 'Tambah Pengadaan Sparepart' : 'Edit Pengadaan Sparepart'
      },

      ...mapState({
        loading: state => state.Procurement.loading,
        error: state => state.Procurement.error,
        procurements: state => state.Procurement.procurements,
        suppliers: state => state.Supplier.suppliers,
        manySales: state => state.Sales.manySales,
        spareparts: state => state.Sparepart.spareparts,

      }),

      countTotal(){
        this.total = 0
        for(let data in this.editedItem.detail.data)
        {
          this.total += this.editedItem.detail.data[this.i].subtotal
          this.i++
        }
        this.i = 0
        // this.total = this.editedItem.detail.data.stream().mapToInt(obj => obj.subtotal).sum();
        // this.total = this.editedItem.detail.id_supplier
        return 'Rp. '+this.total
      },

      initprocurement () {
        this.procurementData = this.procurements;
        return this.procurementData
      },

      initsupplier(){
        this.dropdown_supplier = this.suppliers
        return this.dropdown_supplier
      },

      initsales(){
        if(this.editedItem.id_supplier != "")
        {
          this.dropdown_sales = this.manySales.filter(obj => obj.supplier.id == this.editedItem.id_supplier)
          return this.dropdown_sales
        }
      },

      initsparepart(){
        // this.dropdown_sparepart = this.spareparts
        this.dropdown_sparepart = this.spareparts.map(obj => ({
              id : obj.id,
              name : obj.name+' '+obj.brand
        }))
        return this.dropdown_sparepart

      },
      //VALIDATION ERROR
      dateErrors () {
        const errors = []
        if (!this.$v.editedItem.date_procurement.$dirty) return errors
        !this.$v.editedItem.date_procurement.required && errors.push('Tanggal diperlukan.')
        return errors
      },

      statusErrors () {
        const errors = []
        if (!this.$v.editedItem.status_procurement.$dirty) return errors
        !this.$v.editedItem.status_procurement.required && errors.push('Status diperlukan.')
        return errors
      },

      supplierErrors () {
        const errors = []
        if (!this.$v.editedItem.id_supplier.$dirty) return errors   
        !this.$v.editedItem.id_supplier.required && errors.push('Supplier diperlukan.')
        return errors
      },

      salesErrors () {
        const errors = []
        if (!this.$v.editedItem.id_sales.$dirty) return errors
        !this.$v.editedItem.id_sales.required && errors.push('Sales diperlukan.')
        return errors
      },
      sparepartErrors() {
        const errors = []
        if (!this.$v.editedSparepart.id_sparepart.$dirty) return errors
        !this.$v.editedSparepart.id_sparepart.required && errors.push('Sparepart diperlukan.')
        !this.$v.editedSparepart.id_sparepart.sparepartSameErrors && errors.push('Sparepart Tidak Boleh Sama.')

        return errors
      },
      amountErrors() {
        const errors = []
        if (!this.$v.editedSparepart.amount.$dirty) return errors
        !this.$v.editedSparepart.amount.required && errors.push('Jumlah diperlukan.')
        !this.$v.editedSparepart.amount.numeric && errors.push('Jumlah harus numerik.')
        !this.$v.editedSparepart.amount != 0 && errors.push('Jumlah harus lebih dari 0.')
        return errors
      },
      priceErrors() {
        const errors = []
        if (!this.$v.editedSparepart.price.$dirty) return errors
        !this.$v.editedSparepart.price.required && errors.push('Harga diperlukan.')
        !this.$v.editedSparepart.price.numeric && errors.push('Harga harus numerik.')
        return errors
      },
      // sparepartSameErrors(){
      //   var i = 0
      //   for(var sparepart in this.editedItem.detail.data)
      //   {
      //       if(this.editedItem.detail.data[i].id_sparepart==this.editedSparepart.id_sparepart)
      //       {
      //          return false
      //       }
      //       i++;
      //   }
      //   return true
      // }
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
      // this.showAlert('error','Failed Update Procurement');
      //  console.log(this.dropdown_role);
      // this.topayload()
    },
    mounted(){
      this.getProcurement()
      this.getSupplier()
      this.getSales()
      this.getSparepart()
      // this.initialize()
    },

    methods: {
      initialize () {

      },
      ...mapActions({
        getProcurement: 'Procurement/get',
        getSupplier: 'Supplier/get',
        getSales: 'Sales/get',
        getSparepart: 'Sparepart/get',
        storeProcurement: 'Procurement/store',
        deleteProcurement: 'Procurement/delete',
        updateProcurement: 'Procurement/update',
        verifySparepart: 'Sparepart/sparepartverify'

      }),
      
      filtertype(brand){
        this.dropdown_type  = this.dropdown_type.filter( obj => obj.brand.name === this.editedSparepart.brand)
        return this.dropdown_type
      },

      async addprocurement () {
        try {

          let detailPayload = this.editedItem.detail.data.map(obj => ({
              price_detail_procurement : obj.price,
              subtotal_detail_procurement : obj.subtotal,
              amount_detail_procurement : obj.amount,
              id_sparepart : obj.id_sparepart,
              
              
          }));

          // console.log(detailPayload)

          const data ={
            date_procurement: this.editedItem.date_procurement,
            status_procurement: this.editedItem.status_procurement,
            id_sales: this.editedItem.id_sales,
            id_supplier: this.editedItem.id_supplier,
            detail : detailPayload
          }
          console.log(data)
          await this.storeProcurement(data)
          this.procurementData.push(this.editedItem)
          await this.getProcurement()
          this.close()
          this.showAlert('success','Berhasil Tambah Pengadaan')
        } catch (err) {
          console.log(err)
          this.showAlert('error','Gagal Tambah Pengadaan')
        }
            
      },

      async verifyprocurement () {
        try {
          let date = this.editedItem.date_procurement.split(' ')
          let detailPayload = this.editedItem.detail.data.map(obj => ({
              price_detail_procurement : obj.price,
              subtotal_detail_procurement : obj.subtotal,
              amount_detail_procurement : obj.amount,
              id_sparepart : obj.id_sparepart,
              
          }));

          // console.log(detailPayload)
          console.log(date[0])
          const data ={
            id_procurement: this.editedItem.id_procurement,
            date_procurement: date[0],
            status_procurement: 'Finish',
            id_sales: this.editedItem.id_sales,
            id_supplier: this.editedItem.id_supplier,
            detail : detailPayload
          }
          const dataverify={
            spareparts : this.editedItem.detail.data
          }

          await this.updateProcurement(data)
          await this.verifySparepart(dataverify)
          // Object.assign(this.procurementData[this.editedIndex], this.editedItem)
          await this.getProcurement()
          this.close()
          this.showAlert('success','Success Update Procurement')

        } catch (err) {
            console.log(err)
            this.showAlert('error','Failed Update Procurement')
        }
      },
      
      async updateprocurement () {
        try {
          let date = this.editedItem.date_procurement.split(' ')
          let detailPayload = this.editedItem.detail.data.map(obj => ({
              price_detail_procurement : obj.price,
              subtotal_detail_procurement : obj.subtotal,
              amount_detail_procurement : obj.amount,
              id_sparepart : obj.id_sparepart,
              
          }));

          // console.log(detailPayload)
          console.log(date[0])
          const data ={
            id_procurement: this.editedItem.id_procurement,
            date_procurement: date[0],
            status_procurement: this.editedItem.status_procurement,
            id_sales: this.editedItem.id_sales,
            id_supplier: this.editedItem.id_supplier,
            detail : detailPayload
          }

          await this.updateProcurement(data)
          // Object.assign(this.procurementData[this.editedIndex], this.editedItem)
          await this.getProcurement()
          this.close()
          this.showAlert('success','Success Update Procurement')

        } catch (err) {
            console.log(err)
            this.showAlert('error','Failed Update Procurement')
        }
      },

      async deleteprocurement () {
         try {
            var id_procurement = this.procurementData[this.editedIndex].id_procurement
            await this.deleteProcurement(id_procurement)
            await this.getProcurement()
            this.close()
            this.showAlert('success','Success Delete Procurement')

          } catch (err) {
              console.log(err)
            this.showAlert('error','Failed Delete Procurement')

          }
      },

      async printprocurement (item) {
        try {
          window.open(`/api/generate-procurement-pdf/${item.id_procurement}`, '_blank')
          let date = item.date_procurement.split(' ')
          // console.log(detailPayload)
          // console.log(date[0])
          const data ={
            id_procurement: item.id_procurement,
            date_procurement: date[0],
            status_procurement: 'On Process',
            id_sales: item.id_sales,
            id_supplier: item.id_supplier,
       
          }
          console.log(data)
          await this.updateProcurement(data)
          // Object.assign(this.procurementData[this.editedIndex], this.editedItem)
          await this.getProcurement()
          // this.close()
          this.showAlert('success','Success Update Procurement')

        } catch (err) {
            console.log(err)
            this.showAlert('error','Failed Update Procurement')
        }
      },
     
      getSparepartObj(){
        this.editedSparepart.price = this.spareparts.find(obj=>obj.id == this.editedSparepart.id_sparepart).sell_price
        this.editedSparepart.name_sparepart = this.spareparts.find(obj=>obj.id == this.editedSparepart.id_sparepart).name
      },

      editItem (item) {
        
        this.editedIndex = this.procurements.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialog = true
      },

      verifyItem(item){
        this.verifMode = true
        this.editedIndex = this.procurements.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialog = true
      },

      detailItem(item){
        this.detailMode = true
        this.editedIndex = this.procurements.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialog = true
      },

      sparepartDelete (item) {
        this.editedItem.detail.data = this.editedItem.detail.data.filter(obj=>obj.id_sparepart!= item.id_sparepart)
      },

      sparepartEdit (item) {
    
        this.editedSparepart = Object.assign({}, item)
        this.selectedSparepart = item
        this.sparepartIndex = this.editedItem.detail.data.indexOf(item)
        this.addsparepart =false

      },

      sparepartDone () {
        this.editedSparepart.subtotal = this.editedSparepart.price *this.editedSparepart.amount
        this.editedItem.detail.data.splice(this.sparepartIndex, 1, this.editedSparepart)
        this.selectedSparepart = Object.assign({},this.defaultSparepart)
        this.editedSparepart = Object.assign({},this.defaultSparepart)
        this.addsparepart =false
        this.sparepartIndex = -1
        
      },

      sparepartEditClose(){
        this.editedSparepart = Object.assign({},this.defaultdSparepart)
        this.selectedSparepart = Object.assign({},this.defaultdSparepart)
        this.sparepartIndex = -1
      },

      sparepartAdd(){
        this.editedSparepart.name_sparepart = this.spareparts.find(obj => obj.id == this.editedSparepart.id_sparepart).name
        this.editedSparepart.subtotal = this.editedSparepart.amount * this.editedSparepart.price
        this.editedItem.detail.data.push(this.editedSparepart)
        this.editedSparepart = Object.assign({},this.defaultSparepart)
        this.selectedSparepart = Object.assign({},this.defaultSparepart)
        this.sparepartIndex = -1
        this.addsparepart =false

        this.$v.$reset()

      },

      sparepartAddClose(){
        this.editedSparepart = Object.assign({},this.defaultdSparepart)
        this.selectedSparepart = Object.assign({},this.defaultdSparepart)
        this.sparepartIndex = -1
        this.addsparepart = false

      },

      deleteItem (item) {
        // console.log(item)
        this.delDialog = true
        this.editedIndex = this.procurementData.indexOf(item)
        // console.log(this.editedIndex)

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

      save () {
        if (this.editedIndex > -1) {
          Object.assign(this.procurementData[this.editedIndex], this.editedItem)
        } else {
          this.procurementData.push(this.editedItem)
        }
        this.close()
      },
      showSparepart(item){
        this.sparepartDialog=true
        this.selectedProcurement = item
        // this.sparepartProcurement = this.sparepartData.filter(obj => obj.procurement.id == item.id);
        this.sparepartProcurement = item.sparepart.data
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
