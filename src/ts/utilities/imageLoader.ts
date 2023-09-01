export const ImageLoader = {
    init() {
        const thumbs = document.querySelectorAll('[data-src]');

        const options = {
            root       : null,
            rootMargin : '0px 0px',
            threshold  : 0,
        };
        const observer = new IntersectionObserver(ImageLoader.detect, options);

        thumbs.forEach(thumb => {
            observer.observe(thumb);
        });
    },
    detect(entries: IntersectionObserverEntry[], observer: IntersectionObserver) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                ImageLoader.loadImage(entry.target as HTMLImageElement);
                observer.unobserve(entry.target);
            }
        });
    },
    loadImage(ele:HTMLImageElement) {
        const src = ele.dataset.src;
        if(!src) return;
        console.log('[ImageLoader] load  :', src);
        ele.src = src;

        // 読み込み完了したらdata属性を解除
        ele.onload = function () {
            console.log('[ImageLoader] loaded:', src);
            ele.width = ele.naturalWidth;
            ele.height = ele.naturalHeight;

            ele.dataset.src = '';
        };
    },
};
