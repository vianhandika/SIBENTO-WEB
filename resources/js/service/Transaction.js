import http from './Http'

export default {
  async get () {
    try {
      const res = await http.get('/api/transaction')
      
      return res.data.data
    } catch (err) {
      throw new Error('Gagal mendapatkan data transaction!')
    }
  },

  async store (payload) {
    try {
      await http.post('/api/transaction', payload)
    } catch (err) {
      throw new Error('Gagal simpan transaction baru!')
    }
  },

  async find (id) {
    try {
      const res = await http.get(`/api/transaction/${id}`)
      
      return res.data.data
    } catch (err) {
      throw new Error('Gagal mendapatkan data transaction!')
    }
  },

  async update (id, payload) {
    try {
      const res = await http.patch(`/api/transaction/${id}`, payload)

      return res.data.data
    } catch (err) {
      throw new Error('Gagal update data transaction!')
    }
  },

  async payment (id, payload) {
    try {
      const res = await http.patch(`/api/transaction/payment/${id}`, payload)

      return res.data.data
    } catch (err) {
      throw new Error('Gagal update data transaction!')
    }
  },
  
  async delete (id) {
    try {
      await http.delete(`/api/transaction/${id}`)
    } catch (err) {
      throw new Error('Gagal hapus data transaction')
    }
  }
}
