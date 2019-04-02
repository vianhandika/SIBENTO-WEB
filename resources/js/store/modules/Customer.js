import customerService from '../../service/Customer'

const state = {
  customers: [],
  customer: {
    id_customer:'',
    name_customer: '',
    address_customer: '',
    phone_number_customer: '',

  },
  loading: true,
  error: null
}

const mutations = {
  setSource(state, payload) {
    state.customers = payload
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
  customer: state => state.customer
}

const actions = {
  async get(context) {
    try {
      context.commit('setSource', await customerService.get())
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async store(context, payload) {
    try {
      await customerService.store(payload)
    } catch (err) {
      context.commit('setFailedStore', err)
    }
  },

  async edit(context, id) {
    try {
      const res = await customerService.find(id)
    //   context.commit('setCustomerForm', res)
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async update(context, payload) {
    try {
      const data = {
        name_customer: payload.name_customer,
        address_customer: payload.address_customer,
        phone_number_customer: payload.phone_number_customer,
      }

      await customerService.update(payload.id_customer, data)
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async delete (context, id) {
    try {
      await customerService.delete(id)
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  resetForm(context) {
    context.commit('setCustomerForm', {})
  }
}

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
}