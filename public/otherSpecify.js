const hearAboutSelect = document.getElementById('hear-about');
        const otherOptionText = document.querySelector('.other-option');

        hearAboutSelect.addEventListener('change', function() {
            if (this.value === 'other') {
                otherOptionText.style.display = 'block';
            } else {
                otherOptionText.style.display = 'none';
            }
        });