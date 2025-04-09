document.addEventListener('DOMContentLoaded', function() {
    const rankButtons = document.querySelectorAll('.rank-buttons .filter__item');
    const flashcards = document.querySelectorAll('.grid .grid__item');

    rankButtons.forEach(button => {
        button.addEventListener('click', function() {
            const filterValue = this.dataset.filter; // Get the data-filter value

            flashcards.forEach(card => {
                if (filterValue === '.*' || card.classList.contains(filterValue.substring(1))) {
                    card.style.display = 'block'; // Or remove a 'hidden' class
                } else {
                    card.style.display = 'none'; // Or add a 'hidden' class
                }
            });
        });
    });
});