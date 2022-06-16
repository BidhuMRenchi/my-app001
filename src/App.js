
import Login from "./components/auth/login";
import Home from "./components/home";
import { BrowserRouter, Routes, Route } from "react-router-dom";
import "./App.css";

function App() {
  return (
    <>
      <BrowserRouter>
        <Routes>
          <Route path="/" element={<Login />} />
          <Route path="home" element={<Home />} />
        </Routes>
      </BrowserRouter>

      {/* <div className="App" style={{ backgroundColor: "lightblue" }}>
        <h1 style={{ color: "hsl(194, 86%, 44%)" }}>BIODATA</h1>
        <p>
          Name: Bidhu M Renchi<br></br>
          Father's name: Renchi Thomas<br></br>
          Mothers's name: Alice Renchi<br></br>
          DOB: 09:04:1998<br></br>
          Address: Chennai-19<br></br>
          Mobile no: 1234566543<br></br>
          Religion: Christian<br></br>
          Nationality: Indian<br></br>
          Gender: Male<br></br>
          Qualification: BTech<br></br>
        </p>
        <table>
          <tr>
            <th>Semester</th>
            <th>Grade</th>
            <th>CGPA %</th>
          </tr>
          <tr>
            <th>1</th>
            <th>S</th>
            <th>80</th>
          </tr>
          <tr>
            <th>2</th>
            <th>A</th>
            <th>78</th>
          </tr>
        </table>
        `
      </div> */}
    </>
  );
}

export default App;
