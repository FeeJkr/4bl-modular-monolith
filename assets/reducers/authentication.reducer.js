import { authenticationConstants } from '../constants/authentication.constants';

let token = localStorage.getItem('user');
const initialState = token ? { loggedIn: true, token: token } : {};

export function authentication(state = initialState, action) {
    switch (action.type) {
        case authenticationConstants.LOGIN_REQUEST:
            return {
                loggingIn: true,
            };
        case authenticationConstants.LOGIN_SUCCESS:
            return {
                loggedIn: true,
                token: action.token
            };
        case authenticationConstants.LOGIN_FAILURE:
            return {
                errors: action.errors,
            };
        case authenticationConstants.LOGIN_VALIDATION_FAILURE:
            return {
                validationErrors: action.errors,
            };
        case authenticationConstants.LOGOUT:
            return {};

        case authenticationConstants.REGISTER_REQUEST:
            return {
                registerProcessWasStarted: true,
            };
        case authenticationConstants.REGISTER_SUCCESS:
            return {
                registerProcessWasFinished: true,
            };
        case authenticationConstants.REGISTER_FAILURE:
            return {
                domainErrors: action.errors,
            };
        case authenticationConstants.REGISTER_VALIDATION_FAILURE:
            return {
                validationErrors: action.errors,
            };

        default:
            return state
    }
}