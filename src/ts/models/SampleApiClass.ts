import AxiosClass from '../vendors/AxiosClass';

export default class SampleApiClass extends AxiosClass {
  endpoint: string;

  constructor(host: string, endpoint: string) {
    super(host);
    this.endpoint = endpoint;
  }

  async getPosts(params: null | Record<string, unknown> = {}) {
    return await super._get(this.endpoint, params);
  }
}
