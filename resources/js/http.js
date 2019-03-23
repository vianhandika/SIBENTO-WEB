import axios from 'axios'

export default {
    init () {
        axios.defaults.baseURL = '127.0.0.1';
    },

    get (url, successCallback, errorCallback) {
        return axios.request({
            url,
            method : 'get'
        })
        .then(successCallback)
        .catch(errorCallback)
    },

    post (url, data, successCallback, errorCallback) {
        return axios.request({
            url,
            data,
            method: 'post',
            
        })
        .then(successCallback)
        .catch(errorCallback)
    },

    patch (url, data, successCallback, errorCallback) {
        return axios.request({
            url,
            data,
            method: 'patch'
        })
        .then(successCallback)
        .catch(errorCallback)
    },

    delete(url, successCallback, errorCallback) {
        return axios.request({
            url,
            method: 'delete'
        })
        .then(successCallback)
        .catch(errorCallback)
    }
}