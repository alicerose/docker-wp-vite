import { WordPressInfoClass } from '../models/WordPressInfoClass';
import WpInfoInterface from '../interfaces/WpInfoInterface';

export const WpInfo:WpInfoInterface = {
    info: null,

    init() {
        const body = document.querySelector('body');
        if(body) this.info = new WordPressInfoClass(Array.from(body.classList));
    },
    get() {
        return this.info;
    }
};
