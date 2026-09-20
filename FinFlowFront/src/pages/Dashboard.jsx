import { useEffect, useState } from "react";
import { useNavigate } from "react-router-dom";
import api from "../api/api";

function Dashboard() {
    const navigate = useNavigate();

    const [user, setUser] = useState(null);

    useEffect(() => {
        getUser();
    }, []);

    const getUser = async () => {
        try {
            const response = await api.get("/user");
            setUser(response.data);
        } catch (error) {
            console.log(error);

            localStorage.removeItem("token");
            localStorage.removeItem("user");

            navigate("/login");
        }
    };

    const handleLogout = async () => {
        try {
            await api.post("/logout");
        } catch (error) {
            console.log(error);
        }

        localStorage.removeItem("token");
        localStorage.removeItem("user");

        navigate("/login");
    };

    if (!user) {
        return <h2>Loading...</h2>;
    }

    return (
        <>
            <h1>Welcome, {user.name}</h1>
            <p>Email: {user.email}</p>


            <button onClick={() => navigate("/customers")}>
    View Customers
</button>

<button onClick={() => navigate("/transactions")}>
    View Transactions
</button>

           <button onClick={() => navigate("/wallet")}>
    View Wallet
</button>

            <button onClick={handleLogout}>
                Logout
            </button>
        </>
    );
}

export default Dashboard;