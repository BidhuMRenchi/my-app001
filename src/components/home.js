import React,{useState,useEffect} from "react";
import "../../node_modules/bootstrap/dist/css/bootstrap.min.css";
import "../../node_modules/bootstrap/dist/js/bootstrap.js";
import "./home.css";
import Nav from "./Nav";

function Home() {
  const [search, setSearch] = useState("");
  const [sdata, setData] = useState(null);
  let count = 0;
  const searchItems = () => {
        
  }

  useEffect(() => {
      fetch('https://jsonplaceholder.typicode.com/todos')
      .then(response => response.json())
      .then((data) => setData(data))
      .then(data => console.log(data));
      
  }, []);

  const handleSearch = (event) => {
    let value = event.target.value.toLowerCase();
    let result = [];
    console.log(value);
    result = sdata.filter((datas) => {
    return datas.title.search(value) != -1;
    });
    console.log(result);
    setSearch(result);
    
    }

  return (
    <>
      <div className="App"></div>
      <Nav/>
      <div className="Form">

        <h1>HOME PAGE</h1>
        Search Here : &nbsp;
        <input 
          className="pa3 bb br3 grow b--none bg-lightest-blue ma3"
          type = "search" 
          placeholder = "search here ..." onChange={(e)=>handleSearch(e)}
        /><br></br><br></br><br></br>
        {search &&
        search.map((item) => {
          return <p key={item.id}>{item.id}. {item.title}</p>;
      })
      }
      </div>
    </>
  );
}

export default Home;
