function setThemeOnLoad() {
    if (
        localStorage.theme == "dark" ||
        (!("theme" in localStorage) &&
            window.matchMedia("(prefers-color-scheme: dark").matches)
    ) {
        document.documentElement.classList.add("dark");
    } else {
        document.documentElement.classList.remove("dark");
    }
    const primary = window.APP_PRIMARY_COLOR;
    if (primary) {
        document.documentElement.style.setProperty("--primary", primary);
        document.documentElement.style.setProperty("--ring", primary);
    }
}
function switchTheme() {
    if (
        localStorage.theme == "dark" ||
        (!("theme" in localStorage) &&
            window.matchMedia("(prefers-color-scheme: dark").matches)
    ) {
        document.documentElement.classList.remove("dark");
        localStorage.theme = "light";
    } else {
        document.documentElement.classList.add("dark");
        localStorage.theme = "dark";
    }
}
export { setThemeOnLoad, switchTheme };
