import {authenticationConstants} from "../constants/authentication.constants";
import {authenticationService} from "../services/authentication.service";
import {history} from '../helpers/history';

export const authenticationActions = {
    login,
    register,
};

function login(email, password, from) {
    return dispatch => {
        dispatch(request(email));

        authenticationService.login(email, password).then(
            user => {
                dispatch(success(user));
                history.push(from);
            },
            errors => {
                dispatch(failure(errors))
            }
        );
    };

    function request(user) { return { type: authenticationConstants.LOGIN_REQUEST, user } }
    function success(user) { return { type: authenticationConstants.LOGIN_SUCCESS, user } }
    function failure(errors) {
        if (errors.type === 'DomainError') {
            return { type: authenticationConstants.LOGIN_FAILURE, errors }
        }

        return { type: authenticationConstants.LOGIN_VALIDATION_FAILURE, errors }
    }
}

function register(email, username, password) {
    return dispatch => {
        dispatch(request(email));

        authenticationService.register(email, username, password).then(
            user => {
                dispatch(success());
                history.push('/sign-in');
            },
            errors => {
                dispatch(failure(errors));
            }
        )
    };

    function request(user) { return {type: authenticationConstants.REGISTER_REQUEST, user} }
    function success() { return {type: authenticationConstants.REGISTER_SUCCESS} }
    function failure(errors) {
        if (errors.type === 'DomainError') {
            return { type: authenticationConstants.REGISTER_FAILURE, errors }
        }

        return { type: authenticationConstants.REGISTER_VALIDATION_FAILURE, errors }
    }
}
