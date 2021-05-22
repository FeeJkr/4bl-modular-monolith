import {signIn} from "./sign-in.reducer";
import {signUp} from "./sign-up.reducer";
import {combineReducers} from "redux";

export const authentication = combineReducers({
    signIn,
    signUp,
});