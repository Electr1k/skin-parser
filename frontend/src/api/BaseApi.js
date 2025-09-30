import axios from 'axios'

class BaseApi {
  constructor (data = {}) {
    this.apiUrl = process.env.VUE_APP_BASE_URL_API + '/api/v1'
    this.name = data.name

    this.url = {
      index: () => `${this.apiUrl}/${data.name}`,
      show: (id) => `${this.apiUrl}/${data.name}/${id}`,
      store: () => `${this.apiUrl}/${data.name}`,
      update: (id) => `${this.apiUrl}/${data.name}/${id}`,
      delete: (id) => `${this.apiUrl}/${data.name}/${id}`,
    }
  }

  async index(params = null) {
    return await axios.get(this.url.index(), params)
  }

  async update(id, data){
    return await axios.put(this.url.update(id), data)
  }

  async store(data){
    return await axios.post(this.url.store(), data)
  }
}

export default BaseApi
