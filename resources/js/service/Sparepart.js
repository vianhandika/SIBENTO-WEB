import http from './Http'

export default {
  async get () {
    try {
      const res = await http.get('/api/sparepart')
      
      return res.data.data
    } catch (err) {
      throw new Error(err)
    }
  },

  async store (payload) {
    try {
      await http.post('/api/sparepart', payload)
    } catch (err) {
      throw new Error(err)
    }
  },

  async find (id) {
    try {
      const res = await http.get(`/api/sparepart/${id}`)
      
      return res.data.data
    } catch (err) {
      throw new Error(err)
    }
  },

  async update (id, payload) {
    try {
      const res = await http.patch(`/api/sparepart/${id}`, payload)

      return res.data.data
    } catch (err) {
      throw new Error(err)
    }
  },

  async updateimage (payload) {
    try {
      const res = await http.post(`/api/sparepart/updateimage`, payload)

      return res.data.data
    } catch (err) {
      throw new Error(err)
    }
  },

  async delete (id) {
    try {
      await http.delete(`/api/sparepart/${id}`)
    } catch (err) {
      throw new Error(err)
    }
  }
}
