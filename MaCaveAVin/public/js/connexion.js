document.addEventListener("DOMContentLoaded", function()
{
    // Email
    var emailInput              = document.getElementById("emailInput");
    var emailCheck              = document.getElementById("emailCheck");
    var emailTimes              = document.getElementById("emailTimes");
    var emailUsed               = document.getElementById("emailUsed");
    var emailUsable             = false;

    // Password
    var passwordInput           = document.getElementById("passwordInput");

    // Password requirements
    var passwordRequirements    = document.getElementById("requirements");
    var lengthRequirement       = document.getElementById('passLength');
    var minRequirement          = document.getElementById('passMin');
    var majRequirement          = document.getElementById('passMaj');
    var numRequirement          = document.getElementById('passNum');

    // Confirm Password
    var confirmPasswordInput    = document.getElementById("confirm");
    var confirmCheck            = document.getElementById("confirmCheck");
    var confirmTimes            = document.getElementById("confirmTimes");

    // Boutons
    var registerBtn             = document.getElementById('registerBtn');
    var register                = document.getElementById("register");
    var connect                 = document.getElementById("connect");

    // Forms
    var signUpForm              = document.getElementById("signUpForm");
    var signInForm              = document.getElementById("signInForm");

    /**
     * Email event
     */
    emailInput.addEventListener('focus', e =>
    {
        var email = emailInput.value;

        if (emailIsValid(email))
            emailExist(email)
        else
        {
            emailCheck.style.display = "none";
            emailTimes.style.display = "block";
            emailUsed.style.display = "none";
            registerBtn.disabled = true;
        }
    });

    emailInput.addEventListener('blur', e =>
    {
        emailTimes.style.display = "none";
        emailCheck.style.display = 'none';
    });

    emailInput.addEventListener("keyup", e =>
    {
        var email = emailInput.value;

        if (emailIsValid(email))
            emailExist(email)
        else
        {
            emailCheck.style.display = "none";
            emailTimes.style.display = "block";
            emailUsed.style.display = "none";
            registerBtn.disabled = true;
        }
    });

    // Regex pour un email valide
    function emailIsValid(email)
    {
        const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(String(email).toLowerCase());
    }

    // Check si l'email saisi existe en BDD
    function emailExist(email)
    {
        var request     = new XMLHttpRequest();
        var url         = "/register/email";

        console.log(url)
        request.open('POST', url);
        request.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
        request.send('email=' + email);

        request.onreadystatechange = function()
        {
            if (this.readyState === XMLHttpRequest.DONE && this.status === 200)
            {
                const response = JSON.parse(request.response);
                if (response.email.length > 0)
                {
                    emailCheck.style.display = "none";
                    emailTimes.style.display = "block";
                    emailUsed.style.display = "block";
                    emailUsable = false;
                    isStrongPwd2(passwordInput.value);
                }
                else
                {
                    emailCheck.style.display = "block";
                    emailTimes.style.display = "none";
                    emailUsed.style.display = "none";
                    emailUsable = true;
                    isStrongPwd2(passwordInput.value);
                }
            }
        }
    }

    /**
     * Password event
     */
    passwordInput.addEventListener('focus', e =>
    {
        passwordRequirements.style.display = 'block';
    });

    passwordInput.addEventListener('blur', e =>
    {
        passwordRequirements.style.display = 'none';
    });

    passwordInput.addEventListener("keyup", e =>
    {
        var password = passwordInput.value;
        isStrongPwd2(password);
    });

    /**
     * Password requirements event
     */
    function isStrongPwd2(password)
    {
        const regexMaj  = RegExp('[A-Z]');
        const regexMin  = RegExp('[a-z]');
        const regexNum  = RegExp('[0-9]');

        // Si le password contient au moins une Majuscule
        var uppercaseFlag = regexMaj.test(password);
        // Si le password contient au moins une Minuscule
        var lowcaseFlag = regexMin.test(password);
        // Si le password contient au moins un Chiffre
        var numbercaseFlag = regexNum.test(password);

        if (uppercaseFlag)
        {
            majRequirement.querySelector('.fa-times').style.display = 'none';
            majRequirement.querySelector('.fa-check').style.display = 'inline';
            majRequirement.style.color = '#155724';
        }
        else
        {
            majRequirement.querySelector('.fa-times').style.display = 'inline';
            majRequirement.querySelector('.fa-check').style.display = 'none';
            majRequirement.style.color = '#721c24';
        }

        if (lowcaseFlag)
        {
            minRequirement.querySelector('.fa-times').style.display = 'none';
            minRequirement.querySelector('.fa-check').style.display = 'inline';
            minRequirement.style.color = '#155724';
        }
        else
        {
            minRequirement.querySelector('.fa-times').style.display = 'inline';
            minRequirement.querySelector('.fa-check').style.display = 'none';
            minRequirement.style.color = '#721c24';
        }

        if (numbercaseFlag)
        {
            numRequirement.querySelector('.fa-times').style.display = 'none';
            numRequirement.querySelector('.fa-check').style.display = 'inline';
            numRequirement.style.color = '#155724';
        }
        else
        {
            numRequirement.querySelector('.fa-times').style.display = 'inline';
            numRequirement.querySelector('.fa-check').style.display = 'none';
            numRequirement.style.color = '#721c24';
        }

        if (password.length>=8)
        {
            lengthRequirement.querySelector('.fa-times').style.display = 'none';
            lengthRequirement.querySelector('.fa-check').style.display = 'inline';
            lengthRequirement.style.color = '#155724';
        }
        else
        {
            lengthRequirement.querySelector('.fa-times').style.display = 'inline';
            lengthRequirement.querySelector('.fa-check').style.display = 'none';
            lengthRequirement.style.color = '#721c24';
        }

        if(password.length>=8 && uppercaseFlag && lowcaseFlag && numbercaseFlag)
        {
            var passwordValue = passwordInput.value;
            var confirmValue = confirmPasswordInput.value;

            passwordRequirements.querySelector('.alert-danger').style.background = '#c3e6cb';
            passwordRequirements.querySelector('.alert-danger').style.border = '1px solid #c3e6cb';

            if (isEqual(passwordValue, confirmValue) && emailUsable)
                registerBtn.disabled = false;
            else
                registerBtn.disabled = true;
        }
        else
        {
            passwordRequirements.querySelector('.alert-danger').style.background = '#f8d7da';
            passwordRequirements.querySelector('.alert-danger').style.border = '1px solid #f5c6cb';
            registerBtn.disabled = true;
        }
    }

    /**
     * Confirm password event
     */
    confirmPasswordInput.addEventListener('focus', e =>
    {
        var password = passwordInput.value;
        var confirm = confirmPasswordInput.value;

        if (isEqual(password, confirm))
        {
            confirmCheck.style.display = "block";
            confirmTimes.style.display = "none";
        }
        else
        {
            confirmCheck.style.display = "none";
            confirmTimes.style.display = "block";
        }
    });

    confirmPasswordInput.addEventListener('blur', e =>
    {
        confirmTimes.style.display = "none";
        confirmCheck.style.display = 'none';
    });

    confirmPasswordInput.addEventListener("keyup", e =>
    {
        var password = passwordInput.value;
        var confirm = confirmPasswordInput.value;

        if (isEqual(password, confirm))
        {
            confirmCheck.style.display = "block";
            confirmTimes.style.display = "none";
            isStrongPwd2(password);
        }
        else
        {
            confirmCheck.style.display = "none";
            confirmTimes.style.display = "block";
            isStrongPwd2(password);
        }
    });

    function isEqual (password, confirm)
    {
        if (password == confirm)
            return true;
        else
            return false;
    }

    /**
     * Buttons event
     */
    register.addEventListener("click", switchRegisterPanel, false);
    connect.addEventListener("click", switchConnectPanel, false);

    /**
     * Forms event
     */
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
});