import { useState, useEffect, useContext } from 'react'
const AButton = ({type, value, className, onclick}) => {
    return (
        <div>
            <input type={type} value={value} className={className} onClick={onclick} />
        </div>
    )
}

export default AButton
