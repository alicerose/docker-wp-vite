import axios, { AxiosInstance, AxiosRequestConfig } from 'axios';
import { API_CONFIG } from '../constants/api';

/**
 * AXIOSをどうにかする基底クラス
 */

const apiInstance: AxiosInstance = axios.create({
  ...API_CONFIG,
});

class Response {
  private readonly _status: number;
  private readonly _data: string | [] | Record<string, unknown>;

  constructor(res: {
    status: number;
    data: string | [] | Record<string, unknown>;
  }) {
    this._status = res.status;
    this._data = res.data;
  }

  get code(): number {
    return this._status;
  }

  get success(): boolean {
    return this._status === 200;
  }

  get data() {
    return this._data;
  }
}

/**
 * Request Interceptors
 * リクエスト前に介入する処理を記述
 */
apiInstance.interceptors.request.use(
  (request: AxiosRequestConfig) => {
    console.log('[API] Request:', request);
    return request;
  },
  (error) => {
    console.error('[API] Request', error);
    return Promise.reject(error);
  }
);

/**
 * Response Interceptors
 * レスポンス時に介入する処理を記述
 */
apiInstance.interceptors.response.use(
  (response) => {
    console.log('[API] Response:', response);
    return response;
  },
  (error) => {
    console.error('[API] Response', error);
    return Promise.reject(error);
  }
);

export default abstract class {
  private readonly host: string;

  /**
   * コンストラクタ
   * @param host
   */
  protected constructor(host: string) {
    this.host = host;
  }

  /**
   * リクエストハンドラ
   * @param method
   * @param host
   * @param params
   * @private
   */
  private async request(
    method: 'post' | 'get' | 'put' | 'patch' | 'delete',
    host: string,
    params: { params: null | Record<string, unknown> }
  ) {
    const res = await apiInstance[method](this.host + host, params);
    return new Response(res);
  }

  /**
   * GETメソッド
   * @param endpoint
   * @param params
   */
  protected _get(endpoint: string, params: null | Record<string, unknown>) {
    return this.request('get', endpoint, { params: params });
  }

  /**
   * POSTメソッド
   * @param endpoint
   * @param params
   */
  protected _post(
    endpoint: string,
    params: { params: null | Record<string, unknown> }
  ) {
    return this.request('post', endpoint, params);
  }

  /**
   * PUTメソッド
   * @param endpoint
   * @param params
   */
  protected _put(
    endpoint: string,
    params: { params: null | Record<string, unknown> }
  ) {
    return this.request('put', endpoint, params);
  }

  /**
   * PATCHメソッド
   * @param endpoint
   * @param params
   */
  protected _patch(
    endpoint: string,
    params: { params: null | Record<string, unknown> }
  ) {
    return this.request('patch', endpoint, params);
  }

  /**
   * DELETEメソッド
   * @param endpoint
   * @param params
   */
  protected _delete(
    endpoint: string,
    params: { params: null | Record<string, unknown> }
  ) {
    return this.request('delete', endpoint, params);
  }
}
