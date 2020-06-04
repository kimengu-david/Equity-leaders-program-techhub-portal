/*------------Validation Function-----------------*/
var count = 0; // To count blank fields.
function validation(event) {
    var radio_check = document.getElementsByName("gender"); // Fetching radio button by name.
    var input_field = document.getElementsByClassName("text_field"); // Fetching all inputs with same class name text_field and an html tag textarea.
    var text_area = document.getElementsByTagName("textarea");
    // Validating radio button.
    if (radio_check[0].checked == false && radio_check[1].checked == false) {
        var y = 0;
    } else {
        var y = 1;
    }
    // For loop to count blank inputs.
    for (var i = input_field.length; i > count; i--) {
        if (input_field[i - 1].value == "" || text_area.value == "") {
            count = count + 1;
        } else {
            count = 0;
        }
    }
    if (count != 0 || y == 0) {
        alert("*All Fields are mandatory*"); // Notifying validation
        event.preventDefault();
    } else {
        return true;
    }
}
/*---------------------------------------------------------*/
// Function that executes on click of first next button.
function next_step1() {
    $("#eduprof").addClass("active1");
    document.getElementById("first").style.display = "none";
    document.getElementById("second").style.display = "block";
    document.getElementById("active2").style.color = "red";
    //document.getElementById("active2").style:before.color="green";
}
// Function that executes on click of first previous button.
function prev_step1() {
    $("#eduprof").removeClass("active1");
    document.getElementById("first").style.display = "block";
    document.getElementById("second").style.display = "none";
    document.getElementById("active1").style.color = "red";
    document.getElementById("active2").style.color = "gray";
}
// Function that executes on click of second next button.
function next_step2() {
    $("#personald").addClass("active1");
    document.getElementById("second").style.display = "none";
    document.getElementById("third").style.display = "block";
    document.getElementById("active3").style.color = "red";
}
// Function that executes on click of second previous button.
function prev_step2() {
    $("#personald").removeClass("active1");
    document.getElementById("third").style.display = "none";
    document.getElementById("second").style.display = "block";
    document.getElementById("active2").style.color = "red";
    document.getElementById("active3").style.color = "gray";
}

//function to check if setup fields are empty.
function requiredfields() {
    var email = document.forms["form"]["email"].value;
    var pass = document.forms["form"]["pass"].value;
    var cpass = document.forms["form"]["cpass"].value;
    if (email == "") {
        alert("Please enter your email address.");
        return false;
    } else {
        return true;
    }
}

//Function that validates the email address.
function ValidateEmail(mail) {
    if (
        /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(
            document.forms["form"]["email"].value
        )
    ) {
        return true;
    }
    alert("You have entered an invalid email address!");
    return false;
}
//Password validation function.

function CheckPassword(inputtxt) {
    var decimal = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{7,150}$/;
    if (inputtxt.value.match(decimal)) {
        return true;
    } else {
        alert(
            "A password must have more than 7 characters which contain at least one lowercase letter, one uppercase letter, one numeric digit, and one special character"
        );
        return false;
    }
}
//Validating that the password and the confirm passoword are equal and the same.
function validatePass() {
    var pass = document.forms["form"]["pass"].value;
    var cpass = document.forms["form"]["cpass"].value;
    if (pass != cpass) {
        alert("Password and confirm password do not match");
        return false;
    } else {
        return true;
    }
}
//confirm github dialog box.
function confirmBox() {
    if (confirm("Enter a valid github account link\nNo account? click ok ")) {
        window.location.href = "https://github.com/join";
    } else {
    }
    document.getElementById("demo").innerHTML = txt;
}
//validating the github link.
function is_url(value) {
    var expression = /[-a-zA-Z0-9@:%_\+.~#?&//=]{2,256}\.[a-z]{2,4}\b(\/[-a-zA-Z0-9@:%_\+.~#?&//=]*)?/gi;
    var regexp = new RegExp(expression);
    if (
        regexp.test(value) &&
        value.includes("https://github.com/") &&
        value.length > 19
    ) {
        return true;
    } else {
        confirmBox();
        return false;
    }
}

//Validating the last section of registration.
function pfields() {
    var fname = document.forms["form"]["fname"].value;
    var lname = document.forms["form"]["lname"].value;
    var cont = document.forms["form"]["cont"].value;
    var address = document.forms["form"]["address"].value;
    if ((fname == "") | (lname == "") | (cont == "") | (address == "")) {
        alert("All fields marked with asterick\n are mandatory!");
        return false;
    } else {
        return true;
    }
}
