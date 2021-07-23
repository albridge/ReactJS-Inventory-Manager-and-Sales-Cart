import React from 'react'

const Field = ({ name, type, placeholder, value, changed, cname, size }) => {

    return (
        <div className="">
            <input type={type} name={name} value={value} className={cname} placeholder={placeholder} onChange={changed} size={size} autoComplete="off"  />
        </div>
    )
}

// Field.defaultProps{

// }

export default Field
