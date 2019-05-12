import motorbrandService from '../../service/MotorBrand'

const state = {
  motorbrands: [],
  motorbrand: {
    id_motorcycle_brand:'',
    name_motorcycle_brand: '',
  },
  loading: true,
  error: null
}

const mutations = {
  setSource(state, payload) {
    state.motorbrands = payload
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
  motorbrand: state => state.motorbrand
}

const actions = {
  async get(context) {
    try {
      context.commit('setSource', await motorbrandService.get())
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async store(context, payload) {
    try {
      await motorbrandService.store(payload)
    } catch (err) {
      context.commit('setFailedStore', err)
    }
  },

  async edit(context, id) {
    try {
      const res = await motorbrandService.find(id)
    //   context.commit('setMotorBrandForm', res)
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async update(context, payload) {
    try {
      const data = {
        name_motorcycle_brand: payload.name_motorcycle_brand,
      }

      await motorbrandService.update(payload.id_motorcycle_brand, data)
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async delete (context, id) {
    try {
      await motorbrandService.delete(id)
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  resetForm(context) {
    context.commit('setMotorBrandForm', {})
  }
}

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
}