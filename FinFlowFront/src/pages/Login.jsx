import { useState } from "react";
import { useNavigate } from "react-router-dom";
import api from "../api/api";

function Login() {
    const navigate = useNavigate();

    const [email, setEmail] = useState("");
    const [password, setPassword] = useState("");

    const handleLogin = async (e) => {
        e.preventDefault();

        try {
            const response = await api.post("/login", {
                email,
                password,
            });

            localStorage.setItem("token", response.data.token);

localStorage.setItem(
    "user",
    JSON.stringify(response.data.user)
);

            navigate("/dashboard");
        } catch (error) {
            alert("Invalid email or password");
            console.error(error);
        }
    };

    return (
        <form onSubmit={handleLogin}>
            <input
                type="email"
                placeholder="Email"
                value={email}
                onChange={(e) => setEmail(e.target.value)}
            />

            <input
                type="password"
                placeholder="Password"
                value={password}
                onChange={(e) => setPassword(e.target.value)}
            />

            <button type="submit">
                Login
            </button>
        </form>
    );
}

export default Login;