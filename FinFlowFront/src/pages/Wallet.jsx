import { useEffect, useState } from "react";
import api from "../api/api";

function Wallet() {
    const [customers, setCustomers] = useState([]);
    const [customerId, setCustomerId] = useState("");
    const [wallet, setWallet] = useState(null);
    const [loading, setLoading] = useState(false);
    const [error, setError] = useState("");

    useEffect(() => {
        getCustomers();
    }, []);

    const getCustomers = async () => {
        try {
            const response = await api.get("/customers");
            setCustomers(response.data.data ?? response.data);
        } catch (error) {
            console.error(error);
        }
    };

    const getWallet = async () => {
        if (!customerId) {
            return;
        }

        try {
            setLoading(true);
            setError("");
            setWallet(null);

            const response = await api.get(`/wallets/${customerId}`);

            setWallet(response.data.data ?? response.data);
        } catch (error) {
            console.error(error);
            setError(
                error.response?.data?.message ??
                "Failed to load wallet."
            );
        } finally {
            setLoading(false);
        }
    };

    return (
        <div>
            <h1>Wallet</h1>

            <select
                value={customerId}
                onChange={(e) => setCustomerId(e.target.value)}
            >
                <option value="">Select customer</option>

                {customers.map((customer) => (
                    <option key={customer.id} value={customer.id}>
                        {customer.name}
                    </option>
                ))}
            </select>

            <button onClick={getWallet}>
                View Wallet
            </button>

            {loading && <p>Loading wallet...</p>}

            {error && <p>{error}</p>}

            {wallet && (
                <div>
                    <h2>Wallet Details</h2>

                    <p>Customer ID: {wallet.customer_id}</p>
                    <p>Balance: {wallet.balance}</p>
                </div>
            )}
        </div>
    );
}

export default Wallet;