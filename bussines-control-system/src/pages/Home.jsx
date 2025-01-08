import { useAuth } from "../hooks/useAuth";
import Sidebar from "../components/Sidebar";
import ProductsTable from "./ProductsTable";
import '../assets/css/SidebarStyle.css';

const Home = () => {
    const { user } = useAuth();

    return (
        <div className="app-container">
            <Sidebar />
            <main className="main-container">
                <div className="welcome-section">
                    <h1>Bienvenido {user.name}</h1>
                </div>
                <div className="content-section">
                    <ProductsTable />
                </div>
            </main>
        </div>
    );
};

export { Home };