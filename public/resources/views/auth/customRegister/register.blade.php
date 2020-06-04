<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link href="/css/custom/register.css" rel="stylesheet" type="text/css" />

    <!-- Including JS File Here -->
    <script src="/js/custom/app.js" type="text/javascript"></script>
</head>

<body>
    <!-- Multistep Form -->
    <form name="form" onsubmit="return pfields()" id="msform" method="POST" action="register">
        @csrf
        <!-- Progressbar -->
        <span>
            <ul id="progressbar">
                <li id="accset" class="active1">Account setup</li>
                <li id="eduprof">Educational Profiles</li>
                <li id="personald">Personal Details</li>
            </ul>
        </span>
        <!--End of progress bar-->
        <!-- Fieldsets -->
        <fieldset id="first">
            <h2 class="title">Create your account</h2>
            <p class="fs-subtitle" style="color:green;">Step...1</p>
            <span class="required">*</span>
            <input class="text_field" class="asterisk_input" name="email" placeholder="Email" type="text" value=""
                required />

            <span class="required">*</span>
            <input class="text_field" name="username" placeholder="User name" type="text" value="" />


            <span class="required">*</span>
            <input class="text_field" name="pass" placeholder="Password" type="password" value="" />
            <input class="text_field" name="cpass" placeholder="Confirm Password" type="password" value="" />



            <input class="next action-button" onclick="if(requiredfields()&&ValidateEmail(document.form.email)
          &&CheckPassword(document.form.pass)&&validatePass()){next_step1()}" type="button" value="Next" />
        </fieldset>
        <fieldset id="second">
            <h2 class="title">Educational Profiles</h2>
            <p class="fs-subtitle" style="color:green;">Step...2</p>
            <input class="text_field" name="school" placeholder="University/college" type="text" value="" />
            <label for="gender">Current year:</label>

            <select id="year" name="year" form="msform">
                <option value="1st">1st</option>
                <option value="2nd">2nd</option>
                <option value="3rd">3rd</option>
                <option value="4th">4th</option>
                <option value="5th">5th</option>
                <option value="6th">6th</option>
                <option value="graduated">graduated</option>
            </select>
            </br>

            <input class="text_field" name="course" placeholder="course studied" type="text" />
            <input class="text_field" name="skills"
                placeholder="What best describes you? eg java programmer, data scientist" type="text" />
            <input class="text_field" name="linkedin" placeholder="linkedin link eg https://linkedin.com(username)"
                type="text" />
            <span class="required">*</span>
            <input class="text_field" name="github" placeholder="githublink eg https://github.com(username)"
                type="text" />
            <input class="previous action-button" onclick="prev_step1()" type="button" value="Previous" />
            <input class="next action-button" name="next" onclick="if(is_url(document.form.github.value)){next_step2()}"
                type="button" value="Next" />
        </fieldset>
        <fieldset id="third">
            <h2 class="title">Personal Details</h2>
            <p class="fs-subtitle" style="color:green;">Step...3</p>
            <span class="required">*</span>
            <input class="text_field" name="fname" placeholder="First Name" type="text" />
            <span class="required">*</span>
            <input name="lname" placeholder="Last Name" type="text" />

            <span class="required">*</span>
            <input class="text_field" name="cont" placeholder="Phone number" type="text" />
            <!---
            <label style="display:inline-block;">Gender</label>

            <input name="gender" type="radio" value="Male" />Male</br>
            <input name="gender" type="radio" value="Female" />Female

            -->
            <label for="gender">Gender:</label>

            <select id="gender" name="gender" form="msform">
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
                <option value="notsay">Rather not say</option>
            </select>
            </br>
            <span class="required">*</span>
            <textarea name="address" placeholder="Current location Address"></textarea>
            <input class="next action-button" onclick="prev_step2()" type="button" value="Previous" />
            <input class="submit action-button" type="submit" value="Submit" />
        </fieldset>
    </form>
</body>

</html>