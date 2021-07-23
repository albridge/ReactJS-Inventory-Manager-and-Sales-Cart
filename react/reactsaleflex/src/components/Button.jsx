import React from 'react'

const Button = ({ type, value, classN, onclick }) => {
    return (
        <div style={{float:'right'}}>
            <input type={type} value={value} className={classN} onClick={onclick} />
        </div>
    )
}

export default Button
