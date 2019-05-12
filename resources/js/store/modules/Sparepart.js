import sparepartService from '../../service/Sparepart'

const state = {
  spareparts: [],
  sparepart: {
    id_sparepart:'',
    name_sparepart: '',
    brand_sparepart: '',
    stock_sparepart:'',
    minimal_stock_sparepart: '',
    buy_price: '',
    sell_price:'',
    placement: '',
    image_sparepart: '',
    id_sparepart_type:'',
  },
  loading: true,
  error: null
}

const mutations = {
  setSource(state, payload) {
    state.spareparts = payload
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
  sparepart: state => state.sparepart
}

const actions = {
  async get(context) {
    try {
      context.commit('setSource', await sparepartService.get())
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async store(context, payload) {
    try {
      await sparepartService.store(payload)
    } catch (err) {
      context.commit('setFailedStore', err)
    }
  },

  async edit(context, id) {
    try {
      const res = await sparepartService.find(id)
    //   context.commit('setsparepartForm', res)
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async update(context, payload) {
    try {
      // return payload
      await sparepartService.update(payload.id_sparepart, payload)

    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async delete (context, id) {
    try {
      await sparepartService.delete(id)
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async updateimage(context, payload){
    try {
      await sparepartService.updateimage(payload)
    } catch (err) {
      context.commit('setFailedStore', err)
    }
  },

  async sparepartverify(context, payload){
    try {
      await sparepartService.sparepartverify(payload)
    } catch (err) {
      context.commit('setFailedStore', err)
    }
  },

  resetForm(context) {
    context.commit('setsparepartForm', {})
  }
}

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
}