document.addEventListener("DOMContentLoaded", function()
{
    var passwordInput           = document.getElementById("passwordInput");
    var passwordRequirements    = document.getElementById("requirements");
    var lengthRequirement       = document.getElementById('passLength');
    var minRequirement          = document.getElementById('passMin');
    var majRequirement          = document.getElementById('passMaj');
    var numRequirement          = document.getElementById('passNum');

    var registerBtn             = document.getElementById('registerBtn');
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
        passwordRequirements.style.display = 'none';
    });

    passwordInput.addEventListener("keyup", e =>
    {
        var password = passwordInput.value;
        isStrongPwd2(password);
    });


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
            passwordRequirements.querySelector('.alert-danger').style.background = '#c3e6cb';
            registerBtn.disabled = false;
        }
        else
        {
            passwordRequirements.querySelector('.alert-danger').style.background = '#f8d7da';
            registerBtn.disabled = true;
        }

    }

    function contains(password, allowedChars)
    {
        for (i = 0; i < password.length; i++)
        {
            var char = password.charAt(i);
            if (allowedChars.indexOf(char) >= 0) { return true; }
        }
        return false;
    }

});