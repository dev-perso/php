document.addEventListener("DOMContentLoaded", function()
{
    var passwordInput           = document.getElementById("passwordInput");
    var passwordRequirements    = document.getElementById("requirements");
    var register                = document.getElementById("register");
    var connect                 = document.getElementById("connect");
    var signUpForm              = document.getElementById("signUpForm");
    var signInForm              = document.getElementById("signInForm");

    register.addEventListener("click", switchRegisterPanel, false);
    connect.addEventListener("click", switchConnectPanel, false);

    function switchRegisterPanel()
    {
        signUpForm.classList.remove('rightPanel-signIn');
        signUpForm.classList.add('leftPanel-signUp');

        signInForm.classList.remove('leftPanel-signIn');
        signInForm.classList.add('rightPanel-signUp');
    }

    function switchConnectPanel()
    {
        signUpForm.classList.remove('leftPanel-signUp');
        signUpForm.classList.add('rightPanel-signIn');

        signInForm.classList.remove('rightPanel-signUp');
        signInForm.classList.add('leftPanel-signIn');
    }

    passwordInput.addEventListener('focus', e =>
    {
        passwordRequirements.style.display = 'block';
    });

    passwordInput.addEventListener('blur', e =>
    {
        e.target.style.background = '';
        passwordRequirements.style.display = 'none';
    });

    passwordInput.addEventListener("keyup", e =>
    {
        var password = passwordInput.value;
    });


    function isStrongPwd2(password)
    {
        var uppercase = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";

        var lowercase = "abcdefghijklmnopqrstuvwxyz";

        var digits = "0123456789";

        var splChars ="!@#$%&*()";

        var ucaseFlag = contains(password, uppercase);

        var lcaseFlag = contains(password, lowercase);

        var digitsFlag = contains(password, digits);

        var splCharsFlag = contains(password, splChars);

        if(password.length>=8 && ucaseFlag && lcaseFlag && digitsFlag && splCharsFlag)
            return true;
        else
            return false;

    }

    function contains(password, allowedChars) {

        for (i = 0; i < password.length; i++) {

            var char = password.charAt(i);

            if (allowedChars.indexOf(char) >= 0) { return true; }

        }

        return false;
    }

});