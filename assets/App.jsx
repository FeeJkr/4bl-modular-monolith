import React from 'react';
import PrivateRoute from "./helpers/PrivateRoute";
import { Router, Route, Switch, Redirect } from 'react-router-dom';
import {history} from "./helpers/history";
import Dashboard from "./pages/Dashboard";
import Register from './pages/Authentication/Register';
import SignIn from './pages/Authentication/SignIn';
import GuestRoute from "./helpers/GuestRoute";

export default function App() {
    return (
        <Router history={history}>
            <Switch>
                <GuestRoute path="/sign-in" component={SignIn}/>
                <GuestRoute path="/register" component={Register}/>
                <PrivateRoute path="/" component={Dashboard}/>
            </Switch>
        </Router>
    );
}