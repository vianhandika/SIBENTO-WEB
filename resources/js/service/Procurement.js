import http from './Http'

export default {
  async get () {
    try {
      const res = await http.get('/api/procurement')
      
      return res.data.data
    } catch (err) {
      throw new Error('Gagal mendapatkan data procurement!')
    }
  },

  async store (payload) {
    try {
      await http.post('/api/procurement', payload)
    } catch (err) {
      throw new Error('Gagal simpan procurement baru!')
    }
  },

  async find (id) {
    try {
      const res = await http.get(`/api/procurement/${id}`)
      
      return res.data.data
    } catch (err) {
      throw new Error('Gagal mendapatkan data procurement!')
    }
  },

  async update (id, payload) {
    try {
      const res = await http.patch(`/api/procurement/${id}`, payload)

      return res.data.data
    } catch (err) {
      throw new Error('Gagal update data procurement!')
    }
  },

  async delete (id) {
    try {
      await http.delete(`/api/procurement/${id}`)
    } catch (err) {
      throw new Error('Gagal hapus data procurement')
    }
  },
}
