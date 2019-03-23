import salesService from '../../service/Sales'

const state = {
  manySales: [],
  sales: {
    id_sales:'',
    name_sales: '',
    phone_number_sales: '',
    address_sales: '',

  },
  loading: true,
  error: null
}

const mutations = {
  setSource(state, payload) {
    state.manySales = payload
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
  sales: state => state.sales
}

const actions = {
  async get(context) {
    try {
      context.commit('setSource', await salesService.get())
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async store(context, payload) {
    try {
      await salesService.store(payload)
    } catch (err) {
      context.commit('setFailedStore', err)
    }
  },

  async edit(context, id) {
    try {
      const res = await salesService.find(id)
    //   context.commit('setEmployeeForm', res)
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async update(context, payload) {
    try {
      const data = {
        name_sales: payload.name_sales,
        phone_number_sales: payload.phone_number_sales,
        id_supplier: payload.id_supplier,
      }

      await salesService.update(payload.id_sales, data)
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async delete (context, id) {
    try {
      await salesService.delete(id)
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