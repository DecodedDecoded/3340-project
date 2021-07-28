import './App.css';
import MenuBar from './Home/MenuBar';
import Sidebar from './Home/Sidebar';
import Recommended from './Home/Recommended';

function App() {
    return (
        <div className="App">
            {/* Part 1: Front Page. Each of the ff are a single component, stored in their own file */}
            {/* MenuBar */}
            <MenuBar />

            <div className="app__page">
                {/* Sidebar */}
                <Sidebar />
                {/* Recommendations --> Featured? */}
                <Recommended />
            </div>          
        </div>
    );
}

export default App;