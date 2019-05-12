import Http from './http'

export default {
    
    //EMPLOYEE AREA
    getallemployee(){
        return new Promise((resolve, reject) => {
            
            const successCallback = (res) => {
                const user = res.data
                resolve(res.data)
            }

            const errorCallback = (err) => {
                reject(err)
    
            }

            Http.get('/api/employee', successCallback, errorCallback)
        })
    },
    addemployee(payload) {
        return new Promise((resolve, reject) => {

            const successCallback = (res) => {
                const data = res.data
                resolve(data)

            }

            const errorCallback = (err) => {
                reject(err)
    
            }

            Http.post('/api/employee', payload, successCallback, errorCallback)
        })
    },
    updateemployee(payload,id){
        return new Promise((resolve, reject) => {
            const successCallback = (res) => {
                const data = res.data
                resolve(data)

            }

            const errorCallback = (err) => {
                reject(err)

            }

            Http.patch('/api/employee/'+id, payload, successCallback, errorCallback)
        })
    },
    deleteemployee(id){
        return new Promise((resolve, reject) => {
            const successCallback = (res) => {
                const data = res.data
                resolve(data)

            }

            const errorCallback = (err) => {
                reject(err)

            }

            Http.delete('/api/employee/'+id, successCallback, errorCallback)
        })
    },

    //BRANCH AND ROLE AREA
    getallbranch(){
        return new Promise((resolve, reject) => {
            
            const successCallback = (res) => {
                const data = res.data
                resolve(data)
            }

            const errorCallback = (err) => {
                reject(err)
    
            }

            Http.get('/api/branch', successCallback, errorCallback)
        })
    },
    getallrole(){
        return new Promise((resolve, reject) => {
            
            const successCallback = (res) => {
                const data = res.data
                resolve(data)
            }

            const errorCallback = (err) => {
                reject(err)
    
            }

            Http.get('/api/role', successCallback, errorCallback)
        })
    },

    //USER AREA
    getalluser(){
        return new Promise((resolve, reject) => {
            
            const successCallback = (res) => {
                const data = res.data
                resolve(data)
            }

            const errorCallback = (err) => {
                reject(err)
    
            }

            Http.get('/api/user', successCallback, errorCallback)
        })
    },
    deleteuser(id){
        return new Promise((resolve, reject) => {
            const successCallback = (res) => {
                const data = res.data
                resolve(data)

            }

            const errorCallback = (err) => {
                reject(err)

            }

            Http.delete('/api/user/'+id, successCallback, errorCallback)
        })
    },
    getallspareparttype(){
        return new Promise((resolve, reject) => {
            
            const successCallback = (res) => {
                const data = res.data
                resolve(data.data)
            }

            const errorCallback = (err) => {
                reject(err)
    
            }

            Http.get('/api/spareparttype', successCallback, errorCallback)
        })
    },
    getallmotortype(){
        return new Promise((resolve, reject) => {
            
            const successCallback = (res) => {
                const data = res.data
                resolve(data.data)
            }

            const errorCallback = (err) => {
                reject(err)
    
            }

            Http.get('/api/motortype', successCallback, errorCallback)
        })
    },
    getallmotorbrand(){
        return new Promise((resolve, reject) => {
            
            const successCallback = (res) => {
                const data = res.data
                resolve(data.data)
            }

            const errorCallback = (err) => {
                reject(err)
    
            }

            Http.get('/api/motorbrand', successCallback, errorCallback)
        })
    },
    changepassword(payload,id) {
        return new Promise((resolve, reject) => {

            const successCallback = (res) => {
                const data = res.data
                resolve(data)

            }

            const errorCallback = (err) => {
                reject(err)
    
            }

            Http.patch('/api/user/changepassword/'+id, payload, successCallback, errorCallback)
        })
    },
    updatecompatibility(payload,id) {
        return new Promise((resolve, reject) => {

            const successCallback = (res) => {
                const data = res.data
                resolve(data)

            }

            const errorCallback = (err) => {
                reject(err)
    
            }

            Http.patch('/api/sparepart/updatecompatibility/'+id, payload, successCallback, errorCallback)
        })
    },



    



}