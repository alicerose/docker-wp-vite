import { TextScrambler } from './textScrambler';

/**
 * スクロールして描画領域内に入ったときの演出用基底関数
 * IntersectionObserverの名称がバッティングのため代替名で関数化
 */
export const ScrollDetector = {
  config: {
    // スクロール時の監視設定
    root      : null,
    rootMargin: '-30% 0px',
    threshold : 0,
  },
  init(selector = 'h1') {
    const target = document.querySelectorAll(selector);
    const observer = new IntersectionObserver(
      this.detect,
      this.config
    );
    target.forEach((element) => {
      if (element.textContent && element.textContent.length) {
        observer.observe(element);
      }
    });
  },
  /**
   * 交差判定
   * isIntersectingの正否で描画領域内の処理分岐
   * @param entries
   */
  detect(entries:IntersectionObserverEntry[]) {
    entries.forEach(entry => {
      if(entry.isIntersecting) TextScrambler.exec(entry.target);
    });
  },
};
