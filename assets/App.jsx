import React from 'react';
import PrivateRoute from "./helpers/PrivateRoute";
import {Router, Switch} from 'react-router-dom';
import {history} from "./helpers/history";
import Dashboard from "./pages/Dashboard";
import GuestRoute from "./helpers/GuestRoute";
import SignIn from "./pages/Authentication/SignIn";
import SignUp from "./pages/Authentication/SignUp";

export default function App() {
    return (
        <Router history={history}>
            <Switch>
                <GuestRoute exact path="/sign-in" component={SignIn}/>
                <GuestRoute exact path="/sign-up" component={SignUp}/>
                <PrivateRoute path="/" component={Dashboard}/>
            </Switch>
        </Router>
    );
}