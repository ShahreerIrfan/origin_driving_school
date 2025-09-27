// Show the payment modal when booking class
document.querySelectorAll('.book-class-btn').forEach(button => {
    button.addEventListener('click', function() {
        let classId = this.getAttribute('data-class-id');
        
        // Show payment modal
        document.getElementById('paymentModal').style.display = 'block';
        
        // Handle fake payment process
        document.getElementById('payNowBtn').addEventListener('click', function() {
            // Update the payment status (fake)
            fetch('fake_payment.php', {
                method: 'POST',
                body: JSON.stringify({ class_id: classId }),
                headers: { 'Content-Type': 'application/json' }
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                document.getElementById('paymentModal').style.display = 'none';
                
                // After payment, proceed with booking
                document.querySelector(`button[data-class-id="${classId}"]`).innerHTML = "Booked";
                document.querySelector(`button[data-class-id="${classId}"]`).disabled = true;
            });
        });

        // Cancel payment
        document.getElementById('cancelBtn').addEventListener('click', function() {
            document.getElementById('paymentModal').style.display = 'none';
        });
    });
});
