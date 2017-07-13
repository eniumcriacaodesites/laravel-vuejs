import JwtToken from "./services/jwt-token";
import LocalStorage from "./services/localStorage";
import {User} from "./services/resource";
import Vuex from "vuex";

const USER = 'user';

const state = {
    user: LocalStorage.getObject(USER) || {name: ''},
    check: JwtToken.token != null
};

const mutations = {
    setUser(state, user) {
        state.user = user;
        LocalStorage.setObject(USER, user);
    },
    authenticated(state) {
        state.check = true;
    }
};

const actions = {
    login(context, {email, password}) {
        return JwtToken.accessToken(email, password).then(response => {
            context.commit('authenticated');
            context.dispatch('getUser');

            return response;
        });
    },
    getUser(context) {
        return User.get().then((response) => {
            context.commit('setUser', response.data);
        });
    }
};

export default new Vuex.Store({state, mutations, actions});
