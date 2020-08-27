document.addEventListener("DOMContentLoaded", function()
{
    var register    = document.getElementById("register");
    var connect     = document.getElementById("connect");
    var signUpForm  = document.getElementById("signUpForm");
    var signInForm  = document.getElementById("signInForm");

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
});