// JavaScript for image upload functionality
document.addEventListener('DOMContentLoaded', init);

function init() {
    const dropArea = document.getElementById('drop-area');

    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, preventDefaults, false)
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    ['dragenter', 'dragover'].forEach(eventName => {
        dropArea.addEventListener(eventName, highlight, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, unhighlight, false);
    });

    function highlight(e) {
        dropArea.classList.add('highlight');
    }

    function unhighlight(e) {
        dropArea.classList.remove('highlight');
    }

    dropArea.addEventListener('drop', handleDrop, false);

    function handleDrop(e) {
        let dt = e.dataTransfer;
        let files = dt.files;

        handleFiles(files);
    }

    const fileInput = document.getElementById('fileElem');
    fileInput.addEventListener('change', function() {
        handleFiles(this.files);
    });

    function handleFiles(files) {
        for (let i = 0; i < files.length; i++) {
            let file = files[i];
            if (file.type.match('image.*')) {
                let reader = new FileReader();
                reader.onload = function(e) {
                    let img = new Image();
                    img.src = e.target.result;
                    document.getElementById('gallery').appendChild(img);
                }
                reader.readAsDataURL(file);
            }
        }
    }
}
