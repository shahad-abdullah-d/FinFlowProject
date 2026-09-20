import { Routes, Route } from "react-router-dom";
import Login from "./pages/Login";
import Dashboard from "./pages/Dashboard";
import ProtectedRoute from "./routes/ProtectedRoute";
import Customers from "./pages/Customers";
import Transactions from "./pages/Transactions.jsx";
import Wallet from "./pages/Wallet.jsx";
function App() {
    return (
        <Routes>
            <Route path="/login" element={<Login />} />

            <Route
                path="/dashboard"
                element={
                    <ProtectedRoute>
                        <Dashboard />
                    </ProtectedRoute>
                }
            />
            <Route
    path="/customers"
    element={
        <ProtectedRoute>
            <Customers />
        </ProtectedRoute>
    }
/>
<Route
    path="/transactions"
    element={
        <ProtectedRoute>
            <Transactions />
        </ProtectedRoute>
    }
/>

<Route
    path="/wallet"
    element={
        <ProtectedRoute>
            <Wallet />
        </ProtectedRoute>
    }
/>
        </Routes>
    );
}

export default App;