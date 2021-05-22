import {authenticationConstants} from "../constants/authentication.constants";
import {authenticationService} from "../services/authentication.service";
import {history} from '../helpers/history';

export const authenticationActions = {
    login,
    register,
    clearRegisterState,
    clearLoginState,
    logout,
};

function login(email, password, from) {
    return dispatch => {
        dispatch(request());

        authenticationService.login(email, password).then(
            () => {
                dispatch(success());

                location.href = from.pathname;
            },
            errors => {
                dispatch(failure(errors))
            }
        );
    };

    function request() { return { type: authenticationConstants.LOGIN_REQUEST } }
    function success() { return { type: authenticationConstants.LOGIN_SUCCESS } }
    function failure(responseErrors) {
        let errors = {
            domain: [],
            validation: [],
        };

        if (responseErrors.type === 'DomainError') {
            responseErrors.errors.forEach((element) => {errors.domain.push(element)});
        } else {
            responseErrors.errors.forEach((element) => {errors.validation[element.propertyPath] = element});
        }

        return { type: authenticationConstants.LOGIN_FAILURE, errors }
    }
}

function register(email, username, password) {
    return dispatch => {
        dispatch(request(email));

        authenticationService.register(email, username, password).then(
            user => {
                dispatch(success());
                history.push({
                    pathname: '/sign-in',
                    isRegistered: true,
                });
            },
            errors => {
                dispatch(failure(errors));
            }
        )
    };

    function request(user) { return {type: authenticationConstants.REGISTER_REQUEST, user} }
    function success() { return {type: authenticationConstants.REGISTER_SUCCESS} }
    function failure(responseErrors) {
        let errors = {
            domain: [],
            validation: [],
        };

        if (responseErrors.type === 'DomainError') {
            responseErrors.errors.forEach((element) => {errors.domain.push(element)});
        } else {
            responseErrors.errors.forEach((element) => {errors.validation[element.propertyPath] = element});
        }

        return { type: authenticationConstants.REGISTER_FAILURE, errors }
    }
}

function logout() {
    return dispatch => {
        authenticationService.logout().then(
            () => {
                dispatch(success());
                location.reload();
            },
            () => {}
        )
    };

    function success() { return {type: authenticationConstants.LOGOUT} }
}

function clearRegisterState() {
    return dispatch => {dispatch({type: authenticationConstants.REGISTER_CLEAR_STATE})};
}

function clearLoginState() {
    return dispatch => {dispatch({type: authenticationConstants.LOGIN_CLEAR_STATE})};
}
