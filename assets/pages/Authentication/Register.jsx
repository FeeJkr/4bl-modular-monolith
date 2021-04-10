import React, {useState} from 'react';
import background from "./background.jpeg";
import {Link} from 'react-router-dom';
import {authenticationActions} from "../../actions/authentication.actions";
import {useDispatch, useSelector} from "react-redux";

export default function Register() {
    const dispatch = useDispatch();
    const [inputs, setInputs] = useState({
        email: '',
        username: '',
        password: '',
    });

    const {email, username, password} = inputs;

    function handleChange(e) {
        const {name, value} = e.target;
        setInputs(inputs =>({ ...inputs, [name]: value}));
    }

    function handleSubmit(e) {
        e.preventDefault();

        if (email && password && username) {
            dispatch(authenticationActions.register(email, username, password));
        }
    }

    const validationErrors = useSelector(state => state.authentication.validationErrors);
    const emailError = validationErrors && validationErrors.errors
        ? validationErrors.errors.find((element) => { return element.propertyPath === 'email' })
        : null;
    const usernameError = validationErrors && validationErrors.errors
        ? validationErrors.errors.find(element => { return element.propertyPath === 'username' })
        : null;
    const passwordError = validationErrors && validationErrors.errors
        ? validationErrors.errors.find(element => { return element.propertyPath === 'password' })
        : null;

    const domainErrors = useSelector(state => state.authentication.domainErrors);

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
                                        <h4>Start your adventure now!</h4>
                                    </div>
                                    Get your free account.
                                </div>
                                <div className="p-2">
                                    {domainErrors &&
                                        <div className="alert alert-danger" role="alert" style={{textAlign: 'center'}}>
                                            {domainErrors.errors[0].message}
                                        </div>
                                    }
                                    <form className="form-horizontal" onSubmit={handleSubmit}>
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
                                                    <div style={{color: 'red', fontSize: '9px'}}>{emailError.message}</div>
                                                }
                                            </div>
                                        </div>
                                        <div className="mb-3">
                                            <div className="form-group">
                                                <label htmlFor="username"
                                                       style={{fontWeight: 500, marginBottom: '.5rem'}}>Username</label>
                                                <input name="username" placeholder="Enter username" id="username"
                                                       type="text" className="form-control" required
                                                       value={username}
                                                       onChange={handleChange}
                                                       style={{fontSize: '.8125rem', padding: '.47rem .75rem', fontWeight: 400, lineHeight: 1.5, border: '1px solid #ced4da'}}/>
                                                {usernameError &&
                                                    <div style={{color: 'red', fontSize: '9px'}}>{usernameError.message}</div>
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
                                                    <div style={{color: 'red', fontSize: '9px'}}>{passwordError.message}</div>
                                                }
                                            </div>
                                        </div>

                                        <div className="mt-5" style={{display: 'grid'}}>
                                            <button className="btn btn-primary btn-block"
                                                    style={{fontSize: '.8125rem', padding: '.47rem .75rem', borderRadius: '.25rem', fontWeight: 400, lineHeight: 1.5}}
                                                    id="sign-in-button">Register
                                            </button>

                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div className="mt-5 text-center" style={{display: 'block'}}>
                            <p style={{display: 'block'}}>
                                <span style={{fontWeight: 300}}>Already have an account? </span>
                                <Link
                                    to={'/sign-in'}
                                    style={{color: '#556ee6', textDecoration: 'none', outline: 'none', fontWeight: 600}}
                                >
                                    Sign In
                                </Link>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}
