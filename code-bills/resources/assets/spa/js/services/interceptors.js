import store from "../store";
import JwtToken from "./jwt-token";
import appConfig from "./appConfig";

Vue.http.interceptors.push((request, next) => {
    request.headers.set('Authorization', JwtToken.getAuthorizationHeader());
    next();
});

Vue.http.interceptors.push((request, next) => {
    next((response) => {
        if (response.status === 401) { // token invalid
            return JwtToken.refreshToken()
                .then(() => {
                    return Vue.http(request);
                })
                .catch(() => {
                    store.dispatch('clearAuth');
                    window.location.href = appConfig.login_url;
                });
        }
    });
});
