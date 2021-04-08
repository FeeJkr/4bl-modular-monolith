import { authenticationConstants } from '../constants/authentication.constants';

let token = localStorage.getItem('user');
const initialState = token ? { loggedIn: true, token: token } : {};

export function authentication(state = initialState, action) {
    switch (action.type) {
        case authenticationConstants.LOGIN_REQUEST:
            return {
                loggingIn: true,
                token: action.token
            };
        case authenticationConstants.LOGIN_SUCCESS:
            return {
                loggedIn: true,
                token: action.token
            };
        case authenticationConstants.LOGIN_FAILURE:
            return {};
        case authenticationConstants.LOGOUT:
            return {};
        default:
            return state
    }
}