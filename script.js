// JavaScript source code
document.getElementById('contact-form').addEventListener('submit', function (event) {
    event.preventDefault(); // Prevent form submission

    // Redirect to the thank you page
    window.location.href = 'thankyou.html';
});
