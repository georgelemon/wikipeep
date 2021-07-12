/**
 * Search for all classes related to colors and switch according to the current theme.
 */
function switchingContrastColors(mode)
{
    // todo extend so it can apply for all elements
    // When entering dark mode we need to search for all
    // classes related to light mode and force switch to dark mode
    if( mode === 'darkmode' ) {
        let elements = document.querySelectorAll('.is-light');
        elements.forEach(function(el) {
            el.classList.toggle('is-light');
            el.classList.add('is-dark');
        });
    } else {
        let elements = document.querySelectorAll('.is-dark');
        elements.forEach(function(el) {
            el.classList.toggle('is-dark');
            el.classList.add('is-light');
        });
    }
}

/**
 * Creating the Theme switcher
 */
const themeSwitcher = () => {

    // Automatically switch to a preferred theme according to the OS theme preference.
    let AutoPreferredTheme = (matchMedia('(prefers-color-scheme: dark)').matches ? 'theme-dark' : 'theme-light');
    let BodyClass = document.body.classList;
        BodyClass.add(AutoPreferredTheme);

    document.querySelector('.theme-switcher').addEventListener('click', function(event) {
            let btn = event.currentTarget;
            btn.classList.toggle('lights_on');
            // Adding a temporary class for creating a fluent transition between themes
            BodyClass.add('switching-theme');

            if( BodyClass.contains('theme-dark') ) {
                BodyClass.toggle('theme-dark');
                BodyClass.add('theme-light');
                
                switchingContrastColors('lightmode');

            } else {
                BodyClass.toggle('theme-light');
                BodyClass.add('theme-dark');

                switchingContrastColors('darkmode');
            }

        });

}

export default themeSwitcher