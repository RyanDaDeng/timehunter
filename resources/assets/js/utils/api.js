class Api {
    constructor () {}

    get (url, data = null) {
        return new Promise((resolve, reject) => {
                axios["get"](url, data)
                    .then(response => {
                    resolve(response);
    })
    .catch(({response}) => {
            if (response.status === 401) {
            auth.logout();
            reject(response);
        }

    });
    });
    }

    post (url, data = null) {
        return new Promise((resolve, reject) => {
                axios["post"](url, data)
                    .then(response => {
                    resolve(response);
    })
    .catch(({response}) => {
            if (response.status === 401) {
            auth.logout();
            reject(response);
        }
    });
    });
    }


    delete (url, data = null) {
        return new Promise((resolve, reject) => {
                axios["delete"](url, data)
                    .then(response => {
                    resolve(response);
    })
    .catch(({response}) => {
            if (response.status === 401) {
            auth.logout();
            reject(response);
        }

    });
    });
    }
}

export default Api;