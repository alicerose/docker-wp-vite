export class TextScramblerClass {
    element: Element;
    source: string[];
    result: string[];
    loop = 0;
    // スクランブルを書ける時間（ms）
    frames = 30;
    // 動作FPS
    fps = 60;
    // スクランブル中の文字列候補
    pool = ',.?/\\(^)![]{}*&^%$#\'"';

    constructor(element: Element) {
        this.element = element;
        this.source = element.textContent ? element.textContent.split('') : [];
        this.result = [];
        this.frames += this.source.length;
    }

    /**
     * 実行関数
     */
    public run() {
        const arr: string[] = [];
        const pl = this.pool.split('');
        let flag = false;
        this.source.forEach((src: string, i: number) => {
            // ループ終了から逆算した文字列位置ならスクランブル終了フラグを建てる
            flag = this.source.length - i > this.frames - this.loop;
            if (flag || this.loop === this.frames - 1) {
                // 素の文字を配列に戻す
                arr.push(src);
            } else {
                // スクランブルした文字列を配列に戻す
                arr.push(pl[Math.floor(Math.random() * pl.length)]);
            }
        });
        this.result = arr;
        this.reflect();
    }

    /**
     * 描画関数
     * ループ値をインクリメントし、規定ループ数以下なら再実行する
     */
    reflect() {
        // console.log('#' + this.loop, 'reflect', this.source, '=>', this.result.join(''));
        this.element.textContent = this.result.join('');
        this.loop++;
        if (this.loop < this.frames) {
            setTimeout(() => {
                this.run();
            }, 1000 / this.fps);
        } else {
            console.log(this);
        }
    }
}
