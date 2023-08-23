import AnchorClass from '../models/AnchorClass';

export const AnchorLink = {
  /**
   * 初期化
   */
  init() {
    const elements:NodeListOf<HTMLAnchorElement> = document.querySelectorAll('a[href^=\'#\']');
    elements.forEach((element: HTMLAnchorElement) => {
      if (element.hash.indexOf('#') === 0) {
        element.addEventListener('click', this.detect, false);
      }
    });
  },
  /**
   * 移動先IDが存在するかの判定
   * 移動先が存在しなかったら0（＝トップ）を返す
   */
  detect(e: Event) {
    e.preventDefault();
    const ele = e.target as HTMLAnchorElement;
    const hash = ele.hash;
    const target = document.getElementById(hash.replace('#', ''));
    if (!target) {
      AnchorLink.execute(0);
      return;
    }
    const pos = target.getBoundingClientRect();
    AnchorLink.execute(pos.top + document.documentElement.scrollTop);
  },
  /**
   * インスタンスを生成して移動開始
   * @param position
   */
  execute(position: number) {
    const anchor = new AnchorClass(position);
    anchor.run();
  },
};
