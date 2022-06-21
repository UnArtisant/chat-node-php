export const addToUrl = (key, value) => {
    const url = new URL(window.location.href);
    url.searchParams.set(key, value);
    window.history.pushState({}, window.location.title, url);
}

export const getParamsUrl = (key) => {
    const url = new URL(window.location.href);
    return url.searchParams.get(key);
}