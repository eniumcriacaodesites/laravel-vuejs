import {Jwt, User} from "./resource";
import LocalStorage from "./localStorage";

const TOKEN = 'token';
const USER = 'user';

const afterLogin = (response) => {
    User.get().then((response) => LocalStorage.setObject(USER, response.data));
};

export default {
    login(email, password) {
        return Jwt.accessToken(email, password).then((response) => {
            LocalStorage.set(TOKEN, response.data.token);
            afterLogin(response);
            return response;
        });
    },
    logout() {
        return Jwt.logout().then(this.clear()).catch(this.clear());
    },
    refreshToken() {
        return Jwt.refreshToken().then((response) => {
            LocalStorage.set(TOKEN, response.data.token);
            return response;
        });
    },
    getAuthorizationHeader() {
        return `Bearer ${LocalStorage.get(TOKEN)}`;
    },
    user() {
        return LocalStorage.getObject(USER);
    },
    check() {
        return LocalStorage.get(TOKEN) ? true : false;
    },
    clear() {
        LocalStorage.remove(TOKEN);
        LocalStorage.remove(USER);
    }
}
