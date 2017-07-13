import JwtToken from "./services/jwt-token";
import LocalStorage from "./services/localStorage";
import Vuex from "vuex";

const USER = 'user';

const state = {
    user: LocalStorage.getObject(USER),
    check: JwtToken.token != null
};

export default new Vuex.Store({state});
