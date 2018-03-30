class Auth {
    constructor() {
        this.token = window.localStorage.getItem('token');

        let userData = window.localStorage.getItem('user');
        this.user = userData ? JSON.parse(userData) : null;
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + this.token;
    }

    login (token, user) {
        window.localStorage.setItem('token', token);
        window.localStorage.setItem('user', JSON.stringify(user));

        axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;

        this.token = token;
        this.user = user;

        Event.$emit('userLoggedIn');
    }

    logout () {
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + this.token;
        window.localStorage.removeItem('token');
        window.localStorage.removeItem('user');

        this.token = null;
        this.user = null;

        Event.$emit('userLoggedOut');
    }

    check () {
        return !! this.token;
    }
}

export default Auth;