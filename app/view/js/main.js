//  --app / view / js / main.js-- 
// Toggle favorite 
function toggleFavorite(button) {
    button.classList.toggle('is-favorite');
}

// AJAX for favorite button
$(document).ready(function () {

    $('.favorite-btn').on('click', function (e) {
        e.preventDefault();

        const $btn = $(this);
        const $form = $btn.closest('form');
        const formData = $form.serialize();
        $.ajax({
            url: '../controler/ClientControler.php',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    console.log('success');
                } else {
                    console.log('failed');
                }
            },
            error: function () {
                console.log('error');
            }
        });
    });
});
