import http from './Http'

export default {
  async get () {
    try {
      const res = await http.get('/api/motorcustomer')
      
      return res.data.data
    } catch (err) {
      throw new Error(err)
    }
  },

  async store (payload) {
    try {
      await http.post('/api/motorcustomer', payload)
    } catch (err) {
      throw new Error(err)
    }
  },

  async find (id) {
    try {
      const res = await http.get(`/api/motorcustomer/${id}`)
      
      return res.data.data
    } catch (err) {
      throw new Error(err)
    }
  },

  async update (id, payload) {
    try {
      const res = await http.patch(`/api/motorcustomer/${id}`, payload)

      return res.data.data
    } catch (err) {
      throw new Error(err)
    }
  },

  async delete (id) {
    try {
      await http.delete(`/api/motorcustomer/${id}`)
    } catch (err) {
      throw new Error(err)
    }
  }
}
