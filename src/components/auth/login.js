import React,{useState} from "react";
import { useNavigate } from "react-router-dom";
import "../../../node_modules/bootstrap/dist/css/bootstrap.min.css";
import "../../../node_modules/bootstrap/dist/js/bootstrap.js";
import "./login.css";


const Login = () => {
  
  const [username, setUser] = useState("");
  const [pass, setPass] = useState("");
  let navigate=useNavigate();

  const submitForm = (e) => {
      e.preventDefault();
      console.log({username},{pass});
      if(username == "bidhu" && pass == "abc"){
        navigate("home");
      }
      else{
        document.getElementById("p").textContent = "Invalid Credentials.. try again.";
        navigate("/");
      }
      

  }

  return (
    <>
      <div className="App"></div>
      <div className="Form">
        <h1>LOGIN</h1>
        <form onSubmit={submitForm}>
          <label>
            User Name :<br></br>
            <input type="text" name="username" value={username} onChange={(e) => setUser(e.target.value)}/>
          </label>
          <br></br>
          <br></br>
          <label>
            Password :<br></br>
            <input type="password" name="pass" value={pass} onChange={(e) => setPass(e.target.value)}/>
          </label>
          <br></br>
          <br></br>
          <input className="btn" type="submit" value="Submit" />
          <p id ="p"></p>
        </form>
      </div>
    </>
  );
}

export default Login;
