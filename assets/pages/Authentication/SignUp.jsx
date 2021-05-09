import React, {useEffect, useState} from 'react';
import {authenticationActions} from "../../actions/authentication.actions";
import {useDispatch, useSelector} from "react-redux";
import {history} from "../../helpers/history";
import InputField from "./components/InputField";
import SubmitButton from "./components/SubmitButton";
import CardHeader from "./components/CardHeader";
import CardBodyTitle from "./components/CardBodyTitle";
import Alert from "./components/Alert";
import UnderCardBlock from "./components/UnderCardBlock";

const SignUp = () => {
    const dispatch = useDispatch();
    const errors = useSelector(state => state.authentication.signUp.errors);
    const isLoading = useSelector(state => state.authentication.signUp.isLoading);

    useEffect(() => {
        return history.listen((location) => {
            dispatch(authenticationActions.clearRegisterState());
        });
    },[history]);

    const handleChange = (e) => {
        const {name, value} = e.target;
        setInputs(inputs =>({ ...inputs, [name]: value}));
    }

    const handleSubmit = (e) => {
        e.preventDefault();

        if (email && password && username) {
            dispatch(authenticationActions.register(email, username, password));
        }
    }

    const [inputs, setInputs] = useState({
        email: '',
        username: '',
        password: '',
    });
    const {email, username, password} = inputs;

    return (
        <div className="my-5 pt-sm-5">
            <div className="container">
                <div className="justify-content-center row">
                    <div className="col-md-8 col-lg-6 col-xl-5">
                        <div className="overflow-hidden card">
                            <CardHeader/>
                            <div className="pt-0 card-body">
                                <CardBodyTitle
                                    title="Start your adventure now!"
                                    description="Get your free account"
                                />

                                <div className="p-2">
                                    {errors?.domain.length > 0 && <Alert type="error" message={errors.domain[0].message} />}

                                    <form className="form-horizontal" onSubmit={handleSubmit}>
                                        <div className="mb-3">
                                            <InputField
                                                name="email"
                                                type="email"
                                                label="Email"
                                                placeholder="Enter email"
                                                value={email}
                                                onChange={handleChange}
                                                error={errors?.validation?.email}
                                                isRequired={true}
                                            />
                                        </div>
                                        <div className="mb-3">
                                            <InputField
                                                name="username"
                                                type="text"
                                                label="Username"
                                                placeholder="Enter username"
                                                value={username}
                                                onChange={handleChange}
                                                error={errors?.validation?.username}
                                                isRequired={true}
                                            />
                                        </div>
                                        <div className="mb-3">
                                            <InputField
                                                name="password"
                                                type="password"
                                                label="Password"
                                                placeholder="Enter password"
                                                value={password}
                                                onChange={handleChange}
                                                error={errors?.validation?.password}
                                                isRequired={true}
                                            />
                                        </div>

                                        <div className="mt-5 d-grid">
                                            <SubmitButton isLoading={isLoading} label="Signup"/>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <UnderCardBlock
                            message="Already have an account?"
                            link={{pathname: '/sign-in', label: 'Sign in'}}
                        />
                    </div>
                </div>
            </div>
        </div>
    );
}

export default SignUp;