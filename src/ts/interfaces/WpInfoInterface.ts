import { WordPressInfoClass } from '../models/WordPressInfoClass';

export default interface WpInfoInterface {
    info: WordPressInfoClass|null,
    init(): void,
    get(): WordPressInfoClass|null,
};
