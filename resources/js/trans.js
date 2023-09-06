function __($key) {
    if (typeof window.langJson === 'object') {
        return window.langJson[$key];
    }
    return $key;
}
export default __;
