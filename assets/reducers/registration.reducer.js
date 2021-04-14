import { authenticationConstants } from '../constants/authentication.constants';

export function registration(state = {}, action) {
    switch (action.type) {
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