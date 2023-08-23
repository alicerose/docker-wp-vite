import '@/scss/app.scss';
import { Utilities } from './utilities';
import { WpInfo } from './utilities/wpInfo';
import TestImage from '@/assets/images/sample.png';

Utilities.init();

console.log(WpInfo.get());
console.log(TestImage);