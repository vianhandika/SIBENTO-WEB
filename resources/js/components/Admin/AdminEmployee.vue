<template>
    <div>
        <v-toolbar flat color="white">

          <v-toolbar-title>MANAJEMEN PEGAWAI</v-toolbar-title>
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
                      <v-flex xs12 sm6 md7>
                        <v-select
                          v-model="editedItem.role"
                          :items="initrole"
                          :error-messages="roleErrors"
                          item-text="name"
                          item-value="name"
                          label="Jabatan"
                          required
                          @change="$v.editedItem.role.$touch()"
                          @blur="$v.editedItem.role.$touch()"
                          prepend-inner-icon="fas fa-toolbox"
                        ></v-select>
                      </v-flex>
                      <!-- <v-text-field v-model="editedItem.role" label="Role"></v-text-field> -->        
                      <v-flex  xs12 sm6 md12>
                        <v-select
                          v-model="editedItem.branch"
                          :items="initbranch"
                          :error-messages="branchErrors"
                          item-text="name"
                          item-value="name"
                          label="Cabang"
                          required
                          @change="$v.editedItem.branch.$touch()"
                          @blur="$v.editedItem.branch.$touch()"
                          prepend-inner-icon="fas fa-building"
                        ></v-select>
                      <!-- <v-text-field v-model="editedItem.branch" label="Branch"></v-text-field> -->
                      </v-flex>
                      <v-flex xs12 sm6 md6>
                        <v-text-field 
                          v-model="editedItem.salary" 
                          :error-messages="salaryErrors"
                          required
                          label="Gaji / Minggu (Rp)" 
                          @input="$v.editedItem.salary.$touch()"
                          @blur="$v.editedItem.salary.$touch()"
                          prepend-inner-icon="fas fa-coins">
                        </v-text-field>
                      </v-flex>
                  </v-layout>
                  </v-container>
              </v-card-text>

              <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="blue darken-1" flat @click="close">Batal</v-btn>
                  <v-btn v-if="editedIndex!=-1" color="blue darken-1" flat @click="updateemployee">Simpan</v-btn>
                  <v-btn v-else color="blue darken-1" :disabled="$v.editedItem.$invalid" flat @click="addemployee">Tambah</v-btn>
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
                  <v-btn color="blue darken-1" flat @click="deleteemployee()">Ya</v-btn>
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
          :items="initemployee"
          :search="search"
          class="elevation-1">

          <template v-slot:items="props">
              <td>{{ props.index+1}}</td>
              <td>{{ props.item.name }}</td>
              <td class="text-xs-center">{{ props.item.phone_number }}</td>
              <td class="text-xs-left">{{ props.item.address }}</td>
              <td class="text-xs-left">{{ props.item.role }}</td>
              <td class="text-xs-left">Rp. {{ props.item.salary }}</td>
              <td class="text-xs-left">{{ props.item.branch }}</td>
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
  import employeeService from '../../service/Employee'
  import branchService from '../../service/Branch'
  import roleService from '../../service/Role'
  import { required, maxLength, numeric } from 'vuelidate/lib/validators'


  export default {
    validations: {
       editedItem: {
        name: { required, maxLength: maxLength(25) },
        phone_number: { required, numeric, maxLength: maxLength(12) },
        address: { required, maxLength: maxLength(100) },
        salary: { required, numeric},
        branch: { required },
        role: { required },
       },   
    },

    data: () => ({
      
      dialog: false,
      delDialog: false,
      search: '',
      i:0,
      headers: [
        { text: 'No', align: 'left',sortable: false },
        { text: 'Nama Pegawai', align: 'left', value: 'name' },
        { text: 'Nomor Telepon', align: 'center', value: 'phone_number', sortable: false },
        { text: 'Alamat', align: 'center', value: 'address', sortable: false },
        { text: 'Jabatan', align: 'center',value: 'role' },
        { text: 'Gaji / Minggu', align: 'center' ,value: 'salary', sortable: false},
        { text: 'Cabang', align: 'center',value: 'branch' },
        { text: 'Actions', align: 'center',value: 'name', sortable: false }
      ],
      employeeData: [],
      dropdown_branch: [],
      dropdown_role: [],
      payload: {
        name_employee: '',
        phone_number: '',
        address: '',
        role: null,
        salary: null,
        branch: null,
        username:''
      },
      editedIndex: -1,
      editedItem: {
        name: '',
        phone_number: '',
        address: '',
        role: null,
        salary: null,
        branch: null,
      },
      defaultItem: {
        name: '',
        phone_number: '',
        address: '',
        role: null,
        salary: null,
        branch: null,
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
        return this.editedIndex === -1 ? 'Add Employee' : 'Edit Employee'
      },
      ...mapState({
        loading: state => state.Employee.loading,
        error: state => state.Employee.error,
        employees: state => state.Employee.employees,
        branches: state => state.Branch.branches, 
        roles: state => state.Role.roles, 

      }),
      initemployee () {
        this.employeeData = this.employees.filter(obj => obj.role != "Admin");
        return this.employeeData
      },
      initbranch () {
        this.dropdown_branch = this.branches
        return this.dropdown_branch
      },
      initrole(){
        this.dropdown_role = this.roles.filter(obj => obj.name != "Admin");
        return this.dropdown_role
      },
      //VALIDATION ERROR
      nameErrors () {
        const errors = []
        if (!this.$v.editedItem.name.$dirty) return errors
        !this.$v.editedItem.name.maxLength && errors.push('Name must be at most 25 characters long')
        !this.$v.editedItem.name.required && errors.push('Name is required.')
        return errors
      },
      phoneErrors () {
        const errors = []
        if (!this.$v.editedItem.phone_number.$dirty) return errors
        !this.$v.editedItem.phone_number.maxLength && errors.push('Phone Number must be at most 12 characters long')
        !this.$v.editedItem.phone_number.numeric && errors.push('Phone Number must be numeric')        
        !this.$v.editedItem.phone_number.required && errors.push('Phone Number is required.')
        return errors
      },
      addressErrors () {
        const errors = []
        if (!this.$v.editedItem.address.$dirty) return errors
        !this.$v.editedItem.address.maxLength && errors.push('Address must be at most 100 characters long')
        !this.$v.editedItem.address.required && errors.push('Address is required.')
        return errors
      },
      salaryErrors () {
        const errors = []
        if (!this.$v.editedItem.salary.$dirty) return errors
        !this.$v.editedItem.salary.numeric && errors.push('Salary must be numeric')        
        !this.$v.editedItem.salary.required && errors.push('Salary is required.')
        return errors
      },
      branchErrors () {
        const errors = []
        if (!this.$v.editedItem.branch.$dirty) return errors
        !this.$v.editedItem.branch.required && errors.push('Branch is required.')
        return errors
      },
      roleErrors () {
        const errors = []
        if (!this.$v.editedItem.role.$dirty) return errors
        !this.$v.editedItem.role.required && errors.push('Role is required.')
        return errors
      }

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
      // this.loaddata ()
      // this.showAlert('error','Failed Update Employee');
      //  console.log(this.dropdown_role);
      // this.topayload()
    },
    mounted(){
      this.getRole()
      this.getBranch()
      this.getEmployee()
      // this.initialize()
    },

    methods: {
      initialize () {
        // console.log(this.employees)
        // console.log(this.roles)
        // console.log(this.branches)

        this.employeeData = this.employees.filter(obj => obj.role != "Admin");
        this.dropdown_role = this.roles.filter(obj => obj.name != "Admin");
        this.dropdown_branch = this.branches;
      },
      
      ...mapActions({
          getEmployee: 'Employee/get',
          getBranch: 'Branch/get',
          getRole: 'Role/get',
          storeEmployee: 'Employee/store',
          deleteEmployee: 'Employee/delete',
          updateEmployee: 'Employee/update'
          
      }),
      async loaddata () {
        try {
            this.employeeData = (await Controller.getallemployee()).data
            this.dropdown_branch = (await Controller.getallbranch()).data
            this.dropdown_role = (await Controller.getallrole()).data
            this.employeeData = this.employeitemeData.filter(obj => obj.role != "Admin");
            
            console.log(this.employeeData)
            
        } catch (err) {
            console.log(err)
        }
      },

      async addemployee () {
        try {
            const data ={
              name_employee: this.editedItem.name,
              phone_number : this.editedItem.phone_number,
              address : this.editedItem.address,
              role : this.dropdown_role.find(obj => obj.name  == this.editedItem.role).id,
              salary : this.editedItem.salary,
              branch : this.dropdown_branch.find(obj => obj.name  == this.editedItem.branch).id

            }
            this.storeEmployee(this.data)
            this.employeeData.push(this.editedItem)
            this.getEmployee()
            this.close()
            this.showAlert('success','Success Add Employee')
        } catch (err) {
            console.log(err)
            this.showAlert('error','Failed Add Employee')
        }
            
      },

      async updateemployee () {
        try {
            // this.topayload()
            // var id_employee = this.employeeData[this.editedIndex].id
            const data ={
              id_employee: this.employeeData[this.editedIndex].id,
              name_employee: this.editedItem.name,
              phone_number : this.editedItem.phone_number,
              address : this.editedItem.address,
              role : this.dropdown_role.find(obj => obj.name  == this.editedItem.role).id,
              salary : this.editedItem.salary,
              branch : this.dropdown_branch.find(obj => obj.name  == this.editedItem.branch).id

            }
            // const response = await Controller.updateemployee(this.payload,id_employee)
            this.updateEmployee(data)
            Object.assign(this.employeeData[this.editedIndex], this.editedItem)
            this.getEmployee()
            this.close()
            this.showAlert('success','Success Update Employee')

        } catch (err) {
            console.log(err)
            this.showAlert('error','Failed Update Employee')
        }
      },

      async deleteemployee () {
         try {
            var id_employee = this.employeeData[this.editedIndex].id
            await this.deleteEmployee(id_employee)
            this.getEmployee()
            this.close()
            this.showAlert('success','Success Delete Employee')

          } catch (err) {
              console.log(err)
            this.showAlert('error','Failed Delete Employee')

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
        this.editedIndex = this.employeeData.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialog = true
      },

      deleteItem (item) {
        this.delDialog = true
        this.editedIndex = this.employeeData.indexOf(item)
        // this.deleteemployee()
        // confirm('Are you sure you want to delete this item?') && this.employeeData.splice(this.editedIndex, 1)
        // confirm('Are you sure you want to delete this item?') && this.deleteemployee()
        
      },

      close () {
        this.dialog = false
        this.delDialog = false
        setTimeout(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
          this.$v.$reset()
        }, 300)
      },

      save () {
        if (this.editedIndex > -1) {
          Object.assign(this.employeeData[this.editedIndex], this.editedItem)
        } else {
          this.employeeData.push(this.editedItem)
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
