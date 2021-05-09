import { authenticationConstants } from '../../constants/authentication.constants';

export function signIn(state = {}, action) {
    switch (action.type) {
        case authenticationConstants.LOGIN_REQUEST:
            return {
                loggingIn: true,
            };
        case authenticationConstants.LOGIN_SUCCESS:
            return {
                loggedIn: true,
            };
        case authenticationConstants.LOGIN_FAILURE:
            return {
                errors: action.errors,
            };
        case authenticationConstants.LOGIN_CLEAR_STATE:
            return {};
        case authenticationConstants.LOGOUT:
            return {};

        default:
            return state
    }
}