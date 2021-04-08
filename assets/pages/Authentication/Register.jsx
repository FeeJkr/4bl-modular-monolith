import React from 'react';
import background from "./background.jpeg";
import {Link} from 'react-router-dom';

export default function Register() {
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
                                    <form className="form-horizontal" id="sign-in-form">
                                        <div className="mb-3">
                                            <div className="form-group">
                                                <label htmlFor="email"
                                                       style={{fontWeight: 500, marginBottom: '.5rem'}}>Email</label>
                                                <input name="email" placeholder="Enter email" id="email" type="text"
                                                       className="form-control" required
                                                       style={{fontSize: '.8125rem', padding: '.47rem .75rem', fontWeight: 400, lineHeight: 1.5, border: '1px solid #ced4da'}}/>
                                            </div>
                                        </div>
                                        <div className="mb-3">
                                            <div className="form-group">
                                                <label htmlFor="username"
                                                       style={{fontWeight: 500, marginBottom: '.5rem'}}>Username</label>
                                                <input name="username" placeholder="Enter username" id="username"
                                                       type="text" className="form-control" required
                                                       style={{fontSize: '.8125rem', padding: '.47rem .75rem', fontWeight: 400, lineHeight: 1.5, border: '1px solid #ced4da'}}/>
                                            </div>
                                        </div>
                                        <div className="mb-3">
                                            <div className="form-group">
                                                <label htmlFor="password"
                                                       style={{fontWeight: 500, marginBottom: '.5rem'}}>Password</label>
                                                <input name="password" placeholder="Enter password" id="password"
                                                       type="password" className="form-control" required
                                                       style={{fontSize: '.8125rem', padding: '.47rem .75rem', fontWeight: 400, lineHeight: 1.5, border: '1px solid #ced4da'}}/>
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