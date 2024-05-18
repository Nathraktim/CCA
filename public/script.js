document.addEventListener("DOMContentLoaded", function() {
    var courseSelection = document.getElementById("course-selection");
    var courseDuration = document.getElementById("course-duration");
    var feesSection = document.getElementById("fees-section");

    // Function to format fees in Indian currency style
    function formatIndianCurrency(amount) {
        // Convert number to string
        amount = amount.toString();
    
        // Split the number into integer and decimal parts
        var parts = amount.split('.');
    
        // Add commas to the integer part
        var integerPart = parts[0];
        var formattedIntegerPart = '';
        var len = integerPart.length;
        for (var i = 0; i < len; i++) {
            if (i > 0 && (len - i) % 2 === 0) {
                formattedIntegerPart += ',';
            }
            formattedIntegerPart += integerPart[i];
        }
    
        // Join integer and decimal parts and return
        if (parts.length === 2) {
            return "₹ " + formattedIntegerPart + '.' + parts[1];
        } else {
            return "₹ " + formattedIntegerPart;
        }
    }
    
    

    // Fetch course details from JSON file
    fetch('./json/course_details.json')
        .then(response => response.json())
        .then(data => {
            courseSelection.addEventListener("change", function() {
                var selectedCourse = courseSelection.value;
                courseDuration.innerHTML = ""; // Clear previous options

                if (selectedCourse in data) {
                    for (var duration in data[selectedCourse]) {
                        var option = document.createElement("option");
                        option.value = duration;
                        option.text = duration;
                        courseDuration.add(option);
                    }
                }
            });

            courseDuration.addEventListener("change", function() {
                var selectedCourse = courseSelection.value;
                var selectedDuration = courseDuration.value;

                if (selectedCourse in data && selectedDuration in data[selectedCourse]) {
                    var fees = data[selectedCourse][selectedDuration];
                    feesSection.textContent = "Fees: " + formatIndianCurrency(fees);
                }
            });
        })
        .catch(error => {
            console.error('Error:', error);
        });
});
