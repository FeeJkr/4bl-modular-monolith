import React, {useState} from 'react';
import background from './background.jpeg';
import {Link, useLocation} from 'react-router-dom';
import {useDispatch, useSelector} from "react-redux";
import {authenticationActions} from "../../actions/authentication.actions";

export default function SignIn() {
    const [inputs, setInputs] = useState({
        email: '',
        password: '',
    });

    const {email, password} = inputs;
    const domainErrors = useSelector(state => state.authentication.errors);
    const validationErrors = useSelector(state => state.authentication.validationErrors);
    const dispatch = useDispatch();
    const location = useLocation();

    const emailError = validationErrors
        ? validationErrors.find((element) => { return element.propertyPath === 'email'})
        : null;
    const passwordError = validationErrors
        ? validationErrors.find((element) => {return element.propertyPath === 'password'})
        : null;

    function handleChange(e) {
        const { name, value } = e.target;
        setInputs(inputs => ({ ...inputs, [name]: value }));
    }

    function handleSubmit(e) {
        e.preventDefault();

        if (email && password) {
            // get return url from location state or default to home page
            const { from } = location.state || { from: { pathname: "/" } };
            dispatch(authenticationActions.login(email, password, from));
        }
    }

    return (
        <div className="my-5 pt-sm-5">
            <div className="container">
                <div className="justify-content-center row">
                    <div className="col-md-8 col-lg-6 col-xl-5">
                        <div className="overflow-hidden card">
                            <div style={{backgroundColor: 'rgba(85,110,230,.25)'}}>
                                <div className="row">
                                    <img src={background}
                                         style={{maxWidth: '100%', height: 'auto', filter: 'contrast(90%) brightness(90%)'}}/>
                                </div>
                            </div>
                            <div className="pt-0 card-body">
                                <div className="mb-4 mt-3 text-center" style={{height: '4rem'}}>
                                    <div>
                                        <h4>Welcome Back!</h4>
                                    </div>
                                    Sign in to continue.
                                </div>
                                <div className="p-2">
                                    {domainErrors &&
                                        <div className="alert alert-danger" role="alert" style={{textAlign: 'center'}}>
                                            {domainErrors.errors[0].message}
                                        </div>
                                    }
                                    <form className="form-horizontal" id="sign-in-form" onSubmit={handleSubmit}>
                                        <div className="mb-3">
                                            <div className="form-group">
                                                <label htmlFor="email"
                                                       style={{fontWeight: 500, marginBottom: '.5rem'}}>Email</label>
                                                <input name="email" placeholder="Enter email" id="email" type="text"
                                                       className="form-control" required
                                                       value={email}
                                                       onChange={handleChange}
                                                       style={{fontSize: '.8125rem', padding: '.47rem .75rem', fontWeight: 400, lineHeight: 1.5, border: '1px solid #ced4da'}}/>
                                                {emailError &&
                                                    <div style={{fontSize: '10px', color: 'red'}}>{emailError.message}</div>
                                                }
                                            </div>
                                        </div>
                                        <div className="mb-3">
                                            <div className="form-group">
                                                <label htmlFor="password"
                                                       style={{fontWeight: 500, marginBottom: '.5rem'}}>Password</label>
                                                <input name="password" placeholder="Enter password" id="password"
                                                       type="password" className="form-control" required
                                                       value={password}
                                                       onChange={handleChange}
                                                       style={{fontSize: '.8125rem', padding: '.47rem .75rem', fontWeight: 400, lineHeight: 1.5, border: '1px solid #ced4da'}}/>
                                                {passwordError &&
                                                    <div style={{fontSize: '10px', color: 'red'}}>{passwordError.message}</div>
                                                }
                                            </div>
                                        </div>

                                        <div className="mt-5" style={{display: 'grid'}}>
                                            <button type="submit" className="btn btn-primary btn-block"
                                                    style={{fontSize: '.8125rem', padding: '.47rem .75rem', borderRadius: '.25rem', fontWeight: 400, lineHeight: 1.5}}
                                                    id="sign-in-button">Log In
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div className="mt-5 text-center" style={{display: 'block'}}>
                            <p style={{display: 'block'}}>
                                <span style={{fontWeight: 300}}>Don't have an account? </span>
                                <Link
                                    to={'/register'}
                                    style={{color: '#556ee6', textDecoration: 'none', outline: 'none', fontWeight: 600}}
                                >
                                    Signup
                                </Link>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}