import React from "react";
import '../assets/css/InputField.css';

export default function InputField(props) {
    const {name, value, onChange, error, label, placeholder, type, isRequired} = props;

    let inputClassName = 'form-control register-form-control';

    if (error) {
        inputClassName += ' error-form-control';
    }

    return (
        <div className="form-group">
            <label htmlFor={name}
                   style={{fontWeight: 500, marginBottom: '.5rem'}}>{label}</label>
            <input name={name}
                   placeholder={placeholder}
                   type={type}
                   className={inputClassName}
                   value={value}
                   onChange={onChange}
                   required={!!isRequired}
            />
            {error &&
                <div style={{color: 'red', fontSize: '9px', marginTop: '5px'}}>{error.message}</div>
            }
        </div>
    );
}