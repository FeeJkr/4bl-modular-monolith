import {authenticationConstants} from "../constants/authentication.constants";
import {authenticationService} from "../services/authentication.service";
import {history} from '../helpers/history';

export const authenticationActions = {
    login,
};

function login(username, password, from) {
    return dispatch => {
        dispatch(request(username));

        let result = authenticationService.login(username, password);
        dispatch(success(result));
        history.push(from);
    };

    function request(user) { return { type: authenticationConstants.LOGIN_REQUEST, user } }
    function success(user) { return { type: authenticationConstants.LOGIN_SUCCESS, user } }
}