<template>
    <div>
        <v-toolbar flat color="white">

          <v-toolbar-title>MANAJEMEN SPAREPART</v-toolbar-title>
          <v-divider
              class="mx-2"
              inset
              vertical
          ></v-divider>

          <!-- dialog box add/edit -->
          <v-dialog v-model="dialog" max-width="600px">
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
                      <v-flex xs12 style="text-align:center;">
                        <!-- <div style="background-color: #CFD8DC;height:200px;"> 
                          <img height="200px" src="" >
                          
                        </div> -->
                        <v-card flat color="#CFD8DC">
                          <v-img contain height="200px" :src="this.imageUrl" v-if="this.imageUrl"></v-img>
                          <v-img contain height="200px" :src="this.editedItem.image" v-else-if="this.editedItem.image !='-'"></v-img>
                          <v-img contain height="200px" :src="this.defaultImg" v-else></v-img>

                        </v-card>
                        
                        <v-btn small
                          color="primary"
                          class="white--text"
                          @click="pickFile" >
                          Upload Image
                          <v-icon right dark>cloud_upload</v-icon>
                        </v-btn>

                        <input
                          type="file"
                          style="display: none"
                          ref="image"
                          accept="image/*"
                          @change="onFilePicked"
                        >
                        <!-- <v-text-field label="Pilih Gambar" class="pa-1" @click='pickFile' v-model='imageUrl' @input="this.editedItem.image.$touch()"/> -->

                   
                      </v-flex>
                      <v-flex xs12 sm6 md8>
                        <v-text-field 
                          v-model="editedItem.id" 
                          label="Kode Sparepart"
                          hint="ex: 1234-AB1-1234"
                          :counter="13"
                          :error-messages="idErrors"
                          :disabled="this.editedIndex!=-1"
                          required
                          return-masked-value
                          mask="####-NNN-####"
                          @input="$v.editedItem.id.$touch()"
                          @blur="$v.editedItem.id.$touch()"
                          prepend-inner-icon="fas fa-key">
                        </v-text-field>
                      </v-flex>
                      <v-flex xs12>
                        <v-text-field 
                          v-model="editedItem.name" 
                          label="Nama Sparepart" 
                          :counter="25"
                          :error-messages="nameErrors"
                          required
                          @input="$v.editedItem.name.$touch()"
                          @blur="$v.editedItem.name.$touch()"
                          prepend-inner-icon="fas fa-box-open">
                        </v-text-field>
                      </v-flex>
                      <v-flex xs12 sm6 md6>
                        <v-text-field 
                          v-model="editedItem.brand" 
                          label="Merk"
                          :counter="25"
                          :error-messages="brandErrors"
                          required
                          @input="$v.editedItem.brand.$touch()"
                          @blur="$v.editedItem.brand.$touch()">
                        </v-text-field>
                      </v-flex>
                      <v-flex xs12 sm6 md6>
                        <v-select
                          v-model="editedItem.type"
                          :items="dropdown_type"
                          :error-messages="typeErrors"
                          item-text="name"
                          item-value="name"
                          label="Tipe"
                          required
                          @change="$v.editedItem.type.$touch()"
                          @blur="$v.editedItem.type.$touch()">
                        </v-select>
                      </v-flex>
                      <v-flex xs12 sm6 md6>
                        <v-text-field 
                          v-model="editedItem.buy_price" 
                          :error-messages="buyErrors"
                          required
                          label="Harga Beli (Rp)" 
                          @input="$v.editedItem.buy_price.$touch()"
                          @blur="$v.editedItem.buy_price.$touch()"
                          prepend-inner-icon="fas fa-coins">
                        </v-text-field>
                      </v-flex>
                      <v-flex xs12 sm6 md6>
                        <v-text-field 
                          v-model="editedItem.sell_price" 
                          :error-messages="sellErrors"
                          required
                          label="Harga Jual (Rp)" 
                          @input="$v.editedItem.sell_price.$touch()"
                          @blur="$v.editedItem.sell_price.$touch()"
                          prepend-inner-icon="fas fa-coins">
                        </v-text-field>
                      </v-flex>
                      <!-- <v-flex xs12>
                        <v-text-field 
                          v-model="this.editedItem.placement" 
                          :error-messages="placementErrors"
                          required
                          label="Tempat Penyimpanan" 
                          :counter="12"
                          return-masked-value
                          mask="AAA-AAA-####"
                          hint="ex: DPN-BAN-1"
                          @input="$v.editedItem.placement.$touch()"
                          @blur="$v.editedItem.placement.$touch()"
                          prepend-inner-icon="fas fa-archive">
                        </v-text-field>
                      </v-flex> -->
                      <v-flex xs12 sm5 md5>
                        <v-select
                          v-model="editedItem.placement_position"
                          :items="dropdown_position"
                          :error-messages="positionErrors"                          
                          item-text="name"
                          item-value="id"
                          label="Posisi"
                          required
                          @change="$v.editedItem.placement_position.$touch()"
                          @blur="$v.editedItem.placement_position.$touch()"
                          prepend-inner-icon="fas fa-archive">
                        </v-select>
                      </v-flex>
                      <v-flex xs12 sm5 md5>
                        <v-select
                          v-model="editedItem.placement_place"
                          :items="dropdown_place"
                          :error-messages="placeErrors"
                          item-text="name"
                          item-value="id"
                          label="Tempat"
                          required
                          @change="$v.editedItem.placement_place.$touch()"
                          @blur="$v.editedItem.placement_place.$touch()">
                        </v-select>
                      </v-flex>
                       <v-flex xs12 sm2 md2>
                        <v-text-field 
                          v-model="editedItem.placement_number" 
                          :error-messages="numberErrors"
                          required
                          label="Nomor" 
                          @input="$v.editedItem.placement_number.$touch()"
                          @blur="$v.editedItem.placement_number.$touch()">
                        </v-text-field>
                      </v-flex>
                      <v-flex xs12 sm4 md4>
                        <v-text-field 
                          v-model="editedItem.min_stock" 
                          :error-messages="minStockErrors"
                          required
                          label="Minimal Stok" 
                          @input="$v.editedItem.min_stock.$touch()"
                          @blur="$v.editedItem.min_stock.$touch()">
                        </v-text-field>
                      </v-flex>
                      <v-flex xs12 sm4 md4>
                        <v-text-field 
                          v-model="editedItem.stock" 
                          :error-messages="stockErrors"
                          required
                          label="Stok" 
                          @input="$v.editedItem.stock.$touch()"
                          @blur="$v.editedItem.stock.$touch()">
                        </v-text-field>
                      </v-flex>
                  </v-layout>
                  </v-container>
              </v-card-text>

              <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="blue darken-1" flat @click="close">Batal</v-btn>
                  <v-btn v-if="editedIndex!=-1" color="blue darken-1" flat @click="updatesparepart()">Simpan</v-btn>
                  <v-btn v-else color="blue darken-1" :disabled="$v.editedItem.$invalid" flat @click="addsparepart()">Tambah</v-btn>
              </v-card-actions>
              
              </v-card>
          </v-dialog>

          <!-- dialog box delete -->
          <v-dialog v-model="delDialog" max-width="500px">
            <v-card>
              <v-card-title>
                <span class="headline">Hapus Sparepart</span>
              </v-card-title>
              <v-card-text>
                <h3 class="text-sm-center">Apakah Anda yakin akan menghapus data ini ?</h3>
              </v-card-text>
              <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="blue darken-1" flat @click="deletesparepart()">Ya</v-btn>
                  <v-btn color="blue darken-1" flat @click="close">Tidak</v-btn>
                  <v-spacer></v-spacer>

                
              </v-card-actions>
            </v-card>
          </v-dialog>

          <!-- dialog box compatibility -->
          <v-dialog v-model="compatibilityDialog" max-width="1000px">
              <v-card>
                <v-card-title>
                    <span class="headline">Kecocokan Motor</span>
                </v-card-title>

                <v-card-text>
                    <v-container grid-list-md>
                    <v-layout wrap>

                      <v-flex xs12 sm3 md3
                       v-for="tipe in motortypes"
                       :key="tipe.id">
                        <v-checkbox v-model="compatibility" :label="tipe.brand.name+' '+tipe.name" :value="tipe.id"></v-checkbox>
                      </v-flex>
                      

                    </v-layout>
                    </v-container>
                </v-card-text>

                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" flat @click="close">Batal</v-btn>
                    <v-btn color="blue darken-1" flat @click="updatecompatibility()">Simpan</v-btn>
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
          :items="initsparepart"
          :search="search"
          class="elevation-1">

          <template v-slot:items="props">
              <td>{{ props.index+1 }}</td>
              <td class="text-xs-left">{{ props.item.id }}</td>
              <td class="text-xs-left">{{ props.item.name }}</td>
              <td class="text-xs-left">{{ props.item.brand }}</td>
              <td class="text-xs-left">{{ props.item.min_stock }}</td>
              <td class="text-xs-left">{{ props.item.stock }}</td>
              <td class="text-xs-center">
                  <v-btn depressed small color="grey" dark 
                    style="text-transform:none !important;"
                    @click="showCompatibility(props.item)">
                    Lihat
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
  import sparepartService from '../../service/Sparepart'
  import serviceMotorType from '../../service/MotorType'
  import { required, maxLength,minLength, numeric } from 'vuelidate/lib/validators'


  export default {
    validations: {
       editedItem: {
        id: { required, maxLength: maxLength(13),minLength: minLength(10)},
        name: { required, maxLength: maxLength(25)},
        brand: { required, maxLength: maxLength(25) },
        type: { required },
        stock: { required, numeric },
        min_stock: { required, numeric},
        buy_price: { required, numeric },
        sell_price: { required, numeric},
        // placement: { required, maxLength: maxLength(12),minLength: minLength(9) },
        placement_position: {required},
        placement_place: {required},
        placement_number: {required,numeric}
        // image: { required, maxLength: maxLength(25)},
       },   
    },

    data: () => ({
      
      dialog: false,
      delDialog: false,
      compatibilityDialog:false,
      search: '',
      test:'',
      i:0,
      headers: [
        { text: 'No', align: 'left',sortable: false},
        { text: 'Kode', align: 'left', value: 'id'},
        { text: 'Nama Sparepart', align: 'center', value: 'name' },
        { text: 'Merk', align: 'center', value: 'brand' },
        { text: 'Minimal Stok', align: 'center', value: 'min_stock', sortable: false },
        { text: 'Stok', align: 'center', value: 'stock' },
        { text: 'Kecocokan', align: 'center',  sortable: false},
        { text: 'Actions', align: 'center',value: 'name', sortable: false }
      ],
      dropdown_type:[],
      dropdown_position: [
        { id: "DPN", name: 'Depan' },
        { id: "TGH", name: 'Tengah' },
        { id: "BLK", name: 'Belakang' }
      ],
      dropdown_place: [
        { id: "KACA", name: 'Rak Kaca' },
        { id: "BAN", name: 'Tumpukan Ban' },
        { id: "DUS", name: 'Tumpukan Dus' },
        { id: "KAYU", name: 'Lemari Kayu' }
      ],
      imageUrl:'',
      imageName:'',
      defaultImg: 'http://localhost:8000/images/sparepart/default.png',
      sparepartData: [],
      compatibility:[],
      editedIndex: -1,
      editedItem: {
        id:'',
        name: '',
        brand: '',
        type:'',
        stock: '',
        min_stock: '',
        buy_price:'',
        sell_price: '',
        placement: '',
        placement_position:'',
        placement_place:'',
        placement_number:'',
        image: '-',
      },
      defaultItem: {
        id:'',
        name: '',
        brand: '',
        type:'',
        stock: '',
        min_stock: '',
        buy_price:'',
        sell_price: '',
        placement: '',
        placement_position:'',
        placement_place:'',
        placement_number:'',
        image: '-',
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
        return this.editedIndex === -1 ? 'Tambah Sparepart' : 'Edit Sparepart'
      },
      ...mapState({
        loading: state => state.Sparepart.loading,
        error: state => state.Sparepart.error,
        spareparts: state => state.Sparepart.spareparts,
        motortypes: state => state.MotorType.motortypes,

      }),
      initsparepart () {
        this.sparepartData = this.spareparts
        return this.sparepartData
      },
      setplacement(){
        this.editedItem.placement = this.editedItem.placement_position+ '-'+ this.editedItem.placement_place + '-'+ this.editedItem.placement_number
        return this.editedItem.placement
      },

    //VALIDATION ERROR
      idErrors () {
        const errors = []
        if (!this.$v.editedItem.id.$dirty) return errors
        !this.$v.editedItem.id.maxLength && errors.push('Kode sparepart tidak boleh melebihi 30 karakter')
        !this.$v.editedItem.id.minLength && errors.push('Minimal 10 karakter ex: 1234-AB1-1234')        
        
        !this.$v.editedItem.id.required && errors.push('Kode sparepart diperlukan.')
        return errors
      },
       nameErrors () {
        const errors = []
        if (!this.$v.editedItem.name.$dirty) return errors
        !this.$v.editedItem.name.maxLength && errors.push('Nama sparepart tidak boleh melebihi 25 karakter')
        !this.$v.editedItem.name.required && errors.push('Nama sparepart diperlukan.')
        return errors
      },
      brandErrors () {
        const errors = []
        if (!this.$v.editedItem.brand.$dirty) return errors
        !this.$v.editedItem.brand.maxLength && errors.push('Merk tidak boleh melebihi 25 karakter')        
        !this.$v.editedItem.brand.required && errors.push('Merk diperlukan.')
        return errors
      },
      typeErrors () {
        const errors = []
        if (!this.$v.editedItem.type.$dirty) return errors
        !this.$v.editedItem.type.required && errors.push('Tipe diperlukan.')
        return errors
      },
      stockErrors () {
        const errors = []
        if (!this.$v.editedItem.stock.$dirty) return errors
        !this.$v.editedItem.stock.numeric && errors.push('Stok harus numerik')        
        !this.$v.editedItem.stock.required && errors.push('Stok diperlukan.')
        return errors
      },
      minStockErrors () {
        const errors = []
        if (!this.$v.editedItem.min_stock.$dirty) return errors
        !this.$v.editedItem.min_stock.numeric && errors.push('Minimal stok harus numerik')        
        !this.$v.editedItem.min_stock.required && errors.push('Minimal stok diperlukan.')
        return errors
      },
      buyErrors () {
        const errors = []
        if (!this.$v.editedItem.buy_price.$dirty) return errors
        !this.$v.editedItem.buy_price.numeric && errors.push('Harga beli harus numerik')        
        !this.$v.editedItem.buy_price.required && errors.push('Harga beli diperlukan.')
        return errors
      },
      sellErrors () {
        const errors = []
        if (!this.$v.editedItem.sell_price.$dirty) return errors
        !this.$v.editedItem.sell_price.numeric && errors.push('Harga jual harus numerik')        
        !this.$v.editedItem.sell_price.required && errors.push('Harga jual diperlukan.')
        return errors
      },
      placementErrors () {
        const errors = []
        if (!this.$v.editedItem.placement.$dirty) return errors
        !this.$v.editedItem.placement.maxLength && errors.push('Tempat tidak boleh melebihi 12 karakter') 
        !this.$v.editedItem.placement.minLength && errors.push('Minimal 9 karakter ex: DPN-BAN-1 ') 
        !this.$v.editedItem.placement.required && errors.push('Tempat diperlukan.')
        return errors
      },
      positionErrors () {
        const errors = []
        if (!this.$v.editedItem.placement_position.$dirty) return errors
        !this.$v.editedItem.placement_position.required && errors.push('Posisi diperlukan.')
        return errors
      },
      placeErrors () {
        const errors = []
        if (!this.$v.editedItem.placement_place.$dirty) return errors
        !this.$v.editedItem.placement_place.required && errors.push('Tempat diperlukan.')
        return errors
      },
      numberErrors () {
        const errors = []
        if (!this.$v.editedItem.placement_number.$dirty) return errors
        !this.$v.editedItem.placement_number.numeric && errors.push('Nomor harus numerik.')
        !this.$v.editedItem.placement_number.required && errors.push('Nomor diperlukan.')
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
      compatibilityDialog (val) {
        val || this.close()
      }
    },

    created () {
    },
    mounted(){
      this.getSparepart()
      this.getSparepartType()
      this.getMotorType();
    },

    methods: {
      initialize () {
          
      },
      async getSparepartType(){
        try {
            this.dropdown_type = (await Controller.getallspareparttype())
          } catch (err) {
              console.log(err)
          }
      },
      ...mapActions({
          getSparepart: 'Sparepart/get',
           getMotorType: 'MotorType/get',
          storeSparepart: 'Sparepart/store',
          deleteSparepart: 'Sparepart/delete',
          updateSparepart: 'Sparepart/update',
          updateImageSparepart: 'Sparepart/updateimage',
          
      }),
      pickFile () {
            this.$refs.image.click ()
      },

      onFilePicked (e) {
        const files = e.target.files
        if(files[0] !== undefined) {
          this.imageName = files[0].name
          if(this.imageName.lastIndexOf('.') <= 0) {
            // console.log("Masuk return")
            return
          }
          const fr = new FileReader ()
          fr.readAsDataURL(files[0])
          fr.addEventListener('load', () => {
            // console.log(fr.result)
          //  console.log("Masuk FR")

  
            this.imageUrl = fr.result

            this.editedItem.image = files[0]
          })
        } else {
          // console.log("else")
          this.imageName = ''
          this.imageUrl = ''
          // this.editedItem.image =''
        }
      },
      
      async addsparepart () {
        try {
           
            let data = new FormData();

            data.append('id_sparepart',this.editedItem.id);
            data.append('name_sparepart',this.editedItem.name);
            data.append('brand_sparepart',this.editedItem.brand);
            data.append('id_sparepart_type', this.dropdown_type.find(obj => obj.name == this.editedItem.type).id);
            data.append('stock_sparepart',this.editedItem.stock);
            data.append('minimal_stock_sparepart',this.editedItem.min_stock);
            data.append('buy_price',this.editedItem.buy_price);
            data.append('sell_price',this.editedItem.sell_price);
            data.append('placement',this.editedItem.placement_position+'-'+this.editedItem.placement_place+'-'+this.editedItem.placement_number);
            data.append('image_sparepart',this.editedItem.image);

            // for (var pair of data.entries())
            // {
            // console.log(pair[0]+ ', '+ pair[1]); 
            // }
            

            // const data={
            //     id_sparepart : this.editedItem.id,
            //     name_sparepart : this.editedItem.name,
            //     brand_sparepart : this.editedItem.brand,
            //     id_sparepart_type : this.type.find(obj => obj.name == this.editedItem.type).id,
            //     stock_sparepart : this.editedItem.stock,
            //     minimal_stock_sparepart : this.editedItem.min_stock,
            //     buy_price : this.editedItem.buy_price,
            //     sell_price : this.editedItem.sell_price,
            //     placement : this.editedItem.placement,
            //     image_sparepart : this.editedItem.image,
            // }
                
            await this.storeSparepart(data)
            this.sparepartData.push(this.editedItem)
            await this.getSparepart()
            this.close()
            this.showAlert('success','Success Add Sparepart')
        } catch (err) {
            console.log(err)
            this.showAlert('error','Failed Add Sparepart')
        }
            
      },

      async updatesparepart() {
        try {

            const data={
                id_sparepart : this.editedItem.id,
                name_sparepart : this.editedItem.name,
                brand_sparepart : this.editedItem.brand,
                id_sparepart_type : this.dropdown_type.find(obj => obj.name == this.editedItem.type).id,
                stock_sparepart : this.editedItem.stock,
                minimal_stock_sparepart : this.editedItem.min_stock,
                buy_price : this.editedItem.buy_price,
                sell_price : this.editedItem.sell_price,
                placement : this.editedItem.placement_position+'-'+this.editedItem.placement_place+'-'+this.editedItem.placement_number,
                // image_sparepart : this.editedItem.image,
            }
            // const response = await Co  ntroller.updateService(this.payload,id_service)
            await this.updateSparepart(data)
            if(this.imageUrl !=''){

              let data2 = new FormData();
              data2.append('id_sparepart',this.editedItem.id);
              data2.append('image_sparepart',this.editedItem.image);
              for (var pair of data2.entries())
              {
                console.log(pair[0]+ ', '+ pair[1]); 
              }
              await this.updateImageSparepart(data2);
            }
            // Object.assign(this.sparepartData[this.editedIndex], this.editedItem)
            await this.getSparepart()
            this.close()
            this.showAlert('success','Success Update Sparepart')

        } catch (err) {
            console.log(err)
            this.showAlert('error','Failed Update Sparepart')
        }
      },

      async deletesparepart () {
         try {
            var id_sparepart = this.sparepartData[this.editedIndex].id
            await this.deleteSparepart(id_sparepart)
            await this.getSparepart()
            this.close()
            this.showAlert('success','Success Delete Sparepart')

          } catch (err) {
              console.log(err)
            this.showAlert('error','Failed Delete Sparepart')

          }
      },

      async updatecompatibility () {
         try {
            var id_sparepart = this.sparepartData[this.editedIndex].id
            let data ={
              motorcycle_types : this.compatibility.toString()

   
            }
            //console.log(this.compatibility)
            
            await Controller.updatecompatibility(data,id_sparepart)
            await this.getSparepart()
            this.close()
            this.showAlert('success','Berhasil Mengubah Kecocokan')

          } catch (err) {
              console.log(err)
            this.showAlert('error','Gagal Mengubah Kecocokan')

          }
      },



      editItem (item) {
        this.editedIndex = this.sparepartData.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialog = true
      },

      deleteItem (item) {
        this.delDialog = true
        this.editedIndex = this.sparepartData.indexOf(item)
        // this.deleteService()
        // confirm('Are you sure you want to delete this item?') && this.sparepartData.splice(this.editedIndex, 1)
        // confirm('Are you sure you want to delete this item?') && this.deleteService()
        
      },
      showCompatibility(item){
        this.compatibilityDialog = true
        this.editedIndex = this.sparepartData.indexOf(item)

        // console.log(item)
        // console.log(item.compatibility.data)

        for(var obj in item.compatibility.data)
        {
            // console.log(obj)
            this.compatibility.push( item.compatibility.data[obj].id)

        }
        // this.compatibility = item.compatibility.data

      },
      close () {
        this.dialog = false
        this.delDialog = false
        this.compatibilityDialog = false
        this.compatibility =[]
        setTimeout(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
          this.imageUrl=''
          this.imageName=''
          this.$v.$reset()
        }, 300)
      },

      save () {
        if (this.editedIndex > -1) {
          Object.assign(this.sparepartData[this.editedIndex], this.editedItem)
        } else {
          this.sparepartData.push(this.editedItem)
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
