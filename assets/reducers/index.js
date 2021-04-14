import { combineReducers } from 'redux';
import { authentication } from './authentication.reducer';
import {registration} from "./registration.reducer";
import {companies} from "./companies.reducer";

const rootReducer = combineReducers({
    authentication,
    registration,
    companies,
});

export default rootReducer;