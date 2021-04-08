import React from 'react';
import { Route, Redirect } from 'react-router-dom';
import {authenticationService} from "../services/authentication.service";

function PrivateRoute({ component: Component, roles, ...rest }) {
    return (
        <Route {...rest} render={props => {
            if (authenticationService.isUserLoggedIn()) {
                return <Component {...props} />
            }

            return <Redirect to={{ pathname: '/sign-in', state: { from: props.location } }} />
        }} />
    );
}

export default PrivateRoute;