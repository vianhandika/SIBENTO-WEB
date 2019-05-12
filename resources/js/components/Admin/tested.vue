 <template>
    <div>
    <v-card-text>
        <v-data-table
        :headers="sparepartheaders"
        :rows-per-page-items="[3]"
        :items="editedItem.sparepart.data">

            <template v-slot:items="props">
                <td v-if="editedItem.sparepart.data[sparepartIndex] != props.item  || addsparepart ">{{ props.item.brand_sparepart}}</td>
                <td v-else> 
                    <v-select 
                        v-model="editedSparepart.brand_sparepart"
                        :items="initbrandsparepart"             
                        item-text="name"
                        item-value="name"
                        label="Merk"
                    
                        required>
                    </v-select>
                </td>   
                
                <td class="text-xs-center" v-if="editedItem.sparepart.data[sparepartIndex] != props.item  || addsparepart ">{{ props.item.name_sparepart }}</td>
                <td v-else> 
                    <v-select 
                        v-model="editedSparepart.id_sparepart"
                        :items="initsparepart"             
                        item-text="name"
                        item-value="id"
                        label="Sparepart"
                    
                        required>
                    </v-select>
                </td>    

                <td class="text-xs-center" >{{ props.item.price_transaction_sparepart }}</td> 

                <td class="text-xs-center"  v-if="editedItem.sparepart.data[sparepartIndex] != props.item|| addsparepart">{{ props.item.amount_transaction_sparepart }}</td>
                <td v-else>
                    <v-text-field
                        v-model="editedSparepart.amount_transaction_sparepart"
                        label="Jumlah"
            
                        required>
                    </v-text-field>
                </td>

                <td class="text-xs-center"  v-if="editedItem.sparepart.data[sparepartIndex] != props.item|| addsparepart">{{ props.item.plate_number }}</td>
                <td v-else>
                    <v-select 
                        v-model="editedSparepart.id_motorcycle"
                        :items="initmotorcustomer"             
                        item-text="plate"
                        item-value="id"
                        label="Motor"
                    
                        required>
                    </v-select>
                </td>

                <td class="text-xs-center"  v-if="editedItem.sparepart.data[sparepartIndex] != props.item|| addsparepart">{{ props.item.mechanic_name }}</td>
                <td v-else>
                    <v-select 
                        v-model="editedSparepart.id_mechanic"
                        :items="initmechanic"               
                        item-text="name"
                        item-value="id"
                        label="Montir"
                    
                        required>
                    </v-select> 
                </td>

                <td class="text-xs-center">{{ props.item.subtotal_transaction_sparepart }}</td>
                
                <td class="justify-center layout px-0">
                    <v-icon v-if="editedItem.sparepart.data[sparepartIndex] != props.item || addsparepart"
                        small
                        
                        class="mr-2"
                        @click="sparepartEdit(props.item)"
                    >
                        edit
                    </v-icon>
                    <v-icon v-else
                        small
                        class="mr-2"
                        @click="sparepartDone()"
                    >
                        done
                    </v-icon>
                    <v-icon v-if="editedItem.sparepart.data[sparepartIndex] != props.item || addsparepart"
                        small
                        
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
                <td :colspan="sparepartheaders.length" v-if="addsparepart">
                    <v-form class="mt-2">
                        <v-layout>
                            <v-flex sm2> 
                                <v-select 
                                    v-model="editedSparepart.brand_sparepart"
                                    :items="initbrandsparepart"             
                                    item-text="name"
                                    item-value="name"
                                    label="Merk"
                                
                                    required>
                                </v-select>
                            </v-flex>
                            <v-flex sm2>
                                <v-select 
                                    v-model="editedSparepart.id_sparepart"
                                    :items="initsparepart"             
                                    item-text="name"
                                    item-value="id"
                                    label="Sparepart"
                                
                                    required>
                                </v-select>
                            </v-flex>
                            <v-flex sm2>
                                <v-text-field
                                    v-model="editedSparepart.amount_transaction_sparepart"
                                    label="Jumlah"
                        
                                    required>
                                </v-text-field>
                            </v-flex>
                            <v-flex sm2>
                                <v-select 
                                    v-model="editedSparepart.id_motorcycle"
                                    :items="initmotorcustomer"             
                                    item-text="plate"
                                    item-value="id"
                                    label="Motor"
                                
                                    required>
                                </v-select>
                            </v-flex>
                            <v-flex sm2>
                                <v-select 
                                    v-model="editedSparepart.id_mechanic"
                                    :items="initmechanic"               
                                    item-text="name"
                                    item-value="id"
                                    label="Montir"
                                
                                    required>
                                </v-select> 
                            </v-flex>
                            <v-flex  sm2 class="justify-center layout px-0">
                                <v-icon v-if="!addsparepart"
                                    small
                                    class="mr-2"
                                    @click="addsparepart=true"
                                    
                                >
                                    add
                                </v-icon>
                                <v-icon v-if="addsparepart"
                                    small
                                    class="mr-2"
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
                            </v-flex>

                        </v-layout>
                    </v-form>
                </td>
                <!-- <td :colspan="sparepartheaders[0].length">
                    <v-select v-if="addsparepart"
                        v-model="editedSparepart.id_sparepart"
                        :items="initsparepart"             
                        item-text="name_sparepart"
                        item-value="id_sparepart"
                        label="Jasa Sparepart"
                    
                        required>
                    </v-select>
                </td>
                <td :colspan="sparepartheaders[1].length">
                    <v-select v-if="addsparepart"
                        v-model="editedSparepart.id_motorcycle"
                        :items="initmotorcustomer"             
                        item-text="plate"
                        item-value="id"
                        label="Motor"
                    
                        required>
                    </v-select>
                </td>
                <td :colspan="sparepartheaders[2].length"> 
                    <v-select v-if="addsparepart"
                        v-model="editedSparepart.id_mechanic"
                        :items="initmechanic"               
                        item-text="name"
                        item-value="id"
                        label="Montir"
                    
                        required>
                    </v-select> 
                </td>
                <td :colspan="sparepartheaders[3].length"> 
                    
                </td >
                <td :colspan="sparepartheaders[4].length" class="justify-center layout px-0">
                    <v-icon v-if="!addsparepart"
                        small
                        class="mr-2"
                        @click="addsparepart=true"
                        
                    >
                        add
                    </v-icon>
                    <v-icon v-if="addsparepart"
                        small
                        class="mr-2"
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
                </td>        -->
            </template>
        </v-data-table>  
    </v-card-text>
    </div>
</template>

<script>
export default {
    data: () => ({
        spareparteaders: [
        { text: 'Merk', align: 'center', value: 'brand_sparepart', sortable: false },
        { text: 'Sparepart', align: 'left', value: 'name_sparepart' },
        { text: 'Harga Satuan', align: 'center', value: 'price_transaction_sparepart', sortable: false },
        { text: 'Jumlah', align: 'center', value: 'amount_transaction_sparepart', sortable: false },
        { text: 'Motor Pelanggan', align: 'center', value: 'amount_transaction_sparepart', sortable: false },
        { text: 'Montir', align: 'center', value: 'mechanic_name', sortable: false },
        { text: 'Subtotal', align: 'center', value: 'subtotal_transaction_sparepart', sortable: false },
        { text: 'Actions', align: 'center', sortable: false },

      ],
         //Sparepart VAR=================
      addsparepart: false,    
      dropdown_sparepart: [],
      sparepartData:[],
      sparepartIndex:-1,

      selectedSparepart:{
        id_detail_sparepart:'',
        amount_transaction_sparepart: '',
        price_transaction_sparepart:'',
        subtotal_transaction_sparepart: '',
        plate_number:'',
        mechanic_name:'',
        id_sparepart:'',
        id_motorcycle:'',
        name_sparepart:'',
        brand_sparepart:'',
        id_transaction:'',
      },
      editedSparepart:{
        id_detail_sparepart:'',
        amount_transaction_sparepart: '',
        price_transaction_sparepart:'',
        subtotal_transaction_sparepart: '',
        plate_number:'',
        mechanic_name:'',
        id_sparepart:'',
        id_motorcycle:'',
        name_sparepart:'',
        brand_sparepart:'',
        id_transaction:'',
      },
      addedSparepart:{
        id_detail_sparepart:'',
        amount_transaction_sparepart: '',
        price_transaction_sparepart:'',
        subtotal_transaction_sparepart: '',
        plate_number:'',
        mechanic_name:'',
        id_sparepart:'',
        id_motorcycle:'',
        name_sparepart:'',
        brand_sparepart:'',
        id_transaction:'',
      },
      defaultSparepart:{
        id_detail_sparepart:'',
        amount_transaction_sparepart: '',
        price_transaction_sparepart:'',
        subtotal_transaction_sparepart: '',
        plate_number:'',
        mechanic_name:'',
        id_sparepart:'',
        id_motorcycle:'',
        name_sparepart:'',
        brand_sparepart:'',
        id_transaction:'',
      },
    //==========================
    }),

    methods:{
    //SPAREPART=================================
        sparepartDelete (item) {
            // this.editedItem = item
            // this.deletesparepart()
            this.editedItem.sparepart.data = this.editedItem.sparepart.data.filter(obj=>obj.id_detail_sparepart!= item.id_detail_sparepart)
        },

        sparepartEdit (item) {
            this.addsparepart =false
            this.editedSparepart = item
            this.selectedSparepart = item
            console.log(item)
            this.sparepartIndex = this.editedItem.sparepart.data.indexOf(item)
        },

        sparepartDone () {
            this.addsparepart =false
            this.editedSparepart.amount_transaction_sparepart = 1
            this.editedSparepart.price_transaction_sparepart = this.spareparts.find(obj => obj.id_sparepart == this.editedSparepart.id_sparepart).price_sparepart
            this.editedSparepart.subtotal_transaction_sparepart = this.editedSparepart.amount_transaction_sparepart * this.editedSparepart.price_transaction_sparepart
            this.editedSparepart.name_sparepart = this.spareparts.find(obj => obj.id_sparepart == this.editedSparepart.id_sparepart).name_sparepart
            this.editedSparepart.plate_number = this.motorcustomers.find(obj => obj.id == this.editedSparepart.id_motorcycle).plate
            this.editedSparepart.mechanic_name = this.employees.find(obj => obj.id == this.editedSparepart.id_mechanic).name
            this.editedItem.sparepart.data[this.sparepartIndex] =  this.editedSparepart
            this.selectedSparepart = this.defaultSparepart
            this.editedSparepart = this.defaultSparepart
            this.sparepartIndex = -1
            
        },

        sparepartEditClose(){
            this.editedSparepart = Object.assign({},this.defaultSparepart)
            this.selectedSparepart = Object.assign({},this.defaultSparepart)
            // this.editedSparepart = Object.assign({},this.defaultSparepart)
            this.sparepartIndex = -1
        },

        sparepartAdd(){
            this.addsparepart =false

            this.editedSparepart.amount_transaction_sparepart = 1
            this.editedSparepart.price_transaction_sparepart = this.spareparts.find(obj => obj.id_sparepart == this.editedSparepart.id_sparepart).price_sparepart
            this.editedSparepart.subtotal_transaction_sparepart = this.editedSparepart.amount_transaction_sparepart * this.editedSparepart.price_transaction_sparepart
            this.editedSparepart.name_sparepart = this.spareparts.find(obj => obj.id_sparepart == this.editedSparepart.id_sparepart).name_sparepart
            this.editedSparepart.plate_number = this.motorcustomers.find(obj => obj.id == this.editedSparepart.id_motorcycle).plate
            this.editedSparepart.mechanic_name = this.employees.find(obj => obj.id == this.editedSparepart.id_mechanic).name
            

            this.editedItem.sparepart.data.push(this.editedSparepart)
            this.editedSparepart = Object.assign({},this.defaultSparepart)
            this.selectedSparepart = Object.assign({},this.defaultSparepart)
            // for(let data in this.editedItem.detail.data)
            // {
            //   this.total += this.editedItem.detail.data[this.i].subtotal
            //   this.i++
            // }
            // this.i = 0
            // this.total = this.editedItem.detail.data.mapToInt(obj => obj.subtotal).sum();
            this.sparepartIndex = -1

        },

        sparepartAddClose(){
            this.addsparepart = false
            this.editedSparepart = Object.assign({},this.defaultSparepart)
            this.selectedSparepart = Object.assign({},this.defaultSparepart)
            this.sparepartIndex = -1
        },

      //========================================
    }
}
</script>                
                        