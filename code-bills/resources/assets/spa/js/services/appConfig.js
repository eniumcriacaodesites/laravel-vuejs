import config from "../config";

let localConfig = {
    test: 'TEST'
};

const appConfig = Object.assign({}, config, localConfig);

export default appConfig;
