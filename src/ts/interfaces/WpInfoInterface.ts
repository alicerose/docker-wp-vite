import { WordPressInfoClass } from '../models/WordPressInfoClass';

export interface WpInfoInterface {
    info: WordPressInfoClass|null,
    init(): string,
    get(): WordPressInfoClass|null,
}
