import BaseApi from './BaseApi'
import axios from "axios";

class SkinSearchApi extends BaseApi {
  constructor () {
    super({ name: 'skin-settings' })
    this.url.skins = () => `${this.apiUrl}/skin-settings/find-skins`
  }

  async findSkins(query) {
    return await axios.get(this.url.skins(), {params: {query: query}})
  }
}

export default SkinSearchApi
