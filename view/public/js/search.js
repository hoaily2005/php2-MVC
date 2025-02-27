document.getElementById('search-query').addEventListener('input', function() {
    let query = this.value;

    if (query.length >= 2) {
        fetch('/search-suggestions?q=' + query)
            .then(response => response.json())
            .then(data => {
                let suggestionsBox = document.getElementById('search-suggestions');
                suggestionsBox.innerHTML = '';  

                if (data.suggestions.length > 0) {
                    suggestionsBox.classList.add('show');  
                    data.suggestions.forEach(suggestion => {
                        let suggestionItem = document.createElement('div');
                        suggestionItem.classList.add('suggestion-item');
                        suggestionItem.textContent = suggestion.name;  

                        suggestionItem.dataset.id = suggestion.id; 

                        suggestionItem.addEventListener('click', function() {
                            window.location.href = "/products/detail/" + suggestionItem.dataset.id;
                        });

                        suggestionsBox.appendChild(suggestionItem);
                    });
                } else {
                    suggestionsBox.innerHTML = '<div class="no-results">Không tìm thấy kết quả</div>';
                    suggestionsBox.classList.add('show');  
                }
            });
    } else {
        document.getElementById('search-suggestions').classList.remove('show'); 
    }
});
