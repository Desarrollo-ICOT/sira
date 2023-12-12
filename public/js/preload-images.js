// public/js/preload-images.js

function preloadImage(url) {
    const img = new Image();
    img.src = url;
}
const messageAlert = document.getElementById('messageAlert');

fetch('/get-health-center-code') 
    .then(response => {
        if (!response.ok) {
            throw new Error('Failed to fetch health center code');
        }
        return response.text();
    })
    .then(data => {
        const imageUrl = `${data}`;
        console.log('Health Center Code:', data);
        document.body.style.backgroundImage = `url("${imageUrl}")`;
        preloadImage(imageUrl);
    })
    .catch(error => {
        if (messageAlert) {
            messageAlert.innerText = error.message; // Display the error message
            messageAlert.classList.add('alert-error'); // Optionally, add a CSS class for styling
            messageAlert.style.display = 'block'; // Show the 'messageAlert' div
        }
        console.error('Error fetching health center code:', error);
    });