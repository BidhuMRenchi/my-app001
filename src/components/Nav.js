import React from "react";
import App from "../App";
import "./home.css";
import { useNavigate,Link } from "react-router-dom";

function Nav(){
    const handleChange = e => {
      };
    let navigate = useNavigate();
    return (
        <nav>
            <h3>Zam Zam</h3>
            
            <ul className="list01">
                <li onClick={()=>navigate("/")}>LOGOUT</li>
            </ul>
            
        </nav>
    );
}

export default Nav;