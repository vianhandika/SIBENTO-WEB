import supplierService from '../../service/Supplier'

const state = {
  suppliers: [],
  supplier: {
    id_supplier:'',
    name_supplier: '',
    phone_number_supplier: '',
    address_supplier: '',

  },
  loading: true,
  error: null
}

const mutations = {
  setSource(state, payload) {
    state.suppliers = payload
    state.loading = false
    state.error = null
  },

  setFailedAction(state, payload) {
    state.loading = false
    state.error = payload.error
  },

}

const getters = {
  error: state => state.error,
  loading: state => state.loading,
  supplier: state => state.supplier
}

const actions = {
  async get(context) {
    try {
      context.commit('setSource', await supplierService.get())
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async store(context, payload) {
    try {
      await supplierService.store(payload)
    } catch (err) {
      context.commit('setFailedStore', err)
    }
  },

  async edit(context, id) {
    try {
      const res = await supplierService.find(id)
    //   context.commit('setEmployeeForm', res)
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async update(context, payload) {
    try {
      const data = {
        name_supplier: payload.name_supplier,
        phone_number_supplier: payload.phone_number_supplier,
        address_supplier: payload.address_supplier,
      }

      await supplierService.update(payload.id_supplier, data)
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async delete (context, id) {
    try {
      await supplierService.delete(id)
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  resetForm(context) {
    context.commit('setEmployeeForm', {})
  }
}

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
}