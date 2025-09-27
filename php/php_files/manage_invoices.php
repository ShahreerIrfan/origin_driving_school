<?php
include("../includes/header.php");
include("../includes/sidebar.php"); 
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Invoices</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        .container {
    max-width: 850px;   /* shrink width */
    margin: 20px auto;  /* center horizontally */
    padding: 20px;
    font-family: Arial, sans-serif;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.05);
}


        h2 {
            text-align: center;
            color: #333;
            font-size: 32px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #007bff;
            color: white;
            font-size: 16px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
            transition: background-color 0.3s ease;
        }

        td {
            font-size: 14px;
            color: #333;
        }

        .action-btns {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .btn {
            background-color: #28a745;
            color: white;
            padding: 8px 16px;
            text-decoration: none;
            border-radius: 5px;
            transition: all 0.3s ease;
            font-size: 14px;
        }

        .btn:hover {
            background-color: #218838;
        }

        .paid {
            color: green;
            font-weight: bold;
        }

        .unpaid {
            color: red;
            font-weight: bold;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4);
            overflow: auto;
            padding-top: 60px;
            transition: all 0.3s ease;
        }

        .modal-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            margin: auto;
            width: 60%;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .message {
            font-size: 16px;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .message.success {
            background-color: #d4edda;
            color: #155724;
        }

        .message.error {
            background-color: #f8d7da;
            color: #721c24;
        }

        /* Search Box */
        .search-box {
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
        }

        .search-box input {
            padding: 10px;
            font-size: 14px;
            border-radius: 5px;
            border: 1px solid #ddd;
            width: 40%;
            margin-right: 10px;
        }

        .search-box button {
            padding: 10px;
            font-size: 14px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 15%;
        }

        .search-box button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Invoice List</h2>

    <!-- Search Box -->
    <div class="search-box">
        <input type="text" id="searchInput" placeholder="Search invoices by ID, Student, or Amount..." onkeyup="searchInvoices()">
        <button onclick="searchInvoices()">Search</button>
    </div>

    <div class="message success" id="message">✅ Invoice data loaded successfully.</div>

    <table id="invoiceTable">
        <tr>
            <th>Invoice ID</th>
            <th>Student ID</th>
            <th>Amount</th>
            <th>Issue Date</th>
            <th>Due Date</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <!-- Static Invoice Data for Design -->
        <tr>
            <td>1</td>
            <td>1001</td>
            <td>$50</td>
            <td>2025-09-23</td>
            <td>2025-10-23</td>
            <td class="paid">Paid</td>
            <td class="action-btns">
                <a href="make_payment.php?invoice_id=1&student_id=1001&amount=50" class="btn">Pay</a>
            </td>
        </tr>
        <tr>
            <td>2</td>
            <td>1002</td>
            <td>$60</td>
            <td>2025-09-22</td>
            <td>2025-10-22</td>
            <td class="unpaid">Unpaid</td>
            <td class="action-btns">
                <a href="make_payment.php?invoice_id=2&student_id=1002&amount=60" class="btn">Pay</a>
            </td>
        </tr>
        <tr>
            <td>3</td>
            <td>1003</td>
            <td>$40</td>
            <td>2025-09-21</td>
            <td>2025-10-21</td>
            <td class="paid">Paid</td>
            <td class="action-btns">
                <a href="make_payment.php?invoice_id=3&student_id=1003&amount=40" class="btn">Pay</a>
            </td>
        </tr>
        <tr>
            <td>4</td>
            <td>1004</td>
            <td>$30</td>
            <td>2025-09-20</td>
            <td>2025-10-20</td>
            <td class="unpaid">Unpaid</td>
            <td class="action-btns">
                <a href="make_payment.php?invoice_id=4&student_id=1004&amount=30" class="btn">Pay</a>
            </td>
        </tr>
    </table>
</div>

<!-- Payment Modal -->
<div id="paymentModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2>Confirm Payment</h2>
        <p>Are you sure you want to pay for this invoice?</p>
        <button>Confirm Payment</button>
    </div>
</div>

<script>
    // Modal Functionality
    function openModal() {
        document.getElementById("paymentModal").style.display = "block";
    }

    function closeModal() {
        document.getElementById("paymentModal").style.display = "none";
    }

    // Search Functionality
    function searchInvoices() {
        let input = document.getElementById("searchInput").value.toLowerCase();
        let table = document.getElementById("invoiceTable");
        let tr = table.getElementsByTagName("tr");

        for (let i = 1; i < tr.length; i++) {
            let td = tr[i].getElementsByTagName("td");
            let invoiceId = td[0].textContent.toLowerCase();
            let studentId = td[1].textContent.toLowerCase();
            let amount = td[2].textContent.toLowerCase();

            if (invoiceId.includes(input) || studentId.includes(input) || amount.includes(input)) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }

    // Open modal on "Pay" button click
    const payButtons = document.querySelectorAll(".btn");
    payButtons.forEach(button => {
        button.addEventListener("click", openModal);
    });
</script>

</body>
</html>
