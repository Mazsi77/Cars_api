import './App.css';
import { Routes, Route, Link } from "react-router-dom";
import Brands from './components/Brands';
import { Header } from './components/Header';
import { Models } from './components/Models';
import { Create } from './components/Create';




function App() {
  return (

      <div className="App" >
        <Header />
        <Routes>
          <Route path="/brands" element={<Brands />} />
          <Route path="/models" element={<Models />} />
          <Route path="/create" element={<Create />} />
        </Routes>
      </div>
  );
}

export default App;
