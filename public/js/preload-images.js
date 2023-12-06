// public/js/preload-images.js

function preloadImage(url) {
    const img = new Image();
    img.src = url;
}

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
        console.error('Error fetching health center code:', error);
    });