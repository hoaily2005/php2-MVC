document.addEventListener("DOMContentLoaded", function() {
    const image = document.querySelector(".image-format"); 
    const fullImage = document.getElementById("fullImage"); 
    const variantInputs = document.querySelectorAll("input[name='color'], input[name='size']");

    variantInputs.forEach(input => {
        input.addEventListener("change", function() {
            const newImage = this.getAttribute("data-image");
            if (newImage) {
                image.src = newImage;
                fullImage.src = newImage; 
            }
        });
    });

    // Xử lý mở modal khi nhấn vào ảnh
    image.addEventListener("click", function() {
        fullImage.src = this.src; 
        new bootstrap.Modal(document.getElementById("imageModal")).show(); 
    });
});
