import Echo from "laravel-echo";
import JwtToken from "./services/jwt-token";

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: '1c6142f2c4baf168f844',
    cluster: 'us2'
});

const changeJwtTokenInEcho = value => {
    window.Echo.connector.pusher.config.auth.headers['Authorization'] = JwtToken.getAuthorizationHeader();
};

JwtToken.event('updateToken', value => {
    changeJwtTokenInEcho(value)
});

changeJwtTokenInEcho(JwtToken.token);
