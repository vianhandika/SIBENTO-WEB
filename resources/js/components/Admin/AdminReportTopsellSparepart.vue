<template>
    <div>
        <v-toolbar flat color="white">

          <v-toolbar-title>Report Penjualan Sparepart Terlaris</v-toolbar-title>
          <v-divider
              class="mx-2"
              inset
              vertical
          ></v-divider>
          
          <!-- dialog box add/edit -->
          <v-dialog v-model="dialog" max-width="500px">
              <template v-slot:activator="{ on }">
                <v-menu
                  ref="menu"
                  :close-on-content-click="false"
                  v-model="menu"
                  :nudge-right="40"
                  lazy
                  transition="scale-transition"
                  offset-y
                  full-width
                  min-width="290px"
                >
                  <v-text-field
                    class="ml-3"
                    slot="activator"
                    v-model="year"
                    label="Tahun"
                    readonly
                  ></v-text-field>
                  <v-date-picker
                    ref="picker"
                    v-model="date"
                    reactive
                    no-title
                    @input="save"
                    min = "2016-01-01"
                    :max = todayDate
                    
                  ></v-date-picker>
                </v-menu>
                <!-- <v-btn color="primary" dark class="mb-2" @click="getProfitPerMonth">Lihat</v-btn> -->
                 <v-btn color="primary" dark class="mb-2" @click="print">Cetak</v-btn>
              </template>
          </v-dialog>
        </v-toolbar>
      
        <!-- Tabel -->
        
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
        <v-layout >
          <v-flex xs7>
            <v-data-table
            style=" border-right: 3px solid black;"
            :headers="headers"
            :items="report"
            :search="search"
            hide-actions
            
            class="elevation-1">

            <template v-slot:items="props">
                <td>{{ props.index+1 }}</td>
                <td class="text-xs-left">{{ props.item.Bulan }}</td>
                <td class="text-xs-left">{{ props.item.NamaBarang }}</td>
                <td class="text-xs-left">{{ props.item.TipeBarang }}</td>
                <td class="text-xs-right">{{ props.item.JumlahPenjualan }}</td>

            </template>
            
            <!-- <template v-slot:footer>
              
              <td :colspan="headers[0].length" >
                  
              </td>
              <td :colspan="headers[1].length" >
                  
              </td>
              <td :colspan="headers[2].length" >
                  
              </td>
              <td :colspan="headers[3].length" class="text-xs-right">
                  <h4>TOTAL :</h4>
              </td> 
              <td :colspan="headers[4].length" class="text-xs-right">
                  <h4>Rp. {{total}}</h4>
              </td> 
            </template> -->

            </v-data-table>
 
          </v-flex>
          <v-flex xs5 class="white pl-5 pr-5" height="100%" >
            <!-- <h2>Grafik Diagram</h2>
            <canvas
              
              ref="chart"
              width="100%"
              height="70"
            /> -->
          </v-flex>
        </v-layout>  
       
        <!-- Alert -->
        <v-snackbar right bottom :color="alert.type"  value="true" v-if="alert.type">
          <v-icon>{{alert.icon}}</v-icon>{{alert.message}}
        </v-snackbar>
    </div>
</template>


<script>
  import Controller from '../../httpController'
  import { mapState, mapActions } from 'vuex'
  import serviceReport from '../../service/Report'
  import Chart from 'chart.js'

  import { required, maxLength, numeric } from 'vuelidate/lib/validators'


  export default {
    validations: {
 
    },

    data: () => ({
      
      dialog: false,
      delDialog: false,
      search: '',
      i:0,
      headers: [
        { text: 'No', align: 'left',sortable: false},
        { text: 'Bulan', align: 'center', value: 'Bulan' ,sortable: false},
        { text: 'Nama Barang', align: 'center', value: 'NamaBarang' ,sortable: false},
        { text: 'Tipe Barang', align: 'center',value: 'TipeBarang', sortable: false },
        { text: 'Jumlah Penjualan', align: 'center',value: 'JumlahPenjualan', sortable: false }

      ],
      total:0,
      year:new Date().getFullYear(),
      todayDate:new Date().toISOString().slice(0,10),
      date: null,
      menu: false,
      report:[],

      chart: null,
      stats: [],

      alert:{
        type: null,
        message: null,
        icon: null,
      }
      // elapse: null
    }),

    computed: {
 
      ...mapState({
        loading: state => state.Report.loading,
        error: state => state.Report.error,
        reports: state => state.Report.reports,

      }),
      chartData () {
      const labels = this.reports.map(item => item.Bulan)
      const servicesData = this.reports.map(item => item.Service)
      const sparepartsData = this.reports.map(item => item.Sparepart)
      const total = this.reports.map(item => item.Total)

      return {
        labels,
        datasets: [
          {
            label: 'Jasa Servis',
            data: servicesData,
            backgroundColor: '#AED581',
            borderColor: '#689F38',
          },
          {
            label: 'Sparepart',
            data: sparepartsData,
            backgroundColor: '#CF000F',
            borderColor: '#D91E18',
          },
          {
            label: 'Total',
            data: total,
            backgroundColor: '#3498DB',
            borderColor: '#4D05E8',
          },
        ],
      }
    }

    },

    watch: {
      dialog (val) {
        val || this.close()
      },
      menu (val) {
        val && this.$nextTick(() => (this.$refs.picker.activePicker = 'YEAR'))
      }

    },

    created () {
    },
    mounted(){
      this.getDataReport()
    },

    methods: {
      initialize () {

      },
      
      ...mapActions({
          getReport: 'Report/sparepartTopSell',

          
      }),

      async save (date) {
        this.$refs.menu.save(date);
        this.$refs.picker.activePicker = 'YEAR'
        this.menu = false;
        var name = this.date;
        var word = name.split('-');
        this.year=word[0]
        await this.getDataReport()

      },

      initChart () {
        const chart = this.$refs.chart.getContext('2d')

        this.chart = new Chart(chart, {
          type: 'bar',
          data: this.chartData,
        })
      },
      
      async getDataReport(){
           try {
            console.log(this.year);

            // this.report = Controller.getprofitpermonth(this.year)
            await this.getReport(this.year)
            this.report = this.reports
            // var i =0;
            // this.total = 0
            // for(let data in this.reports)
            // {
            //   this.total += this.reports[i].Total
            //   i++
            // }
            // i = 0
            // this.total = this.editedItem.detail.data.stream().mapToInt(obj => obj.subtotal).sum();
            // this.total = this.editedItem.detail.id_supplier
            //  this.initChart()


            console.log(this.report);

         
        } catch (err) {
            console.log(err)
            this.showAlert('error','Failed Get Report')
        }

      },

      print(){
          window.open(`/api/report/topsell-sparepart-pdf/${this.year}`, '_blank')

          
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
