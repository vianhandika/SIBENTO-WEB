import serviceService from '../../service/Service'

const state = {
  services: [],
  service: {
    id_service:'',
    name_service: '',
    price_service: '',
  },
  loading: true,
  error: null
}

const mutations = {
  setSource(state, payload) {
    state.services = payload
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
  service: state => state.service
}

const actions = {
  async get(context) {
    try {
      context.commit('setSource', await serviceService.get())
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async store(context, payload) {
    try {
      await serviceService.store(payload)
    } catch (err) {
      context.commit('setFailedStore', err)
    }
  },

  async edit(context, id) {
    try {
      const res = await serviceService.find(id)
    //   context.commit('setserviceForm', res)
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async update(context, payload) {
    try {
      const data = {
        name_service: payload.name_service,
        price_service: payload.price_service,
      }

      await serviceService.update(payload.id_service, data)
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async delete (context, id) {
    try {
      await serviceService.delete(id)
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  resetForm(context) {
    context.commit('setserviceForm', {})
  }
}

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
}