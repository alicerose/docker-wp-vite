/**
 * 現在URLのURLクエリパラメータをオブジェクトにして返す
 */
export const queryParser = () => {
    const query = location.search;
    return getQuery(query).length ? convertToObject(getQuery(query)) : {};
};

const getQuery = (string: string) => {
    const i = string.indexOf('?');
    return (i !== -1) ? string.substring(i + 1) : '';
};

const convertToObject = (string: string) => {
    return Object.fromEntries(string.split('&').map(s => s.split('=')));
};
