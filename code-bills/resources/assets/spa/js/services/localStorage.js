export default {
    set(key, value) {
        window.localStorage.setItem(key, value);
        return this.get(key);
    },
    get(key, valueDefault = null) {
        return window.localStorage.getItem(key) || valueDefault;
    },
    setObject(key, value) {
        this.set(key, JSON.stringify(value));
        return this.getObject(key);
    },
    getObject(key, valueDefault = null) {
        let value = this.get(key);
        return (value ? JSON.parse(value) : valueDefault);
    },
    remove(key) {
        window.localStorage.removeItem(key);
    }
}
