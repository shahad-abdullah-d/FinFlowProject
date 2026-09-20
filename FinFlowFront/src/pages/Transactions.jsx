import { useEffect, useState } from "react";
import api from "../api/api";

function Transactions() {
    const [transactions, setTransactions] = useState([]);
    const [customers, setCustomers] = useState([]);

    const [customerId, setCustomerId] = useState("");
    const [transactionType, setTransactionType] = useState("");
    const [amount, setAmount] = useState("");
    const [notes, setNotes] = useState("");

    const [loading, setLoading] = useState(true);
    const [error, setError] = useState("");

    useEffect(() => {
        getTransactions();
        getCustomers();
    }, []);

    const getTransactions = async () => {
        try {
            const response = await api.get("/transactions");

            setTransactions(response.data.data ?? response.data);
        } catch (error) {
            console.error(error);
            setError("Failed to load transactions.");
        } finally {
            setLoading(false);
        }
    };

    const getCustomers = async () => {
        try {
            const response = await api.get("/customers");

            setCustomers(response.data.data ?? response.data);
        } catch (error) {
            console.error(error);
        }
    };

    const handleAddTransaction = async (e) => {
        e.preventDefault();

        try {
            const response = await api.post("/transactions", {
                customer_id: customerId,
                transaction_type: transactionType,
                amount: Number(amount),
                notes,
            });

            const newTransaction =
                response.data.data ?? response.data;

            setTransactions((previousTransactions) => [
                newTransaction,
                ...previousTransactions,
            ]);

            setCustomerId("");
            setTransactionType("");
            setAmount("");
            setNotes("");
        } catch (error) {
            console.error(error);

            alert(
                error.response?.data?.message ??
                "Failed to create transaction."
            );
        }
    };

    const handleApprove = async (transactionId) => {
        try {
            const response = await api.patch(
                `/transactions/${transactionId}/approve`
            );

            const updatedTransaction =
                response.data.data ?? response.data;

            setTransactions((previousTransactions) =>
                previousTransactions.map((transaction) =>
                    transaction.id === transactionId
                        ? updatedTransaction
                        : transaction
                )
            );
        } catch (error) {
            console.error(error);

            alert(
                error.response?.data?.message ??
                "Failed to approve transaction."
            );
        }
    };

    const handleReject = async (transactionId) => {
        const reason = window.prompt("Enter rejection reason:");

        if (!reason) {
            return;
        }

        try {
            const response = await api.patch(
                `/transactions/${transactionId}/reject`,
                {
                   comment: reason,
                }
            );

            const updatedTransaction =
                response.data.transaction;

            setTransactions((previousTransactions) =>
                previousTransactions.map((transaction) =>
                    transaction.id === transactionId
                        ? updatedTransaction
                        : transaction
                )
            );
        } catch (error) {
            console.error(error);

            alert(
                error.response?.data?.message ??
                "Failed to reject transaction."
            );
        }
    };

    if (loading) {
        return <h2>Loading transactions...</h2>;
    }

    if (error) {
        return <p>{error}</p>;
    }

    return (
        <div>
            <h1>Transactions</h1>

            <form onSubmit={handleAddTransaction}>
                <select
                    value={customerId}
                    onChange={(e) => setCustomerId(e.target.value)}
                    required
                >
                    <option value="">Select customer</option>

                    {customers.map((customer) => (
                        <option
                            key={customer.id}
                            value={customer.id}
                        >
                            {customer.name}
                        </option>
                    ))}
                </select>

                <select
                    value={transactionType}
                    onChange={(e) =>
                        setTransactionType(e.target.value)
                    }
                    required
                >
                    <option value="">Select transaction type</option>
                    <option value="deposit">Deposit</option>
                    <option value="withdraw">Withdraw</option>
                </select>

                <input
                    type="number"
                    min="0.01"
                    step="0.01"
                    placeholder="Amount"
                    value={amount}
                    onChange={(e) => setAmount(e.target.value)}
                    required
                />

                <input
                    type="text"
                    placeholder="Notes"
                    value={notes}
                    onChange={(e) => setNotes(e.target.value)}
                />

                <button type="submit">
                    Create Transaction
                </button>
            </form>

            {transactions.length === 0 ? (
                <p>No transactions found.</p>
            ) : (
                <table>
                    <thead>
                        <tr>
                            <th>Customer</th>
                            <th>Type</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Notes</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        {transactions.map((transaction) => (
                            <tr key={transaction.id}>
                                <td>
                                    {transaction.customer?.name ??
                                        transaction.customer_id}
                                </td>

                                <td>
                                    {transaction.transaction_type}
                                </td>

                                <td>{transaction.amount}</td>

                                <td>{transaction.status}</td>

                                <td>{transaction.notes ?? "-"}</td>

                                <td>
                                    {transaction.status === "pending_review" && (
                                        <>
                                            <button
                                                type="button"
                                                onClick={() =>
                                                    handleApprove(
                                                        transaction.id
                                                    )
                                                }
                                            >
                                                Approve
                                            </button>

                                            <button
                                                type="button"
                                                onClick={() =>
                                                    handleReject(
                                                        transaction.id
                                                    )
                                                }
                                            >
                                                Reject
                                            </button>
                                        </>
                                    )}
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            )}
        </div>
    );
}

export default Transactions;