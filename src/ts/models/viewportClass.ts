import { BREAKPOINT } from '../constants';

/**
 * Viewport関連を扱うクラス
 */
export class ViewportClass {

    private width: number;
    private height: number;
    private desktop: boolean;

    constructor() {
        this.width = window.innerWidth;
        this.height = window.innerHeight;
        this.desktop = window.innerWidth > BREAKPOINT;
        this.watch();
        this.vhFix();
    }

    /**
     * 画面幅を監視する
     * @private
     */
    private watch() {
        let timer = 0;
        window.addEventListener('resize', () => {
            const isCurrentPC = this.desktop;
            setTimeout(() => {

                if (timer > 0) {
                    clearTimeout(timer);
                }

                timer = window.setTimeout(() => {
                    this.width = window.innerWidth;
                    this.height = window.innerHeight;
                    this.desktop = window.innerWidth > BREAKPOINT;

                    this.screenSizeModified();

                    if (this.desktop !== isCurrentPC) {
                        this.deviceSwitch(isCurrentPC, this.desktop);
                    }
                });
            });
        });
    }


    /**
     * 画面幅変更時にブレイクポイントを跨いだ時のみ実行する処理を登録する
     * @param wasPC 変更前がPCだったかどうか
     * @param isPC 変更後がPCかどうか
     * @private
     */
    private deviceSwitch(wasPC: boolean, isPC: boolean) {
        if (wasPC && !isPC) {
            // PC -> SPになったときの処理
            console.log('[Viewport] PC -> SP');
        }

        if (!wasPC && isPC) {
            // SP -> PCになったときの処理
            console.log('[Viewport] SP -> PC');
        }

    }

    /**
     * 画面サイズが変わった時に常時実行する処理を登録する
     * @private
     */
    private screenSizeModified() {
        console.log('[Viewport]', this.screenSize);
        this.vhFix();
    }

    /**
     * VHの高さを補正する
     * @private
     */
    private vhFix() {
        const vh = window.innerHeight * 0.01;
        if (!this.desktop) {
            document.documentElement.style.setProperty('--vh', `${vh}px`);
        } else {
            document.documentElement.style.removeProperty('--vh');
        }
    }

    /**
     * 画面幅の取得Getter
     */
    get screenSize() {
        return {
            width  : this.width,
            height : this.height,
            desktop: this.desktop
        };
    }

    /**
     * 現在画面幅がPCかどうかのGetter
     */
    get isPc(): boolean {
        return this.desktop;
    }

    /**
     * 現在画面幅がSPかどうかのGetter
     */
    get isSp(): boolean {
        return !this.desktop;
    }
}
