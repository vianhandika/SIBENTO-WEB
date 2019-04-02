import motorcustomerService from '../../service/MotorCustomer'

const state = {
  motorcustomers: [],
  motorcustomer: {
    id_motorcycle:'',
    plate_number: '',
    id_motorcycle_type: '',
    id_customer: '',


  },
  loading: true,
  error: null
}

const mutations = {
  setSource(state, payload) {
    state.motorcustomers = payload
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
  motorcustomer: state => state.motorcustomer
}

const actions = {
  async get(context) {
    try {
      context.commit('setSource', await motorcustomerService.get())
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async store(context, payload) {
    try {
      await motorcustomerService.store(payload)
    } catch (err) {
      context.commit('setFailedStore', err)
    }
  },

  async edit(context, id) {
    try {
      const res = await motorcustomerService.find(id)
    //   context.commit('setMotorCustomerForm', res)
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async update(context, payload) {
    try {
      const data = {
        plate_number: payload.plate_number,
        id_motorcycle_type: payload.id_motorcycle_type,
        id_customer: payload.id_customer,
      }

      await motorcustomerService.update(payload.id_motorcycle, data)
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async delete (context, id) {
    try {
      await motorcustomerService.delete(id)
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  resetForm(context) {
    context.commit('setMotorCustomerForm', {})
  }
}

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
}