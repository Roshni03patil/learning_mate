document.addEventListener("DOMContentLoaded", function () {
    // Function to handle carousel sliding
    function initializeCarousel(carousel) {
        const prevBtn = carousel.querySelector('.prev-btn');
        const nextBtn = carousel.querySelector('.next-btn');
        const carouselContainer = carousel.querySelector('.carousel-container');
        const images = carousel.querySelectorAll('img');
        let index = 0;

        // Move to the next image
        nextBtn.addEventListener('click', function () {
            index = (index + 1) % images.length;
            updateCarousel();
        });

        // Move to the previous image
        prevBtn.addEventListener('click', function () {
            index = (index - 1 + images.length) % images.length;
            updateCarousel();
        });

        function updateCarousel() {
            carouselContainer.style.transform = `translateX(${-index * 100}%)`;
        }

        updateCarousel(); // Initialize the carousel
    }

    // Initialize all carousels (left, center, and right)
    const leftCarousel = document.querySelector('.left-carousel');
    const centerCarousel = document.querySelector('.center-carousel');
    const rightCarousel = document.querySelector('.right-carousel');
    
    initializeCarousel(leftCarousel);
    initializeCarousel(centerCarousel);
    initializeCarousel(rightCarousel);
});
