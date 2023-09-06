function __($key) {
    if (
        typeof window.langJson === "object" &&
        typeof window.langJson[$key] !== "undefined"
    ) {
        return window.langJson[$key];
    }
    return $key;
}
export default __;
