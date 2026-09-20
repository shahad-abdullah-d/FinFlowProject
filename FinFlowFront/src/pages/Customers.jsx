import { useEffect, useState } from "react";
import api from "../api/api";

function Customers() {
    const [customers, setCustomers] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState("");

    const [name, setName] = useState("");
    const [email, setEmail] = useState("");
    const [phone, setPhone] = useState("");
    const [gender, setGender] = useState("");

    useEffect(() => {
        getCustomers();
    }, []);

    const getCustomers = async () => {
        try {
            const response = await api.get("/customers");

            setCustomers(response.data.data ?? response.data);
        } catch (error) {
            console.error(error);
            setError("Failed to load customers.");
        } finally {
            setLoading(false);
        }
    };

    const handleAddCustomer = async (e) => {
        e.preventDefault();

        try {
            const response = await api.post("/customers", {
                name,
                email,
                phone,
                gender,
            });

            const newCustomer = response.data.data ?? response.data;

            setCustomers((previousCustomers) => [
                newCustomer,
                ...previousCustomers,
            ]);

            setName("");
            setEmail("");
            setPhone("");
            setGender("");
        } catch (error) {
            console.error(error);

            alert(
                error.response?.data?.message ??
                "Failed to add customer."
            );
        }
    };

    if (loading) {
        return <h2>Loading customers...</h2>;
    }

    if (error) {
        return <p>{error}</p>;
    }

    return (
        <div>
            <h1>Customers</h1>

            <form onSubmit={handleAddCustomer}>
                <input
                    type="text"
                    placeholder="Name"
                    value={name}
                    onChange={(e) => setName(e.target.value)}
                />

                <input
                    type="email"
                    placeholder="Email"
                    value={email}
                    onChange={(e) => setEmail(e.target.value)}
                />

                <input
                    type="text"
                    placeholder="Phone"
                    value={phone}
                    onChange={(e) => setPhone(e.target.value)}
                />

                <select
                    value={gender}
                    onChange={(e) => setGender(e.target.value)}
                >
                    <option value="">Select gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>

                <button type="submit">
                    Add Customer
                </button>
            </form>

            {customers.length === 0 ? (
                <p>No customers found.</p>
            ) : (
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Gender</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        {customers.map((customer) => (
                            <tr key={customer.id}>
                                <td>{customer.name}</td>
                                <td>{customer.email}</td>
                                <td>{customer.phone}</td>
                                <td>{customer.gender}</td>
                                <td>{customer.status}</td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            )}
        </div>
    );
}

export default Customers;