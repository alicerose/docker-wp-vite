import { ANCHOR_DURATION } from '../constants';
import { easing } from '../vendors/easing';
import { ViewportClass } from './viewportClass';

export default class AnchorClass {
  moveFrom: number;
  moveTo: number;
  progress: number;
  duration: number;
  start: number;
  id: number;

  /**
   *
   * @param target 移動先のY座標
   */
  constructor(target: number) {
    this.moveFrom = document.documentElement.scrollTop;
    this.moveTo = target;
    this.progress = 0;
    this.duration = ANCHOR_DURATION;
    this.start = 0;
    this.id = 0;
  }

  /**
   * スクロール位置の補正値をデバイスごとに決める
   * デフォルトは0（無補正）を返す
   * @private
   */
  private setBuffer(): number {
    const viewport = new ViewportClass();
    if(viewport.isPc) return this.getBufferPC();
    if(viewport.isSp) return this.getBufferSP();
    return 0;
  }

  /**
   * PC時のスクロール位置補正値の算出
   * サンプルではヘッダーの高さを補正値として取得してreturnする
   * @private
   */
  private getBufferPC(): number {
    const header = document.getElementById('global-header') ?? null;
    if(!header) return 0;
    const rect = header.getBoundingClientRect();
    return rect.height;
  }

  /**
   * SP時のスクロール位置補正値の算出
   * サンプルではヘッダーの高さを補正値として取得してreturnする
   * @private
   */
  private getBufferSP(): number {
    const header = document.getElementById('global-header') ?? null;
    if(!header) return 0;
    const rect = header.getBoundingClientRect();
    return rect.height;
  }

  /**
   * 移動中の処理
   * @private
   */
  private action() {
    const progress = Math.min(1, (Date.now() - this.start) / this.duration);
    const distance = this.moveTo - this.moveFrom - this.setBuffer();
    const moveToY = this.moveFrom + distance * easing.outQuart(progress);
    window.scrollTo(0, moveToY);
    console.log('[Anchor] progress:', progress, 'to:', moveToY);

    if (progress < 1) {
      this.id = requestAnimationFrame(() => {
        this.action();
      });
    }
  }

  /**
   * 移動開始
   */
  run() {
    this.start = Date.now();
    this.moveFrom = document.documentElement.scrollTop;
    this.action();
  }
}
