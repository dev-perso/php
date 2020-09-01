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
        cavePanel.style.display = "none";
    });

    cave.addEventListener("mouseout", e =>
    {
        cavePanel.style.display = "inline";
    });

    profilePanel.addEventListener("mouseenter", e =>
    {
        profilePanel.style.display = "none";
    });

    profile.addEventListener("mouseout", e =>
    {
        profilePanel.style.display = "inline";
    });

    archivePanel.addEventListener("mouseenter", e =>
    {
        archivePanel.style.display = "none";
    });

    archive.addEventListener("mouseout", e =>
    {
        archivePanel.style.display = "inline";
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