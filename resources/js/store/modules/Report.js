import serviceReport from '../../service/Report'

const state = {
  reports: [],
  loading: true,
  error: null
}

const mutations = {
  setSource(state, payload) {
    state.reports = payload
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
  report: state => state.report
}

const actions = {
  async profitPerMonth(context, year) {
    try {
      context.commit('setSource', await serviceReport.profitPerMonth(year))
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },
  async profitPerYear(context) {
    try {
      context.commit('setSource', await serviceReport.profitPerYear())
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },
  async spendPerMonth(context, year) {
    try {
      context.commit('setSource', await serviceReport.spendPerMonth(year))
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },
  async sparepartTopSell(context, year) {
    try {
      context.commit('setSource', await serviceReport.sparepartTopSell(year))
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },
  async serviceTopSell(context, payload) {
    try {
      context.commit('setSource', await serviceReport.serviceTopSell(payload.year,payload.month))
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },
  async stockSparepart(context, payload) {
    try {
      context.commit('setSource', await serviceReport.stockSparepart(payload.year,payload.sparepart))
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },
  
}

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
}