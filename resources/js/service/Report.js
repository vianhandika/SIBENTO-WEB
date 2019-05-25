import http from './Http'

export default {
  async profitPerMonth(year) {
    try {
        const res = await http.get(`/api/report/profitmonth-data/${year}`)
      
      return res.data
    } catch (err) {
      throw new Error(err)
    }
  },
  async profitPerYear() {
    try {
        const res = await http.get(`/api/report/profityear-data`)
      
      return res.data
    } catch (err) {
      throw new Error(err)
    }
  },
  async spendPerMonth(year) {
    try {
        const res = await http.get(`/api/report/spendmonth-data/${year}`)
      
      return res.data
    } catch (err) {
      throw new Error(err)
    }
  },
  async sparepartTopSell(year) {
    try {
        const res = await http.get(`/api/report/topsell-sparepart-data/${year}`)
      
      return res.data
    } catch (err) {
      throw new Error(err)
    }
  },
  async serviceTopSell(year,month) {
    try {
        const res = await http.get(`/api/report/topsell-service-data/${year}/${month}`)
      
      return res.data
    } catch (err) {
      throw new Error(err)
    }
  },
  async stockSparepart(year,sparepart) {
    try {
        const res = await http.get(`/api/report/stock-sparepart-data/${year}/${sparepart}`)
      
      return res.data
    } catch (err) {
      throw new Error(err)
    }
  },

}
