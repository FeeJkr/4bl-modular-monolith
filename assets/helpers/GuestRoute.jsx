import React from 'react';
import { Route, Redirect } from 'react-router-dom';
import {authenticationService} from "../services/authentication.service";

export default function GuestRoute({ component: Component, roles, ...rest }) {
    return (
        <Route {...rest} render={props => {
            if (authenticationService.isUserLoggedIn()) {
                return <Redirect to={{ pathname: '/'}} />
            }

            return <Component {...props} />
        }} />
    );
}
