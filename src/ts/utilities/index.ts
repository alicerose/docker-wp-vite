import { Viewport } from './viewport';
import { AnchorLink } from './anchor';
import { UserAgent } from './userAgent';
import { ScrollDetector } from './scrollDetector';
import { WpInfo } from './wpInfo';

export const Utilities = {
    init() {
        const start = Date.now();
        console.log('[DOM] init,', 'duration:', Date.now() - start);
        this.global();

        window.addEventListener('DOMContentLoaded', event => {
            console.log('[DOM] DOMContentLoaded,', 'duration:', Date.now() - start, event);

            // DOMContentLoadedで実行するイベント
            AnchorLink.init();
        });

        window.addEventListener('load', event => {
            console.log('[DOM] load,', 'duration:', Date.now() - start, event);

            // loadで実行するイベント
            console.log(WpInfo.init());
            console.log(WpInfo.get());
        });

        const body: HTMLBodyElement = document.getElementsByTagName('body')[0];
        if (body.dataset.page) this.individual(body.dataset.page);
    },
    /**
   * 全ページで使うユーティリティ
   */
    global() {
        // EnableJQuery.init();
        ScrollDetector.init();
        UserAgent.init();
        Viewport.init();
    },
    /**
   * 個別ページ専用のスクリプトを記述
   * bodyタグのdata-page属性の値に応じたスクリプトを実行する
   * @param id
   */
    individual(id: string) {
        if (id === 'index') {
            console.log('[Util] index page function');
        }
    },
};
