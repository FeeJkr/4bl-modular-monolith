export const authenticationService = {
    login,
    isUserLoggedIn,
};

function login(email, password) {
    localStorage.setItem('token', 'secret_token');

    return 'secret_token';
}

function isUserLoggedIn() {
    return localStorage.getItem('token') !== null;
}
