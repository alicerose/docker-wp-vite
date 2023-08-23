import SampleInterface from '../interfaces/SampleInterface';

export default class SampleClass implements SampleInterface {
  [key: string]: number;

  constructor(num1: number) {
    this.num1 = num1;
  }
}
