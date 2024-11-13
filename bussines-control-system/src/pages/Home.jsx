
import { useAuth } from "../hooks/useAuth";
import Sidebar from "../components/Sidebar";
import '../assets/css/SidebarStyle.css';
const Home = () => {
    const { user } = useAuth();

    return (
        <div className="content">
            <Sidebar />
            <h1>Bienvenido {user.name}</h1>
            {/* Resto del contenido */}
        </div>
    );
};


export {Home};