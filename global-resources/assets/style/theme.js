let themeSwitch = document.querySelector('#themeSwitch input');
const html = document.documentElement.classList;


themeSwitch.addEventListener('change', function() {
    if (this.checked) {
        theme_transition();
    } else {
        theme_transition()
    }
})


// THEME SWITCH
function theme_transition() {
    if (html.contains('dark')) {
        html.remove('dark');
        html.add('theme-transition');
        setTimeout(() => {
            html.remove('theme-transition');
        }, 1000);
    } else {
        html.add('theme-transition');
        html.add('dark');
        setTimeout(() => {
            html.remove('theme-transition');
        }, 1000);
    }
}