import React from "react";

export default function Loading() {
    return (
        <div className="my-5 pt-5">
            <div className="container">
                <div className="row">
                    <div className="col-lg-12">
                        <div className="text-center mb-5">
                            <h1 className="loading" style={{fontWeight: 500, fontSize: '5.5rem', lineHeight: 1.2}}>Loading</h1>

                            <div>
                                <i className="bx bx-buoy bx-spin text-primary" style={{fontSize: '12rem'}}/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}