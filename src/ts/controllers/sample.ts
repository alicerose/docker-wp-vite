import { WpInfo } from '../utilities/wpInfo';
import TestImage from '*.png';

export const SampleScripts =  {
    init() {
        console.log(WpInfo.get());
        console.log(TestImage);
    }
};
