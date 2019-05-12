import http from './Http'

export default {
  async get () {
    try {
      const res = await http.get('/api/motortype')
      
      return res.data.data
    } catch (err) {
      throw new Error(err)
    }
  },

  async store (payload) {
    try {
      await http.post('/api/motortype', payload)
    } catch (err) {
      throw new Error(err)
    }
  },

  async find (id) {
    try {
      const res = await http.get(`/api/motortype/${id}`)
      
      return res.data.data
    } catch (err) {
      throw new Error(err)
    }
  },

  async update (id, payload) {
    try {
      const res = await http.patch(`/api/motortype/${id}`, payload)

      return res.data.data
    } catch (err) {
      throw new Error(err)
    }
  },

  async delete (id) {
    try {
      await http.delete(`/api/motortype/${id}`)
    } catch (err) {
      throw new Error(err)
    }
  }
}
