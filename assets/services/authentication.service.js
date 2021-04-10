import axios from "axios";

export const authenticationService = {
    login,
    isUserLoggedIn,
    register,
};

function login(email, password) {
    return axios.post('/api/v1/accounts/sign-in', {
        email: email,
        password: password,
    })
        .then(handleResponse)
        .then(user => {
            localStorage.setItem('token', user.token);

            return user;
        })
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

function isUserLoggedIn() {
    return localStorage.getItem('token') !== null;
}

function handleResponse(response) {
    return response.data;
}

function handleNoContentResponse(response) {
    return response;
}

function handleError(error) {
    console.log(error);
    const response = error.response;

    if (response.status === 401) {
        // auto logout if 401 response returned from api
        // logout();
        // location.reload(true);

        // TODO: implement auto logout
    }

    return Promise.reject(response.data);
}
