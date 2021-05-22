import axios from "axios";
import settings from "../helpers/application.settings";

export const authenticationService = {
    login,
    register,
    isUserLoggedIn,
    logout,
};

function login(email, password) {
    return axios.post('/api/v1/accounts/sign-in', {
        email: email,
        password: password,
    })
        .then(handleNoContentResponse)
        .catch(handleError);
}

function register(email, username, password) {
    return axios.post('/api/v1/accounts/register', {
        email: email,
        username: username,
        password: password,
    })
        .then(handleNoContentResponse)
        .catch(handleError);
}

function logout() {
    return axios.post('/api/v1/accounts/logout');
}

function isUserLoggedIn() {
    return settings.isAuthenticated || false;
}

function handleNoContentResponse(response) {
    return response;
}

function handleError(error) {
    const response = error.response;

    if (response.status === 403) {
        logout();
    }

    return Promise.reject(response.data);
}
