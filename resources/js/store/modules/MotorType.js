import motortypeService from '../../service/MotorType'

const state = {
  motortypes: [],
  motortype: {
    id_motorcycle_type:'',
    name_motorcycle_type: '',
    id_motorcycle_brand: '',

  },
  loading: true,
  error: null
}

const mutations = {
  setSource(state, payload) {
    state.motortypes = payload
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
  motortype: state => state.motortype
}

const actions = {
  async get(context) {
    try {
      context.commit('setSource', await motortypeService.get())
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async store(context, payload) {
    try {
      await motortypeService.store(payload)
    } catch (err) {
      context.commit('setFailedStore', err)
    }
  },

  async edit(context, id) {
    try {
      const res = await motortypeService.find(id)
    //   context.commit('setMotorTypeForm', res)
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async update(context, payload) {
    try {
      const data = {
        name_motorcycle_type: payload.name_motorcycle_type,
        id_motorcycle_brand: payload.id_motorcycle_brand,
      }

      await motortypeService.update(payload.id_motorcycle_type, data)
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async delete (context, id) {
    try {
      await motortypeService.delete(id)
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  resetForm(context) {
    context.commit('setMotorTypeForm', {})
  }
}

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
}