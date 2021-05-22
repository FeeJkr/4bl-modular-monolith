import { authenticationConstants } from '../../constants/authentication.constants';

export function signUp(state = {}, action) {
    switch (action.type) {
        case authenticationConstants.REGISTER_REQUEST:
            return {
                isLoading: true,
            };
        case authenticationConstants.REGISTER_SUCCESS:
            return {};
        case authenticationConstants.REGISTER_FAILURE:
            return {
                errors: action.errors,
            };
        case authenticationConstants.REGISTER_CLEAR_STATE:
            return {};

        default:
            return state
    }
}