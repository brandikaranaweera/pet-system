$(document).ready(function() {

});


// Example starter JavaScript for disabling form submissions if there are invalid fields
$(function() {
    'use strict'

    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.querySelectorAll('.needs-validation')

    // Loop over them and prevent submission
    Array.prototype.slice.call(forms)
        .forEach(function(form) {
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                } else {
                    if (form.id == "registerForm") {
                        var isValid = true;
                        var advertise = $("#foradvertise").prop("checked");
                        var service = $("#forservice").prop("checked");

                        if (!advertise && !service) {
                            isValid = false;
                            $("#adInvalidFeedback").html("Please select at lease one option");
                            $("#foradvertise").addClass("is-invalid");
                            $("#forservice").addClass("is-invalid");
                        } else {
                            $("#foradvertise").removeClass("is-invalid");
                            $("#forservice").removeClass("is-invalid");
                        }

                        var password = $("#txtPassword").val();
                        var cpassword = $("#txtConfirmPassword").val();
                        if (password != cpassword) {
                            isValid = false;
                            $("#cPasswordFeedback").html("Password mismatched");
                            $("#txtConfirmPassword").addClass("is-invalid");
                        } else {
                            console.log("sssswwwww")
                            $("#txtConfirmPassword").removeClass("is-invalid");
                        }

                        if (!isValid) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                    }
                    if (form.id == "addServiceForm") {
                        var latlong = $("#lat").val();

                        if (latlong == "") {
                            alert("Please select your service location");
                            event.preventDefault();
                            event.stopPropagation();
                        }
                    }
                }

                form.classList.add('was-validated')
            }, false)
        })
});


function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}