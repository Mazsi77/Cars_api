import './App.css';
import { Routes, Route, Link } from "react-router-dom";
import Brands from './components/Brands';
import { Header } from './components/Header';
import { Models } from './components/Models';




function App() {
  return (

      <div className="App" >
        <Header />
        <Routes>
          <Route path="/brands" element={<Brands />} />
          <Route path="/models" element={<Models />} />
        </Routes>
      </div>
  );
}

export default App;
