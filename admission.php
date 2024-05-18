<?php
// Load course details from JSON file
$courseDetails = json_decode(file_get_contents('course_details.json'), true);

// Function to generate course duration options
function generateCourseDurationOptions($courseDetails, $selectedCourse) {
    $options = '';
    if (array_key_exists($selectedCourse, $courseDetails)) {
        foreach ($courseDetails[$selectedCourse] as $duration => $fees) {
            $options .= "<option value='$duration'>$duration</option>";
        }
    }
    return $options;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Form</title>
  
  <link rel="stylesheet" href="application_css.css">
</head>
<body>
    <header>
        <div id="logo"><img id=logo-img src="./logo.svg" alt="Logo"><h2>CCA</h2></div>
  </header>
  <form action="submit.php" method="POST" enctype="multipart/form-data">
    <section>
        <fieldset>
            <legend>Personal Information</legend>
                    <div>
                        <label for="full-name">Full Name:</label>
                        <input type="text" id="full-name" name="full-name" required>
                    </div>
                    <div>
                        <label for="dob">Date of Birth:</label>
                        <input type="date" id="dob" name="dob" required>
                    </div>
                    <div>
                        <label for="gender">Gender:</label>
                        <select id="gender" name="gender" required>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div>
                        <label for="father-name">Father's Name:</label>
                        <input type="text" id="father-name" name="father-name" required>
                    </div>
                    <div>
                        <label for="mother-name">Mother's Name:</label>
                        <input type="text" id="mother-name" name="mother-name" required>
                    </div>
                    <div>
                        <label for="guardian-name">Guardian's Name:</label>
                        <input type="text" id="guardian-name" name="guardian-name" required>
                    </div>
                </fieldset>
            </section>
            <section id="image-upload">
                <fieldset>
                    <legend>Upload Image</legend>
                    <div id="drop-area">
                        <input type="file" id="fileElem" name="photo" accept="image/*" required>
                        <label class="button" for="fileElem">Browse or drag and drop your image here</label>
                        <output id="gallery"></output>
                    </div>
                </fieldset>
                <fieldset>
            <legend>Government ID</legend>
            <div id="drop-area">
                <input type="file" id="fileElem" name="photo" multiple accept="image/*" required>
                <label class="button" for="fileElem">Browse or drag and drop any government issued id proff here</label>
                <output id="gallery"></output>
            </div>
        </fieldset>
            </section>
            <section>
                <fieldset>
                    <legend>Educational Background</legend>
                    <div>
                        <label for="highest-qualification">Highest Qualification:</label>
                        <select id="highest-qualification" name="highest-qualification" required>
                            <option value="high-school">High School</option>
                            <option value="bachelors">Bachelor's Degree</option>
                            <option value="masters">Master's Degree</option>
                            <option value="phd">PhD</option>
                        </select>
                    </div>
                    <div>
                        <label for="institution-name">Name of the Institution:</label>
                        <input type="text" id="institution-name" name="institution-name" required>
                    </div>
                    <div>
                        <label for="year-of-passing">Year of Passing:</label>
                        <input type="number" id="year-of-passing" name="year-of-passing" min="1955" max="2024" required>
                    </div>
                </fieldset>
            </section>
            <section>
                <fieldset>
                    <legend>Contact Information</legend>
                    <div>
                        <label for="contact-number">Contact Number:</label>
                        <input type="text" id="contact-number" name="contact-number" required>
                    </div>
                    <div>
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div>
                        <label for="address">Address:</label>
                        <textarea id="address" name="address" required></textarea>
                    </div>
                </fieldset>
            </section>

    <section>
        <fieldset>
            <legend>Select Course</legend>
            <div>
                <label for="course-selection">Select Your Course</label>
                <select id="course-selection" name="course-selection" onchange="updateCourseDurationOptions()">
                    <option value="acting">Acting and Mimes</option>
                    <option value="dance">Dance Classes</option>
                    <option value="yoga-therapy">Yoga Classes & Therapy</option>
                    <option value="gfx-designing">GFX Designing</option>
                    <option value="digital-marketing">Digital Marketing</option>
                    <option value="video-editing">Video Editing</option>
                    <option value="vfx-compositing">VFX Animation & Compositing</option>
                </select>
            </div>
        </fieldset>
    </section>

    <section>
        <fieldset>
            <legend>Course Details</legend>
            <div>
                <label for="batch-timing">Preferred Batch Timing:</label>
                <select id="batch-timing" name="batch-timing">
                    <option value="Morning">Morning</option>
                    <option value="Afternoon">Afternoon</option>
                    <option value="Evening">Evening</option>
                </select>
            </div>
            <div>
                <label for="course-duration">Course Duration:</label>
                <select id="course-duration" name="course-duration">
                    <?php echo generateCourseDurationOptions($courseDetails, 'acting'); ?>
                </select>
            </div>
            <div>
                <label for="hear-about">How did you hear about us?</label>
                <select id="hear-about" name="hear-about">
                    <option value="web">Website</option>
                    <option value="social-media">Social Media</option>
                    <option value="reff">Referral</option>
                    <option value="other">Other</option>
                </select>
            </div>
            <div class="other-option" style="display: none;">
                <label for="other-option-text">Specify Other Option:</label>
                <input type="text" id="other-option-text" name="other-option-text">
            </div>
        </fieldset>
    </section>

    <section>
        <fieldset>
            <legend>Fees:</legend>
            <div id="fees-section">
                <!-- Fees will be displayed here based on the selected course duration -->
            </div>
        </fieldset>
    </section>

    <section>
        <fieldset>
            <legend>Payment Detail</legend>
            <div>
                <label for="payment-method">Payment Method:</label>
                <p>Payment will have to be made while verifying offline with your ID card you have attached.</p>
                </select>
            </div>
        </fieldset>
    </section>

    <section>
        <fieldset>
            <legend>Declaration <input type="checkbox" id="declaration" name="declaration"> </legend>
            <div>
                <!-- <input type="checkbox" id="declaration" name="declaration"> -->
                <label for="declaration">I hereby declare that the information provided above is true to my knowledge.</label>
            </div>
        </fieldset>
    </section>

    <section>
        <!-- Submit button -->
        <button type="submit">Submit Application</button>
    </section>
</form>

<script>
    function updateCourseDurationOptions() {
        var courseSelection = document.getElementById("course-selection");
        var selectedCourse = courseSelection.value;
        var courseDurationSelect = document.getElementById("course-duration");
        var courseDurationOptions = <?php echo json_encode($courseDetails); ?>;

        courseDurationSelect.innerHTML = ""; // Clear previous options

        if (selectedCourse in courseDurationOptions) {
            for (var duration in courseDurationOptions[selectedCourse]) {
                var option = document.createElement("option");
                option.value = duration;
                option.text = duration;
                courseDurationSelect.add(option);
            }
        }
    }
</script>
</body>
</html>
