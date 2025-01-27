// animation.js

const images = [
    './../game/hero_left.PNG', 
    './../game/hero_straight.PNG', 
    './../game/hero_right.PNG'
];
let currentIndex = 0;
const imageElement = document.getElementById('animatedImage');

function changeImage() {
    currentIndex = (currentIndex + 1) % images.length;
    imageElement.src = images[currentIndex];
}

// Change image every 150 milliseconds
setInterval(changeImage, 150);

document.getElementById('selectAll').addEventListener('change', function(e) {
    var checkboxes = document.querySelectorAll('input[name="taskIDs[]"]');
    checkboxes.forEach(function(checkbox) {
        checkbox.checked = e.target.checked;
    });
});
