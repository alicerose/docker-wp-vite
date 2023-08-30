import { browsers } from 'ts/types/browsers';
import { os } from 'ts/types/os';

export const UserAgent = {
  init() {
    console.log(new UserAgentClass());
  }
};

class UserAgentClass {
  readonly browser: browsers | unknown;
  readonly os: os | unknown;

  constructor() {
    const ua = window.navigator.userAgent;
    this.browser = this.detectBrowser(ua);
    this.os = this.detectOS(ua);
  }

  /**
   * ブラウザの判定
   * @param ua
   * @private
   */
  private detectBrowser(ua:string) {
    const agent = ua.toLowerCase();

    if((agent.indexOf('chrome') > -1) && (agent.indexOf('edg') === -1) && (agent.indexOf('opr') === -1)){
      return 'chrome';
    }

    if((agent.indexOf('safari') > -1) && (agent.indexOf('chrome') === -1)){
      return 'safari';
    }

    if((agent.indexOf('trident/7') > -1)){
      return 'ie11';
    }

    if((agent.indexOf('msie') > -1) && (agent.indexOf('opr') === -1) && (agent.indexOf('opr') === -1)){
      return 'ie';
    }

    if((agent.indexOf('edg') > -1)){
      return 'edge';
    }

    if((agent.indexOf('firefox') > -1)){
      return 'firefox';
    }

    if((agent.indexOf('opr') > -1)){
      return 'opera';
    }

    return 'other';
  }

  /**
   * OSの判定
   * @param ua
   * @private
   */
  private detectOS(ua:string) {

    const agent = ua.toLowerCase();

    if((agent.indexOf('mac os x') > -1)){
      return 'Mac OS';
    }

    if((agent.indexOf('windows nt') > -1)){
      return 'Windows';
    }

    if((agent.indexOf('iphone') > -1)){
      return 'iOS';
    }

    if((agent.indexOf('android') > -1)){
      return 'Android';
    }

    return 'other';
  }

  /**
   * Chrome
   */
  get isChrome() {
    return this.browser === 'chrome';
  }

  /**
   * Safari
   */
  get isSafari() {
    return this.browser === 'safari';
  }

  /**
   * Internet Explorer 11
   */
  get isIE11() {
    return this.browser === 'ie11';
  }

  /**
   * Microsoft Edge(new)
   */
  get isEdge() {
    return this.browser === 'edge';
  }

  /**
   * FireFox
   */
  get isFireFox() {
    return this.browser === 'firefox';
  }

  /**
   * Opera
   */
  get isOpera() {
    return this.browser === 'opera';
  }

  /**
   * Other
   */
  get isOtherBrowser() {
    return this.browser === 'other';
  }
}
