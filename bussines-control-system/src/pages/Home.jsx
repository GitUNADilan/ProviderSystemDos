
import { useAuth } from "../hooks/useAuth";

const Home = ()=>{
    const {user} = useAuth().user;

    return (
        <div> Bienvenido {user.name} </div>
    );
}

export {Home};