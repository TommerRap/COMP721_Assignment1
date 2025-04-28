<?php
date_default_timezone_set('pacific/auckland');
$today = date("d/m/Y");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posting Status</title>
    <link rel="stylesheet" href="styles.css">
    
</head>

<body>
    <div class="container">
        <h1 class="flex-item">Post A New Status</h1>
        <form action="poststatusprocess.php" method="post">
            <div class="section">
                <div class="input">
                    <label for="stcode">Status Code:</label>
                    <input type="text" id="stcode" name="stcode" required>
                </div>
                <p class="description" id="stCodeDesc"></p>
            </div>
            <div class="section">
                <div class="input">
                    <label for="st">Status:</label>
                    <input type="text" id="status" name="st" required>
                </div>
            </div>
            <div class="section">
                <div class="input">
                    <label for="desc">Share On:</label>
                    <div class="custom-radio">
                        <input type="radio" name="share" value="University" id="uniInput" required> <span class="checkmark" id="uniCheck"></span>
                        <p>University</p>
                        <input type="radio" name="share" value="Class" id="classInput"> <span class="checkmark" id="classCheck"></span>
                        <p>Class</p>
                        <input type="radio" name="share" value="Private" id="priInput"> <span class="checkmark" id="priCheck"></span>
                        <p>Private</p>
                    </div>
                </div>
            </div>
            <div class="section">
                <div class="input">
                    <label for="date">Date:</label>
                    <input type="text" name="date" value="<?php echo $today; ?>">
                </div>
            </div>
            <div class="section">
                <div class="input">
                    <label for="permission">Permission:</label>
                    <div class="custom-checkbox">
                        <input type="checkbox" name="permission[]" value="allowLike" id="likeInput">
                        <span class="checkmark" id="likeCheck"></span>
                        <p>Like</p>

                        <input type="checkbox" name="permission[]" value="allowComment" id="commentInput">
                        <span class="checkmark" id="commentCheck"></span>
                        <p>Comment</p>

                        <input type="checkbox" name="permission[]" value="allowShare" id="shareInput">
                        <span class="checkmark" id="shareCheck"></span>
                        <p>Share</p>
                    </div>
                </div>
            </div>

            <div class="ops">
                <input type="submit" class="btn" value="Post Status">
                <a href="index.html" class="btn">Return to Home</a>
            </div>
        </form>
    </div>
</body>

</html>

<script>
    //Get Elements

    //stCode
    const stCodeinput = document.getElementById('stcode');
    const stCodedesc = document.getElementById('stCodeDesc');

    //Radio
    const uniCheck = document.getElementById('uniCheck');
    const classCheck = document.getElementById('classCheck');
    const priCheck = document.getElementById('priCheck');

    const uniInput = document.getElementById('uniInput');
    const classInput = document.getElementById('classInput');
    const priInput = document.getElementById('priInput');



    //REGEX
    const stCodeRegex = /^S\d{4}$/;

    //LIseten for input event(stCode)
    stCodeinput.addEventListener('input', function() {
        // See if the input matches the regex
        if (stCodeinput.value.length === 5) {
            if (stCodeRegex.test(stCodeinput.value)) {
                // if so, set to success
                stCodedesc.classList.remove('warning');
                stCodedesc.classList.add('success');
                stCodedesc.innerHTML = "Status code Validated.";
                stCodedesc.hidden = false;
            } else {
                //If not, set to warning
                stCodedesc.classList.remove('success');
                stCodedesc.classList.add('warning');
                stCodedesc.innerHTML = "Invalid status code. <br\> Must Start with 'S' and followed by 4 digits.";
                stCodedesc.hidden = false;
            }
        } else {
            stCodedesc.innerHTML = "";
        }
    });

    //Radio prettier functions, replace vanila checkbox
    uniCheck.addEventListener('click', () => {
        uniInput.checked = true;
        uniInput.dispatchEvent(new Event('change'));
    });

    classCheck.addEventListener('click', () => {
        classInput.checked = true;
        classInput.dispatchEvent(new Event('change'));
    });

    priCheck.addEventListener('click', () => {
        priInput.checked = true;
        priInput.dispatchEvent(new Event('change'));
    });

    //Checkbox prettier functions, replace vanila checkbox
    window.addEventListener('DOMContentLoaded', () => {
        const mappings = [{
                check: 'likeCheck',
                input: 'likeInput'
            },
            {
                check: 'commentCheck',
                input: 'commentInput'
            },
            {
                check: 'shareCheck',
                input: 'shareInput'
            }
        ];

        mappings.forEach(({
            check,
            input
        }) => {
            const checkEl = document.getElementById(check);
            const inputEl = document.getElementById(input);

            if (checkEl && inputEl) {
                checkEl.addEventListener('click', () => {
                    inputEl.checked = !inputEl.checked; // checkbox切换
                    inputEl.dispatchEvent(new Event('change'));
                });
            } else {
                console.error(`找不到元素: ${check} 或 ${input}`);
            }
        });
    });
</script>
<script>
document.querySelector('form').addEventListener('submit', function(e) {
    console.log("Form submitting naturally...");
});
</script>