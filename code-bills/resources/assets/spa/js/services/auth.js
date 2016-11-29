import {Jwt, User} from "./resource";
import LocalStorage from "./localStorage";

const TOKEN = 'token';
const USER = 'user';

const afterLogin = (response) => {
    User.get().then((response) => LocalStorage.setObject(USER, response.data));
};

const afterLogout = () => {
    LocalStorage.remove(TOKEN);
    LocalStorage.remove(USER);
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
        return Jwt.logout().then(afterLogout()).catch(afterLogout());
    },
    getAuthorizationHeader() {
        return `Bearer ${LocalStorage.get(TOKEN)}`;
    },
    user() {
        return LocalStorage.getObject(USER);
    }
}
