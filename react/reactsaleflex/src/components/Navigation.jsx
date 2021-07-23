import React from 'react'
import Header from './Header';

import { Link } from 'react-router-dom';

const Navigation = () => {
    return (
       
        <div>
             <Header />
            
            <div><ul className="nav">
                <li> <Link className="btn btn-primary btn-sm" to="/">Home</Link>

                </li>                

                <li>
                    <Link className="btn btn-primary btn-sm" style={{ marginLeft: 20 }} to="/create">Add Inventory</Link>
                </li>
                <li>
                    <Link className="btn btn-primary btn-sm" style={{ marginLeft: 20 }} to="/search">Shop</Link>
                </li>

                <li>
                    <Link className="btn btn-primary btn-sm" style={{ marginLeft: 20 }} to="/about">About</Link>
                </li>

                <li>
                    <Link className="btn btn-primary btn-sm" style={{ marginLeft: 20 }} to="/salesreport">Sales Report</Link>
                </li>
                
              
             
            </ul></div>
        </div>
    )
}

export default Navigation
