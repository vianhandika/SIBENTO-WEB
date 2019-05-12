import transactionService from '../../service/Transaction'

const state = {
  transactions: [],
  transaction: {
    id_transaction: '',
    status_process: 'unprocessed',
    status_paid: '',
    type_transaction: '',
    date_transaction: '',
    discount_transaction: 0,
    total_transaction: 0,
    id_customer: '',
    id_service: '',
    id_employee: '',
    service: [],
    sparepart: []
  },
  loading: true,
  error: null
}

const mutations = {
  setSource(state, payload) {
    state.transactions = payload
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
  transaction: state => state.transaction
}

const actions = {
  async get(context) {
    try {
      context.commit('setSource', await transactionService.get())
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async store(context, payload) {
    try {
      await transactionService.store(payload)
    } catch (err) {
      context.commit('setFailedStore', err)
    }
  },

  async edit(context, id) {
    try {
      const res = await transactionService.find(id)
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async update(context, payload) {
    try {
      const data = {
        status_process: payload.status_process,
        id_customer: payload.id_customer,
        type_transaction: payload.type_transaction,
        total_transaction: payload.total_transaction,
        service: payload.service,
        sparepart: payload.sparepart
      }

      await transactionService.update(payload.id_transaction, data)
      state.loading = false
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async payment(context, payload) {
    try {
      const data = {
        discount_transaction: payload.discount_transaction,
        total_transaction: payload.total_transaction,
        employee: payload.employee,
      }

      await transactionService.payment(payload.id_transaction, data)
      state.loading = false
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async delete (context, id) {
    try {
      await transactionService.delete(id)
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