/**
 * 指定秒数待機
 * @param ms
 */
export const _sleep = ( ms: number ) => new Promise( ( resolve ) => setTimeout( resolve, ms ) );
