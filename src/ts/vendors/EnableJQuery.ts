interface Window {
  $: JQuery
}
declare let window: Window;

export const EnableJQuery = {
  init: () => {
    /**
     * ファイル外からjQueryを参照出来るようにする
     * @type {function(*=): *}
     */
    const $ = (window.$ = require('jquery'));
    console.log('jQuery:', $.fn.jquery);
  },
};

/// <reference path="node_modules/@types/jquery/JQuery.d.ts" />
