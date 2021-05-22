import React from 'react';
import '../assets/css/SubmitButton.css';

export default function SubmitButton(props) {
    if (props.isLoading) {
        return (
            <button className="btn btn-primary btn-block btn-default" disabled>
                <i className="bi bi-arrow-clockwise icon-spin btn-icon"/>
                Loading...
            </button>
        );
    }

    return (
        <button className="btn btn-primary btn-block btn-default">
            {props.label}
        </button>
    );
}