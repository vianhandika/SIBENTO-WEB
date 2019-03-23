import http from './Http'

export default {
  async get () {
    try {
      const res = await http.get('/api/role')
      
      return res.data.data
    } catch (err) {
      throw new Error(err)
    }
  },

//   async store (payload) {
//     try {
//       await http.post('/api/role', payload)
//     } catch (err) {
//       throw new Error(err)
//     }
//   },

//   async find (id) {
//     try {
//       const res = await http.get(`/api/role/${id}`)
      
//       return res.data.data
//     } catch (err) {
//       throw new Error(err)
//     }
//   },

//   async update (id, payload) {
//     try {
//       const res = await http.patch(`/api/role/${id}`, payload)

//       return res.data.data
//     } catch (err) {
//       throw new Error('Gagal update data role!')
//     }
//   },

//   async delete (id) {
//     try {
//       await http.delete(`/api/roles/${id}`)
//     } catch (err) {
//       throw new Error('Gagal hapus data role')
//     }
//   }
}
