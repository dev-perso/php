document.addEventListener("DOMContentLoaded", function()
{
    var cave            = document.getElementById("caveBtn");
    var cavePanel       = document.getElementById("cavePanel");
    var profile         = document.getElementById("profileBtn");
    var profilePanel    = document.getElementById("profilePanel");
    var archive         = document.getElementById("archiveBtn");
    var archivePanel    = document.getElementById("archivePanel");

    cavePanel.addEventListener("mouseenter", e =>
    {
        cavePanel.style.opacity = "0";
    });

    cavePanel.addEventListener("mouseout", e =>
    {
        cavePanel.style.opacity = "0.6";
    });

    profilePanel.addEventListener("mouseenter", e =>
    {
        profilePanel.style.opacity = "0";
    });

    profilePanel.addEventListener("mouseout", e =>
    {
        profilePanel.style.opacity = "0.6";
    });

    archivePanel.addEventListener("mouseenter", e =>
    {
        archivePanel.style.opacity = "0";
    });

    archivePanel.addEventListener("mouseout", e =>
    {
        archivePanel.style.opacity = "0.6";
    });

    cave.addEventListener("click", e =>
    {
        window.location.href = "/caveavin";
    });

    cavePanel.addEventListener("click", e =>
    {
        window.location.href = "/caveavin";
    });

    profile.addEventListener("click", e =>
    {
        window.location.href = "/gestion/profile";
    });

    profilePanel.addEventListener("click", e =>
    {
        window.location.href = "/gestion/profile";
    });

    archive.addEventListener("click", e =>
    {
        window.location.href = "/caveavin/archive";
    });

    archivePanel.addEventListener("click", e =>
    {
        window.location.href = "/caveavin/archive";
    });
});