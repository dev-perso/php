document.addEventListener("DOMContentLoaded", function()
{
    var register = document.getElementById("register");
    var signUpForm = document.getElementById("signUpForm");
    var signInForm = document.getElementById("signInForm");

    register.addEventListener("click", switchRegisterView, false);

    function switchRegisterView()
    {
        signUpForm.classList.remove('rightPanel-signIn');
        signUpForm.classList.add('leftPanel-signUp');

        signInForm.classList.remove('leftPanel-signIn');
        signInForm.classList.add('rightPanel-signUp');
    }
});