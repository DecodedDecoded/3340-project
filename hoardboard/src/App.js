import './App.css';
import MenuBar from './Home/MenuBar';
import SearchBar from './Home/SearchBar';
import Recommended from './Home/Recommended';

function App() {
    return (
        <div className="App">
            {/* Part 1: Front Page. Each of the ff are a single component, stored in their own file */}
            {/* Menu Bar on side */}
            <MenuBar />

            <div className="app__page">
                {/* Search Bar on top */}
                <SearchBar />
                
                {/* Recommendations --> Featured? */}
                <Recommended />
            </div>          
        </div>
    );
}

export default App;