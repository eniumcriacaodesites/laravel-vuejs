import AppComponent from "./components/App.vue";
import routerMap from "./router.map";
import VueRouter from "vue-router";
import store from "./store/store";

const router = new VueRouter();

router.map(routerMap);

router.beforeEach(({to, next}) => {
    if (to.auth && !store.state.auth.check) {
        return router.go({name: 'auth.login'});
    }

    if (to.name == "auth.login" && store.state.auth.check) {
        return router.go({name: 'dashboard'});
    }

    next();
});

router.start({
    components: {
        'app-component': AppComponent
    }
}, '#app');
