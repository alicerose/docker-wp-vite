import { TextScramblerClass } from '../models/textScramblerClass';

/**
 * テキストスクランブル演出スクリプト
 */

export const TextScrambler = {
  /**
   * 初期化
   * @param selector 対象とするセレクタ
   */
  init(selector = 'h1') {
    const target = document.querySelectorAll(selector);
    target.forEach((element) => {
      if (element.textContent && element.textContent.length) {
        this.exec(element);
      }
    });
  },
  /**
   * textContentが存在していたら実行
   * @param element
   */
  exec(element: Element) {
    if (!element.textContent) return;
    const scrambler = new TextScramblerClass(element);
    scrambler.run();
  },
};

