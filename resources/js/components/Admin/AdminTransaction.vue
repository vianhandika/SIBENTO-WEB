<template>
    <div>
        <v-toolbar flat color="white">

          <v-toolbar-title>MANAJEMEN TRANSAKSI PENJUALAN</v-toolbar-title>
          <v-divider
              class="mx-2"
              inset
              vertical
          ></v-divider>

          <!-- dialog box add/edit -->
          <v-dialog v-model="dialog" fullscreen hide-overlay transition="dialog-bottom-transition" max-width="1200px">
              <template v-slot:activator="{ on }">
              <v-btn color="primary" dark class="mb-2" v-on="on">Tambah</v-btn>
              </template>
              <v-card>
                <v-toolbar dark :color="$root.themeColor">
                    <v-btn icon dark @click="dialog = false">
                        <v-icon>close</v-icon>
                    </v-btn>
                    <v-toolbar-title>{{ formTitle }}</v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-toolbar-items v-if="detailMode!=true">
                        <v-btn dark flat v-if="editedIndex!=-1" @click="updatetransaction()">Simpan</v-btn>
                        <v-btn dark flat v-else @click="addtransaction()">Tambah</v-btn>

                    </v-toolbar-items>
                </v-toolbar>
                <!-- <v-card-title class="theme--light justify-center">
                    <span class="headline">{{ formTitle }}</span>
                </v-card-title> -->
                <br>
                <hr>
               <!-- Pelanggan dan Motor -->
                <v-layout row wrap>
                 <v-card width="100%">
                    <v-layout row wrap>

                   <!-- Pelanggan -->
                    <v-flex sm3 >
                    <v-card height="100%">
                        <v-card-title class="theme--light justify-center">
                            <span class="headline">Data Pelanggan</span>
                        </v-card-title>
                        <v-card-text>
                            <v-container grid-list-md>
                            <v-layout wrap v-if="setcustomer"> 
                                
                                <v-flex xs6 v-if="editedIndex==-1"> 
                                   <v-checkbox
                                    v-model="newCustomer"
                                    label="Pelanggan Baru"
                                    @change="customerHandler()"
                                    ></v-checkbox>
                                </v-flex>
                                <v-flex xs6 v-if="editedIndex==-1 && newCustomer==true && this.editedCustomer.id==''" style="margin-top:16px;"> 
                                    <v-btn 
                                        small block color="primary"  
                                        style="text-transform:none !important;"
                                        
                                        @click="addcustomer()"
                                        :disabled="$v.editedCustomer.$invalid">
                                        Daftar
                                    </v-btn>
                                </v-flex>

                                <v-flex xs12>
                                    <v-select v-if="this.newCustomer == false "
                                        v-model="editedItem.id_customer"
                                        :items="initcustomer"             
                                        item-text="name"
                                        item-value="id"
                                        label="Nama Pelanggan"
                                        :disabled="detailMode == true"
                                        
                                        required
                                        prepend-inner-icon="fa fa-user">
                                    </v-select>
                                    <v-text-field v-else-if="this.newCustomer == true"
                                        v-model="editedCustomer.name" 
                                        label="Nama"
                                        :counter="25"
                                        :error-messages="nameErrors"
                                        @input="$v.editedCustomer.name.$touch()"
                                        @blur="$v.editedCustomer.name.$touch()"
                                        required
                                        prepend-inner-icon="fa fa-user">
                                    </v-text-field>
                                </v-flex>

                                <v-flex xs12>
                                    <v-text-field 
                                        v-model="editedCustomer.phone_number" 
                                        label="Nomor Telepon" 
                                        :counter="12"
                                        :disabled="newCustomer == false"
                                        :error-messages="phoneErrors"
                                        @input="$v.editedCustomer.phone_number.$touch()"
                                        @blur="$v.editedCustomer.phone_number.$touch()"
                                        required
                                        prepend-inner-icon="fa fa-phone">
                                    </v-text-field>
                                </v-flex>

                                <v-flex xs12>
                                    <v-text-field 
                                        v-model="editedCustomer.address" 
                                        label="Alamat"
                                        :counter="100"
                                        :disabled="newCustomer == false"
                                        :error-messages="addressErrors"
                                        @input="$v.editedCustomer.address.$touch()"
                                        @blur="$v.editedCustomer.address.$touch()"
                                        required
                                        prepend-inner-icon="fas fa-map-marker-alt">
                                    </v-text-field>
                                </v-flex>
                                
                            </v-layout>
                            </v-container>
                        </v-card-text>
                    </v-card>
                    </v-flex>
                   
                   <!-- Motor Pelanggan -->
                    <v-flex sm6>
                    <v-card height="100%">
                        <v-card-title class="theme--light justify-center">
                            <span class="headline">Motor Pelanggan</span>
                        </v-card-title>
                        <v-card-text>

                         <v-data-table
                          :headers="motorheaders"
                          :rows-per-page-items="[3]"
                          :items="initmotorcustomer">

                            <template v-slot:items="props">
                                <td v-if="selectedMotor.id != props.item.id  || addmotor || props.item.id==''">{{ props.item.plate }}</td>
                                <td v-else> 
                                    <v-text-field
                                    v-model="editedMotor.plate"
                                    label="Nomor Plat"
                                    single-line
                                    counter
                                
                                    required
                                    ></v-text-field>
                                </td>   
                                <td class="text-xs-center" v-if="selectedMotor.id != props.item.id || addmotor">{{ props.item.brand }}</td>
                                    <td v-else> 
                                    <v-select
                                        v-model="editedMotor.brand"
                                        :items="initmotorbrand"             
                                        item-text="name"
                                        item-value="name"
                                        label="Brand"
                                    
                                        required>
                                    </v-select>
                                    </td>          
                                <td class="text-xs-center"  v-if="selectedMotor.id != props.item.id || addmotor">{{ props.item.type }}</td>
                                <td v-else>
                                    <v-select
                                        v-model="editedMotor.type"
                                        :items="initmotortype"               
                                        item-text="name"
                                        item-value="name"
                                        label="Tipe"
                                    
                                        required>
                                    </v-select> 
                                </td> 
                                <td class="justify-center layout px-0">
                                    <v-icon v-if="selectedMotor.id != props.item.id  || addmotor"
                                        small
                                        
                                        class="mr-2"
                                        :disabled="detailMode == true"
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
                                        :disabled="detailMode == true"
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
                                <td :colspan="motorheaders.length - 1" >
                                    <v-form pr-2 class="mt-2">
                                        <v-layout>
                                            <v-flex sm4 pr-2 v-if="addmotor">
                                                <v-text-field v-if="addmotor"
                                                    v-model="editedMotor.plate"
                                                    label="Nomor Plat"
                                                    single-line
                                                    counter
                                
                                                    required
                                                    
                                                ></v-text-field>
                                            </v-flex>
                                            <v-flex sm4 pr-2 v-if="addmotor">
                                                <v-select v-if="addmotor"
                                                    v-model="editedMotor.brand"
                                                    :items="initmotorbrand"
                                                                            
                                                    item-text="name"
                                                    item-value="name"
                                                    label="Brand"
                        
                                                    required>
                                                </v-select>
                                            </v-flex>
                                            <v-flex sm4 pr-2 v-if="addmotor">
                                               <v-select v-if="addmotor"
                                                    v-model="editedMotor.type"
                                                    :items="initmotortype"
                                                                        
                                                    item-text="name"
                                                    item-value="name"
                                                    label="Tipe"
                    
                                                    required>
                                                </v-select> 
                                            </v-flex>
                                        </v-layout>
                                    </v-form>
                                </td>
                                <td :colspan="motorheaders[3].length" class="justify-center layout px-0">
                                    <v-icon v-if="!addmotor && editedCustomer.id!=''"
                                        small
                                        class="mr-2"
                                        :disabled="detailMode == true"
                                        @click="addmotor=true"
                                        
                                    >
                                        add
                                    </v-icon>
                                    <v-icon v-if="addmotor"
                                        small
                                        class="mr-2"
                                        @click ="addmotorcycle()"
                                        
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
   

                        </v-card-text>
                        <br>
      

                    </v-card> 
                    </v-flex>
                  
                   <!-- Tipe Transaksi -->
                    <v-flex sm3 >
                    <v-card height="100%">
                        <v-card-title class="theme--light justify-center">
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
                                        :disabled="detailMode == true || editedCustomer.id==''"
                                
                                        prepend-inner-icon="fas fa-flag">
                                </v-select>
                                    <!-- <v-radio-group v-model="editedItem.type_transaction" class="justify-center" row>
                                        <v-radio label="Sparepart" value="Sparepart"></v-radio>
                                        <v-radio label="Sparepart dan Service" value="Sparepart dan Service"></v-radio>
                                        <v-radio label="Service" value="Service"></v-radio>
                                    </v-radio-group> -->
                                </v-flex>
                               
                            </v-layout>
                            </v-container>
                        </v-card-text>
                        <hr>
                        <v-card-title class="theme--light justify-center">
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
                                        :disabled="detailMode == true"
                              
                                        prepend-inner-icon="fas fa-flag">
                                    </v-select>
                                </v-flex>
                                
                            </v-layout>
                            </v-container>
                        </v-card-text>
                    </v-card>
                    </v-flex>
                    </v-layout>

                 
                 </v-card>

                </v-layout>
               
               <!-- Old Type UI -->
                <!-- <v-layout row wrap>

                    <v-flex sm6>
                    <v-card>
                        <v-card-title class="theme--light justify-center">
                            <span class="headline">Jenis Transaksi</span>
                        </v-card-title>
                        <v-card-text>
                            <v-container grid-list-md>
                            <v-layout wrap>

                                <v-flex>
                                    <v-radio-group v-model="editedItem.type_transaction" class="justify-center" row>
                                        <v-radio label="Sparepart" value="Sparepart"></v-radio>
                                        <v-radio label="Sparepart dan Service" value="Sparepart dan Service"></v-radio>
                                        <v-radio label="Service" value="Service"></v-radio>
                                    </v-radio-group>
                                </v-flex>
                               
                            </v-layout>
                            </v-container>
                        </v-card-text>
                    </v-card>
                    </v-flex>

                    <v-flex sm6>
                    <v-card>
                        <v-card-title class="theme--light justify-center">
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
                                        :disabled="detailMode == true"
                              
                                        prepend-inner-icon="fas fa-flag">
                                    </v-select>
                                </v-flex>
                                
                            </v-layout>
                            </v-container>
                        </v-card-text>
                    </v-card>
                    </v-flex>
                    
                </v-layout> -->
               <!-- Old Type UI -->
               
               
               <!-- Sparepart -->
                <v-layout row wrap v-if="editedItem.type_transaction == 'Sparepart' || editedItem.type_transaction == 'Sparepart dan Service'">
                <br>
                <hr>
                    <v-flex sm12>
                    <v-card>
                        <v-card-title class="theme--light justify-center">
                            <span class="headline">Sparepart</span>
                        </v-card-title>
                        <v-card-text>
                            <v-data-table
                            :headers="sparepartheaders"
                            :rows-per-page-items="[3]"
                            :items="editedItem.sparepart.data">

                                <template v-slot:items="props">
                                    <td>{{ props.item.brand_sparepart}}</td>
                                    <!-- <td v-if="editedItem.sparepart.data[sparepartIndex] != props.item  || addsparepart ">{{ props.item.brand_sparepart}}</td>
                                    <td v-else> 
                                        <v-select 
                                            v-model="editedSparepart.brand_sparepart"
                                            :items="initbrandsparepart"             
                                            item-text="name"
                                            item-value="name"
                                            label="Merk"
                                        
                                            required>
                                        </v-select>
                                    </td>    -->
                                    
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
                                            v-model="editedSparepart.id_employee"
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
                                            :disabled="detailMode == true"

                                            @click="sparepartEdit(props.item) "
                                        >
                                            edit
                                        </v-icon>
                                        <v-icon v-else
                                            small
                                            class="mr-2"
                                            @click="sparepartDone() + countTotal"
                                        >
                                            done
                                        </v-icon>
                                        <v-icon v-if="editedItem.sparepart.data[sparepartIndex] != props.item || addsparepart"
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
                                    <td :colspan="sparepartheaders.length - 1" >
                                        <v-form pr-2 class="mt-2">
                                            <v-layout>
                                                <!-- <v-flex sm3 v-if="addsparepart"> 
                                                    <v-select 
                                                        v-model="editedSparepart.brand_sparepart"
                                                        :items="initbrandsparepart"             
                                                        item-text="name"
                                                        item-value="name"
                                                        label="Merk"
                                                    
                                                        required>
                                                    </v-select>
                                                </v-flex> -->
                                                <v-flex sm3 pr-2 v-if="addsparepart">
                                                    <v-select 
                                                        v-model="editedSparepart.id_sparepart"
                                                        :items="initsparepart"             
                                                        item-text="name"
                                                        item-value="id"
                                                        label="Sparepart"
                                                    
                                                        required>
                                                    </v-select>
                                                </v-flex>
                                                <v-flex sm3 pr-2 v-if="addsparepart">
                                                    <v-text-field
                                                        v-model="editedSparepart.amount_transaction_sparepart"
                                                        label="Jumlah"
                                            
                                                        required>
                                                    </v-text-field>
                                                </v-flex>
                                                <v-flex sm3 pr-2 v-if="addsparepart">
                                                    <v-select 
                                                        v-model="editedSparepart.id_motorcycle"
                                                        :items="initmotorcustomer"             
                                                        item-text="plate"
                                                        item-value="id"
                                                        label="Motor"
                                                    
                                                        required>
                                                    </v-select>
                                                </v-flex>
                                                <v-flex sm3 pr-2 v-if="addsparepart">
                                                    <v-select 
                                                        v-model="editedSparepart.id_employee"
                                                        :items="initmechanic"               
                                                        item-text="name"
                                                        item-value="id"
                                                        label="Montir"
                                                    
                                                        required>
                                                    </v-select> 
                                                </v-flex>
                                            </v-layout>
                                        </v-form>
                                    </td>
                                    <td :colspan="sparepartheaders[7].length" class="justify-center layout px-0">
                                        <v-icon v-if="!addsparepart"
                                            small
                                            class="mr-2"
                                            :disabled="detailMode == true"

                                            @click="addsparepart=true"
                                            
                                        >
                                            add
                                        </v-icon>
                                        <v-icon v-if="addsparepart"
                                            small
                                            class="mr-2"
                                            @click ="sparepartAdd() + countTotal"
                                            
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
                    </v-card>
                    </v-flex>
                </v-layout>

               <!-- Service -->
                <v-layout row wrap v-if="editedItem.type_transaction == 'Service' || editedItem.type_transaction == 'Sparepart dan Service'">
                <br>
                <hr>
                    <v-flex sm12>
                    <v-card>
                        <v-card-title class="theme--light justify-center">
                            <span class="headline">Jasa Service</span>
                        </v-card-title>
                        <v-card-text>
                            <v-data-table
                            :headers="serviceheaders"
                            :rows-per-page-items="[3]"
                            :items="editedItem.service.data">

                                <template v-slot:items="props">
                                    <td v-if="editedItem.service.data[serviceIndex] != props.item  || addservice ">{{ props.item.service_name}}</td>
                                   
                                    <td v-else> 
                                        <v-select
                                            v-model="editedService.id_service"
                                            :items="initservice"             
                                            item-text="name_service"
                                            item-value="id_service"
                                            label="Jasa Service"
                                        
                                            required>
                                        </v-select>
                                    </td>   
                                    <td class="text-xs-center" v-if="editedItem.service.data[serviceIndex] != props.item  || addservice ">{{ props.item.plate_number }}</td>
                                        <td v-else> 
                                        <v-select
                                            v-model="editedService.id_motorcycle"
                                            :items="initmotorcustomer"             
                                            item-text="plate"
                                            item-value="id"
                                            label="Motor"
                                        
                                            required>
                                        </v-select>
                                        </td>          
                                    <td class="text-xs-center"  v-if="editedItem.service.data[serviceIndex] != props.item|| addservice">{{ props.item.mechanic_name }}</td>
                                    <td v-else>
                                        <v-select
                                            v-model="editedService.id_employee"
                                            :items="initmechanic"               
                                            item-text="name"
                                            item-value="id"
                                            label="Montir"
                                        
                                            required>
                                        </v-select> 
                                    </td>
                                    <td class="text-xs-center">{{ props.item.price_transaction_service }}</td>
                                    
                                    <td class="justify-center layout px-0">
                                        <v-icon v-if="editedItem.service.data[serviceIndex] != props.item || addservice"
                                            small
                                            
                                            class="mr-2"
                                            :disabled="detailMode == true"
                                            @click="serviceEdit(props.item)"
                                        >
                                            edit
                                        </v-icon>
                                        <v-icon v-else
                                            small
                                            class="mr-2"
                                            @click="serviceDone() + countTotal"
                                        >
                                            done
                                        </v-icon>
                                        <v-icon v-if="editedItem.service.data[serviceIndex] != props.item || addservice"
                                            small
                                            :disabled="detailMode == true"
                                            @click="serviceDelete(props.item)"
                                        >
                                            delete
                                        </v-icon>
                                        <v-icon v-else
                                            small
                                            class="mr-2"
                                            @click="serviceEditClose()"
                                            
                                        >
                                            close
                                        </v-icon>
                                    </td>
                                </template>
                                <template v-slot:footer>
                                    <td :colspan="serviceheaders[0].length">
                                        <v-select v-if="addservice"
                                            v-model="editedService.id_service"
                                            :items="initservice"             
                                            item-text="name_service"
                                            item-value="id_service"
                                            label="Jasa Service"
                                        
                                            required>
                                        </v-select>
                                    </td>
                                    <td :colspan="serviceheaders[1].length">
                                        <v-select v-if="addservice"
                                            v-model="editedService.id_motorcycle"
                                            :items="initmotorcustomer"             
                                            item-text="plate"
                                            item-value="id"
                                            label="Motor"
                                        
                                            required>
                                        </v-select>
                                    </td>
                                    <td :colspan="serviceheaders[2].length"> 
                                        <v-select v-if="addservice"
                                            v-model="editedService.id_employee"
                                            :items="initmechanic"               
                                            item-text="name"
                                            item-value="id"
                                            label="Montir"
                                        
                                            required>
                                        </v-select> 
                                    </td>
                                    <td :colspan="serviceheaders[3].length"> 
                                        
                                    </td >
                                    <td :colspan="serviceheaders[4].length" class="justify-center layout px-0">
                                        <v-icon v-if="!addservice"
                                            small
                                            class="mr-2"
                                            :disabled="detailMode == true"
                                            @click="addservice=true"
                                            
                                        >
                                            add
                                        </v-icon>
                                        <v-icon v-if="addservice"
                                            small
                                            class="mr-2"
                                            @click ="serviceAdd() + countTotal"
                                            
                                        >
                                            done
                                        </v-icon>
                                        <v-icon v-if="addservice"
                                            small
                                            class="mr-2"
                                            @click="serviceAddClose()"
                                        >
                                            close
                                        </v-icon>
                                    </td>       
                                </template>
                            </v-data-table>  
                        </v-card-text>
                    </v-card>
                    </v-flex>
                </v-layout>
               <!-- End Content -->

               <!-- <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="blue darken-1" flat @click="close()">Batal</v-btn>

                  <v-btn v-if="editedIndex!=-1" color="blue darken-1" @click="updatetransaction()" flat >Simpan</v-btn>
                  <v-btn v-else color="blue darken-1"  @click="addtransaction()" flat >Tambah</v-btn>
               </v-card-actions> -->
              
              </v-card>
          </v-dialog>
         <!-- END dialog box add/edit -->

          <!-- dialog box delete -->
          <v-dialog v-model="delDialog" max-width="500px">
            <v-card>
              <v-card-title>
                <span class="headline">Hapus Transaksi Penjualan</span>
              </v-card-title>
              <v-card-text>
                <h3 class="text-sm-center">Apakah Anda yakin akan menghapus data ini ?</h3>
              </v-card-text>
              <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="blue darken-1" flat @click="deletetransaction()">Ya</v-btn>
                  <v-btn color="blue darken-1" flat @click="close()">Tidak</v-btn>
                  <v-spacer></v-spacer>          
              </v-card-actions>
            </v-card>
          </v-dialog>
         <!-- END dialog box delete -->

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
              <td>{{ props.index+1}}</td>
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
                  @click="detailItem(props.item)">
                  remove_red_eye
              </v-icon>
              <v-icon
                  small
                  class="mr-2"
                  :disabled="props.item.status_process=='Finish' || props.item.status_process=='On Process' "  
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
                  :disabled="props.item.status_process=='Finish' "
                  @click="printtransaction(props.item)"
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

  function sparepartSameErrors () {
    var i = 0
        for(var sparepart in this.editedItem.detail.data)
        {
            if(this.editedItem.detail.data[i].id_sparepart==this.editedSparepart.id_sparepart)
            {
               return false
            }
            i++;
        }
        return true
  }
  function phoneNumberSameErrors () {
    var i = 0
        for(var customer in this.customers)
        {
            if(this.editedCustomer.id=='')
            {
                if(this.customers[i].phone_number==this.editedCustomer.phone_number)
                {
                    return false
                }
            }
            
            i++;
        }
        return true
  }

  export default {
    validations: {
    //    editedItem: {
    //     date_transaction: { required },
    //     status_process: { required },
    //     id_sales: { required },
    //     id_supplier: { required },
    //    },
       editedCustomer:{
        name: {required,maxLength: maxLength(25)},
        phone_number: {required,numeric,phoneNumberSameErrors,maxLength: maxLength(12)},
        address: {required,maxLength:maxLength(100)},
       }   
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
     //HEADER TABLE====================== 
      headers: [
        { text: 'No', align: 'left',sortable: false },
        { text: 'Id Transaksi', align: 'center', value: 'id_transaction' },
        { text: 'Tanggal', align: 'center', value: 'date_transaction' },
        { text: 'Pelanggan', align: 'center', value: 'name_customer' },
        { text: 'Status', align: 'center', value: 'status_process' },
        { text: 'Actions', align: 'center', sortable: false }
      ],
      motorheaders: [
        { text: 'Nomor Plat', align: 'left', value: 'plate' },
        { text: 'Brand', align: 'center', value: 'brand', sortable: false },
        { text: 'Tipe', align: 'center', value: 'tipe', sortable: false },
        { text: 'Actions', align: 'center', sortable: false },

      ],
      // sparepartheaders: [
      //   { text: 'No', align: 'left',sortable: false },
      //   { text: 'Sparepart', align: 'left', value: 'name_sparepart',sortable: false },
      //   { text: 'Jumlah', align: 'center', value: 'amount', sortable: false  },
      //   { text: 'Harga Beli', align: 'center', value: 'price', sortable: false  },
      //   { text: 'Actions', align: 'center', sortable: false }
      // ],
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
        { text: 'Actions', align: 'center', sortable: false },

      ],
      sparepartheaders: [
        { text: 'Merk', align: 'left', value: 'brand_sparepart', sortable: false },
        { text: 'Sparepart', align: 'center', value: 'name_sparepart' },
        { text: 'Harga Satuan', align: 'center', value: 'price_transaction_sparepart', sortable: false },
        { text: 'Jumlah', align: 'center', value: 'amount_transaction_sparepart', sortable: false },
        { text: 'Motor Pelanggan', align: 'center', value: 'amount_transaction_sparepart', sortable: false },
        { text: 'Montir', align: 'center', value: 'mechanic_name', sortable: false },
        { text: 'Subtotal', align: 'center', value: 'subtotal_transaction_sparepart', sortable: false },
        { text: 'Actions', align: 'center', sortable: false },

      ],
     //==================================
      
      dropdown_sales:[],
      dropdown_sparepart:[],
      transactionData: [],
    //CUSTOMER VAR==============
      newCustomer:false,
      customerData:[],
      editedCustomer: {
        id:'',
        name: '',
        phone_number: '',
        address: '',
        motorcycle:[],

      },
      defaultCustomer: {
        id:'',
        name: '',
        phone_number: '',
        address: '',
        motorcycle:[],
        
      },
    //==========================
     
    //SPAREPART VAR=================
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
        id_employee:'',
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
        id_employee:'',
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
        id_employee:'',
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
        id_employee:'',
        mechanic_name:'',
        id_sparepart:'',
        id_motorcycle:'',
        name_sparepart:'',
        brand_sparepart:'',
        id_transaction:'',
      },
    //==========================

    //SERVICE VAR=================
      addservice: false,    
      dropdown_motorcustomer:[],
      dropdown_service: [],
      dropdown_mechanic: [],
      mechanicData:[],
      serviceData:[],
      serviceIndex:-1,

      selectedService:{
        id_detail_service:'',
        amount_transaction_service: '',
        price_transaction_service:'',
        subtotal_transaction_service: '',
        plate_number:'',
        id_employee:'',
        mechanic_name:'',
        id_service:'',
        id_motorcycle:'',
        service_name:'',
        id_transaction:'',
      },
      editedService:{
        id_detail_service:'',
        amount_transaction_service: '',
        price_transaction_service:'',
        subtotal_transaction_service: '',
        plate_number:'',
        id_employee:'',
        mechanic_name:'',
        id_service:'',
        id_motorcycle:'',
        service_name:'',
        id_transaction:'',
      },
      addedService:{
        id_detail_service:'',
        amount_transaction_service: '',
        price_transaction_service:'',
        subtotal_transaction_service: '',
        plate_number:'',
        id_employee:'',
        mechanic_name:'',
        id_service:'',
        id_motorcycle:'',
        service_name:'',
        id_transaction:'',
      },
      defaultService:{
        id_detail_service:'',
        amount_transaction_service: '',
        price_transaction_service:'',
        subtotal_transaction_service: '',
        plate_number:'',
        id_employee:'',
        mechanic_name:'',
        id_service:'',
        id_motorcycle:'',
        service_name:'',
        id_transaction:'',
      },
    //==========================

    //MOTOR VAR=================
      dropdown_motorbrand:[],
      dropdown_motortype: [],
      motorCustomer:[],
      motorIndex:-1,
      selectedMotor:{
        id:'',
        plate: '',
        brand:'',
        type: '',
      },
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
        }
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
        }
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
        if(this.detailMode == true)
        {
          return 'Detail Transaksi Penjualan'
        }
        else if(this.editedIndex==-1)
        {
          return 'Tambah Transaksi Penjualan'
        }
        else
        {
          return 'Edit Transaksi Penjualan'
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

      countTotal(){
        this.total = 0
        for(let data in this.editedItem.sparepart.data)
        {
          this.total += this.editedItem.sparepart.data[this.i].subtotal_transaction_sparepart
          this.i++
        }
        this.i = 0

        for(let data in this.editedItem.service.data)
        {
          this.total += this.editedItem.service.data[this.i].subtotal_transaction_service
          this.i++
        }
        this.i = 0
        this.editedItem.total_transaction = this.total
        // this.total = this.editedItem.detail.data.stream().mapToInt(obj => obj.subtotal).sum();
        // this.total = this.editedItem.detail.id_supplier
        return 'Rp. '+this.total
      },
    //INIT===============================
      inittransaction () {
        this.transactionData = this.transactions;
        return this.transactionData
      },

      initmotorcustomer(){
        this.motorCustomer = this.motorcustomers.filter(obj=>obj.customer.id == this.editedItem.id_customer);
        return this.motorCustomer
      },

      initmotorbrand(){
        this.dropdown_motorbrand = this.motorbrands;
        return this.dropdown_motorbrand
      },
      
      initmotortype(){
        this.dropdown_motortype = this.motortypes.filter( obj => obj.brand.name === this.editedMotor.brand);
        return this.dropdown_motortype
      },

      initcustomer() {
        this.customerData = this.customers;
        return this.customerData
      },

      initservice(){
          this.serviceData = this.services;
          return this.serviceData
      },

      initmechanic(){
          this.mechanicData = this.employees.filter(obj=>obj.role =='Mechanic');
          return this.mechanicData
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

      initsparepart(){
        // this.dropdown_sparepart = this.spareparts
        this.dropdown_sparepart = this.spareparts.map(obj => ({
              id : obj.id,
              name : obj.name+' '+obj.brand
        }))
        return this.dropdown_sparepart

      },
    //
    //VALIDATION ERROR
        nameErrors () {
            const errors = []
            if (!this.$v.editedCustomer.name.$dirty) return errors
            !this.$v.editedCustomer.name.required && errors.push('Nama Diperlukan.')
            !this.$v.editedCustomer.name.maxLength && errors.push('Nama tidak lebih dari 25 karakter. ')
            return errors
        },
        phoneErrors () {
            const errors = []
            if (!this.$v.editedCustomer.phone_number.$dirty) return errors
            !this.$v.editedCustomer.phone_number.maxLength && errors.push('Nomor telepon tidak lebih dari 12 karakter.')
            !this.$v.editedCustomer.phone_number.numeric && errors.push('Nomor telepon harus numerik.')        
            !this.$v.editedCustomer.phone_number.required && errors.push('Nomor telepon diperlukan.')
            !this.$v.editedCustomer.phone_number.phoneNumberSameErrors && errors.push('Nomor telepon telah terdaftar.')
            return errors
        },
        addressErrors () {
            const errors = []
            if (!this.$v.editedCustomer.address.$dirty) return errors
            !this.$v.editedCustomer.address.maxLength && errors.push('Alamat tidak lebih dari 100 karakter.')
            !this.$v.editedCustomer.address.required && errors.push('Alamat diperlukan.')
            return errors
        },
        //   statusErrors () {
        //     const errors = []
        //     if (!this.$v.editedItem.status_process.$dirty) return errors
        //     !this.$v.editedItem.status_process.required && errors.push('Status diperlukan.')
        //     return errors
        //   },

        //   supplierErrors () {
        //     const errors = []
        //     if (!this.$v.editedItem.id_supplier.$dirty) return errors   
        //     !this.$v.editedItem.id_supplier.required && errors.push('Supplier diperlukan.')
        //     return errors
        //   },

        //   salesErrors () {
        //     const errors = []
        //     if (!this.$v.editedItem.id_sales.$dirty) return errors
        //     !this.$v.editedItem.id_sales.required && errors.push('Sales diperlukan.')
        //     return errors
        //   },
        //   sparepartErrors() {
        //     const errors = []
        //     if (!this.$v.editedSparepart.id_sparepart.$dirty) return errors
        //     !this.$v.editedSparepart.id_sparepart.required && errors.push('Sparepart diperlukan.')
        //     !this.$v.editedSparepart.id_sparepart.sparepartSameErrors && errors.push('Sparepart Tidak Boleh Sama.')

        //     return errors
        //   },
        //   amountErrors() {
        //     const errors = []
        //     if (!this.$v.editedSparepart.amount.$dirty) return errors
        //     !this.$v.editedSparepart.amount.required && errors.push('Jumlah diperlukan.')
        //     !this.$v.editedSparepart.amount.numeric && errors.push('Jumlah harus numerik.')
        //     !this.$v.editedSparepart.amount != 0 && errors.push('Jumlah harus lebih dari 0.')
        //     return errors
        //   },
        //   priceErrors() {
        //     const errors = []
        //     if (!this.$v.editedSparepart.price.$dirty) return errors
        //     !this.$v.editedSparepart.price.required && errors.push('Harga diperlukan.')
        //     !this.$v.editedSparepart.price.numeric && errors.push('Harga harus numerik.')
        //     return errors
        //   },
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
    //
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

    //   setcustomer(){
    //     this.editedCustomer = this.customers.find(obj=>obj.id == this.editedItem.id_customer);
    //     this.editedItem.employee.data[0] = {
    //       id_employee : this.id
    //     }
    //     return this.editedCustomer
    //   },

      filtertype(brand){
        this.dropdown_type  = this.dropdown_type.filter( obj => obj.brand.name === this.editedSparepart.brand)
        return this.dropdown_type
      },
     //TRANSACTION====================
    
      async addtransaction () {
        try {

          // console.log(detailPayload)
          
          const data ={
            
            status_process: this.editedItem.status_process,
            type_transaction:this.editedItem.type_transaction,
            total_transaction: this.editedItem.total_transaction,
            id_customer: this.editedItem.id_customer,
            sparepart: this.editedItem.sparepart.data,
            service: this.editedItem.service.data,
            employee: this.editedItem.employee.data,
          }

          console.log(data)
          await this.storeTransaction(data)
          this.transactionData.push(this.editedItem)
          await this.getTransaction()
          this.close()
          this.showAlert('success','Berhasil Tambah Transaksi')
        } catch (err) {
          console.log(err)
          this.showAlert('error','Gagal Tambah Transaksi')
        }
            
      },
      
      async updatetransaction () {
        try {
          const data ={
            id_transaction: this.editedItem.id_transaction,
            status_process: this.editedItem.status_process,
            type_transaction:this.editedItem.type_transaction,
            total_transaction: this.editedItem.total_transaction,
            id_customer: this.editedItem.id_customer,
            sparepart: this.editedItem.sparepart.data,
            service: this.editedItem.service.data,
            employee: this.editedItem.employee.data,
          }


          await this.updateTransaction(data)
          // Object.assign(this.transactionData[this.editedIndex], this.editedItem)
          await this.getTransaction()
          this.close()
          this.showAlert('success','Success Update Transaction')

        } catch (err) {
            console.log(err)
            this.showAlert('error','Failed Update Transaction')
        }
      },

      async deletetransaction () {
         try {
            var id_transaction = this.transactionData[this.editedIndex].id_transaction
            // console.log(id_transaction)
            await this.deleteTransaction(id_transaction)
            await this.getTransaction()
            this.close()
            this.showAlert('success','Success Delete Transaction')

          } catch (err) {
              console.log(err)
            this.showAlert('error','Failed Delete Transaction')

          }
      },

      async printtransaction(item){
        try {
          window.open(`/api/generate-spk-pdf/${item.id_transaction}`, '_blank')
          const data ={
            id_transaction: item.id_transaction,
            status_process: 'On Process',
            type_transaction:item.type_transaction,
            total_transaction: item.total_transaction,
            id_customer: item.id_customer,
          }


          await this.updateTransaction(data)
          // Object.assign(this.transactionData[this.editedIndex], this.editedItem)
          await this.getTransaction()
        //   this.close()
          this.showAlert('success','Success Update Transaction')

        } catch (err) {
            console.log(err)
            this.showAlert('error','Failed Update Transaction')
        }
      },
     //========================================

      //MAIN MODAL AND TABLE====================
        editItem (item) {
            
            this.editedIndex = this.transactions.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialog = true
            
        },

        verifyItem(item){
            this.verifMode = true
            this.editedIndex = this.transactions.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialog = true
        },

        detailItem(item){
            this.detailMode = true
            this.editedIndex = this.transactions.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialog = true
        },
        
        deleteItem (item) {
            console.log(item)
            this.delDialog = true
            this.editedIndex = this.transactionData.indexOf(item)
            console.log(this.editedIndex)

        },

        close () {
            this.dialog = false
            this.delDialog = false

            // this.sparepartDialog = false
            setTimeout(() => {
            this.editedItem = Object.assign({}, this.defaultItem)
            this.editedSparepart = Object.assign({},this.defaultSparepart)
            this.selectedSparepart = Object.assign({},this.defaultSparepart)
            this.editedCustomer = Object.assign({},this.defaultCustomer)
            this.editedIndex = -1
            this.sparepartIndex = -1
            this.addsparepart =false
            this.newCustomer = false
            this.verifMode = false
            this.detailMode = false
            this.$v.$reset()
            }, 300)
        },
      
      //========================================
      
      //SERVICE=================================
        serviceDelete (item) {
            // this.editedItem = item
            // this.deletesparepart()
            this.editedItem.service.data = this.editedItem.service.data.filter(obj=>obj.id_detail_service!= item.id_detail_service)
        },

        serviceEdit (item) {
            this.addservice =false
            this.editedService = item
            this.selectedService = item
            console.log(item)
            this.serviceIndex = this.editedItem.service.data.indexOf(item)
        },

        serviceDone () {
            this.addservice =false
            this.editedService.amount_transaction_service = 1
            this.editedService.price_transaction_service = this.services.find(obj => obj.id_service == this.editedService.id_service).price_service
            this.editedService.subtotal_transaction_service = this.editedService.amount_transaction_service * this.editedService.price_transaction_service
            this.editedService.service_name = this.services.find(obj => obj.id_service == this.editedService.id_service).name_service
            this.editedService.plate_number = this.motorcustomers.find(obj => obj.id == this.editedService.id_motorcycle).plate
            this.editedService.mechanic_name = this.employees.find(obj => obj.id == this.editedService.id_employee).name
            this.editedItem.service.data[this.serviceIndex] =  this.editedService
            // this.countTotal()
            this.selectedService = this.defaultService
            this.editedService = this.defaultService
            this.serviceIndex = -1
            
        },

        serviceEditClose(){
            this.editedService = Object.assign({},this.defaultService)
            this.selectedService = Object.assign({},this.defaultService)
            // this.editedSparepart = Object.assign({},this.defaultService)
            this.serviceIndex = -1
        },

        serviceAdd(){
            this.addservice =false

            this.editedService.amount_transaction_service = 1
            this.editedService.price_transaction_service = this.services.find(obj => obj.id_service == this.editedService.id_service).price_service
            this.editedService.subtotal_transaction_service = this.editedService.amount_transaction_service * this.editedService.price_transaction_service
            this.editedService.service_name = this.services.find(obj => obj.id_service == this.editedService.id_service).name_service
            this.editedService.plate_number = this.motorcustomers.find(obj => obj.id == this.editedService.id_motorcycle).plate
            this.editedService.mechanic_name = this.employees.find(obj => obj.id == this.editedService.id_employee).name
            
           
            this.editedItem.service.data.push(this.editedService)
            // this.countTotal()
            this.editedService = Object.assign({},this.defaultService)
            this.selectedService = Object.assign({},this.defaultService)
            
            // for(let data in this.editedItem.detail.data)
            // {
            //   this.total += this.editedItem.detail.data[this.i].subtotal
            //   this.i++
            // }
            // this.i = 0
            // this.total = this.editedItem.detail.data.mapToInt(obj => obj.subtotal).sum();
            this.serviceIndex = -1

        },

        serviceAddClose(){
            this.addservice = false
            this.editedService = Object.assign({},this.defaultService)
            this.selectedService = Object.assign({},this.defaultService)
            this.serviceIndex = -1
        },

      //========================================

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
            // this.editedSparepart.amount_transaction_sparepart = 1
            this.editedSparepart.price_transaction_sparepart = this.spareparts.find(obj => obj.id == this.editedSparepart.id_sparepart).sell_price
            this.editedSparepart.subtotal_transaction_sparepart = this.editedSparepart.amount_transaction_sparepart * this.editedSparepart.price_transaction_sparepart
            this.editedSparepart.name_sparepart = this.spareparts.find(obj => obj.id == this.editedSparepart.id_sparepart).name
            this.editedSparepart.plate_number = this.motorcustomers.find(obj => obj.id == this.editedSparepart.id_motorcycle).plate
            this.editedSparepart.mechanic_name = this.employees.find(obj => obj.id == this.editedSparepart.id_employee).name
            
            this.editedSparepart.brand_sparepart = this.spareparts.find(obj => obj.id == this.editedSparepart.id_sparepart).brand
            
            this.editedItem.sparepart.data[this.sparepartIndex] =  this.editedSparepart
            // this.countTotal()
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

            // this.editedSparepart.amount_transaction_sparepart = 1
            this.editedSparepart.price_transaction_sparepart = this.spareparts.find(obj => obj.id == this.editedSparepart.id_sparepart).sell_price
            this.editedSparepart.subtotal_transaction_sparepart = this.editedSparepart.amount_transaction_sparepart * this.editedSparepart.price_transaction_sparepart
            this.editedSparepart.name_sparepart = this.spareparts.find(obj => obj.id == this.editedSparepart.id_sparepart).name
            this.editedSparepart.plate_number = this.motorcustomers.find(obj => obj.id == this.editedSparepart.id_motorcycle).plate
            this.editedSparepart.mechanic_name = this.employees.find(obj => obj.id == this.editedSparepart.id_employee).name
            this.editedSparepart.brand_sparepart = this.spareparts.find(obj => obj.id == this.editedSparepart.id_sparepart).brand
            

            this.editedItem.sparepart.data.push(this.editedSparepart)
            // this.countTotal()
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
      //CUSTOMER==========================
        customerHandler(){
            // if(this.newCustomer==true){
                // console.log("Masuk")
                this.editedItem.id_customer = ""
                this.editedCustomer = Object.assign({},this.defaultCustomer)
                this.$v.$reset()
            // }       
        },
        async addcustomer () {
            try {
                const data ={
                name_customer: this.editedCustomer.name,
                address_customer : this.editedCustomer.address,
                phone_number_customer : this.editedCustomer.phone_number,
                }
                // console.log(data)
                await this.storeCustomer(data)
                // console.log(response)
                await this.getCustomer()
                // console.log(this.customers)

                this.editedCustomer = this.customers.find(obj=>obj.phone_number == this.editedCustomer.phone_number)
                this.editedItem.id_customer = this.editedCustomer.id
                this.editedItem.name = this.editedCustomer.name
                this.showAlert('success','Success Add Customer')
            } catch (err) {
                console.log(err)
                this.showAlert('error','Failed Add Customer')
            }
            
        },
      //========================================

      //MOTOR CUSTOMER==========================
        async addmotorcycle() {
            try {
            // console.log(this.editedMotor)
                const data ={
                    plate_number: this.editedMotor.plate,
                    id_motorcycle_type : this.motortypes.find(obj=>obj.name == this.editedMotor.type).id,
                    id_customer : this.editedCustomer.id,
                }
                // console.log(data)
                await this.storeMotorcycle(data)
                await this.getCustomer()
                await this.getMotorCustomer()
                // this.editedCustomer.motorcycle.push(data)
                // this.editedCustomer = this.customers.find(obj=>obj.phone_number == this.editedCustomer.phone_number)

                this.motorAddClose()
                this.showAlert('success','Berhasil Menambahkan Motor')
            } catch (err) {
                console.log(err)
                this.showAlert('error','Gagal Menambahkan Motor')
            }
                
        },
        async deletemotorcycle() {
            try {

                await this.deleteMotorcycle(this.editedMotor.id)
                
                await this.getCustomer()
                await this.getMotorCustomer()
                // this.editedMotor = Object.assign({},this.defaultdMotor)

                this.showAlert('success','Berhasil Menghapus Motor')
            } catch (err) {
                console.log(err)
                this.showAlert('error','Gagal Menghapus Motor')
            }
                
        },
        async updatemotorcycle () {
            try {
                const data ={
                    id_motorcycle: this.selectedMotor.id,
                    plate_number: this.editedMotor.plate,
                    id_motorcycle_type : this.motortypes.find(obj => obj.name == this.editedMotor.type).id,
                    id_customer : this.editedCustomer.id,

                }
                // console.log(data)
                await this.updateMotorcycle(data)
                // Object.assign(this.customerData[this.motorIndex], this.editedMotor)
                await this.getCustomer()
                await this.getMotorCustomer()
                this.motorEditClose()
                this.showAlert('success','Success Update Customer')

            } catch (err) {
                console.log(err)
                this.showAlert('error','Failed Update Customer')
            }
        },

        motorDelete (item) {
            this.editedMotor = item
            this.deletemotorcycle()
        },
        motorEdit (item) {
            this.addmotor =false
            this.editedMotor = item
            this.selectedMotor = item
            this.motorIndex = this.motorCustomer.indexOf(item)
        },
        motorEditClose(){
            this.editedMotor = Object.assign({},this.defaultdMotor)
            this.selectedMotor = Object.assign({},this.defaultdMotor)
            this.motorIndex = -1
        },
        motorAdd(){
            this.addmotor =true
            this.editedMotor = Object.assign({},this.defaultdMotor)
            this.selectedMotor = Object.assign({},this.defaultdMotor)
            this.motorIndex = -1

        },
        motorAddClose(){
            this.addmotor = false
            this.editedMotor = Object.assign({},this.defaultdMotor)
            this.selectedMotor = Object.assign({},this.defaultdMotor)
            this.motorIndex = -1
        },
      //========================================



      save () {
        if (this.editedIndex > -1) {
          Object.assign(this.transactionData[this.editedIndex], this.editedItem)
        } else {
          this.transactionData.push(this.editedItem)
        }
        this.close()
      },
      showSparepart(item){
        this.sparepartDialog=true
        this.selectedTransaction = item
        // this.sparepartTransaction = this.sparepartData.filter(obj => obj.transaction.id == item.id);
        this.sparepartTransaction = item.sparepart.data
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
