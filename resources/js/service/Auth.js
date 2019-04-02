import Http from './Http'
import Store from '../store'
import Cookie from 'js-cookie'
import { routes } from '../routes'

export default {
  async authenticate ({ username, password }) {
    try {
      const res = await Http.post('/api/authenticate', {
        username,
        password
      })

      const accessToken = {
        username: res.data.data.session_username,
        password: res.data.data.session_password
      }
      
      Http.setHeader(accessToken)
      Cookie.set('accessToken', accessToken)

      Store.commit('LoggedUser/setLoggedUser', await this.session())
    } catch (err) {
      throw new Error('username / password salah')
    }
  },

  async session () {
    try {
      const res = await Http.get('/api/session')

      return res.data.data
    } catch (err) {
      if (err.response.status === 401) {
        routes.push({ name: 'Login' })
      } else {
        throw new Error('Failed fetch authenticated user')
      }
    }
  },

  async refresh () {
    const accessToken = Cookie.get('accessToken')

    if (typeof accessToken === 'undefined') {
      throw new Error('Access token not exist')
    }

    Http.setHeader(JSON.parse(accessToken))
    Store.commit('LoggedUser/setLoggedUser', await this.session())
  },

  logout () {
    Store.commit('LoggedUser/setLoggedUser', {})
    Store.commit('LoggedUser/loggedOut')
    Cookie.remove('accessToken')
  },

  getToken () {
    return typeof Cookie.get('accessToken') !== 'undefined'
  }
}