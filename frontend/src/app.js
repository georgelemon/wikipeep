import elo from '@georgelemon/elo/dist/elo-es.min'
import appSwitchTheme from './core/switcher' 
import Meta from './core/meta'
import Layout from './components/layout'

const wikipeepWrapper = function() {
    return elo('div.container-fluid > div.row', () => [
        elo('div.col-lg-2.vh-100.position-fixed.main-sidebar', () => [
            elo('a.d-block.p-2.text-center', () => [
                elo('img.img-fluid.logo', null, {
                    src: './assets/wikipeep.png',
                    width: '100px',
                    alt: 'Wikipeep'
                })
            ]),

            elo('ul.list-group.mt-3', () => [
                elo('li.text-muted.text-uppercase > small', 'Contents'),
                elo('li', 'Getting Started'),
                elo('li', 'Examples'),
                elo('li', 'Development'),
                elo('li', 'Production'),
                elo('li', 'License'),
            ]),

            elo('a.d-block.p-2.text-center.text-decoration-none.wikipeep-foot', () => [
                elo('img.img-fluid', null, {
                    src: './assets/wikipeep-mono.png',
                    width: '33px',
                    alt: 'Wikipeep'
                }),
                elo('small.d-block > small', 'Made with Wikipeep<br>Open Source Wiki for Busy Devs'),
            ]),
        ]),
        // Main Content Area
        elo('div.col-lg-10.offset-lg-2.pt-4', () => [
            // Content Top bar
            elo('div.row > div.col-12 > div.px-3.mb-4 > div.row align-items-center', () => [
                elo('div.col-lg-2', () => [
                    elo('button.btn.btn-outline-dark.btn-sm', 'Offline'),
                    elo('button.theme-switcher.btn.btn-dark.btn-sm.ms-3', () => [
                        elo('span.icon-dark-theme', '<svg viewBox="0 0 24 24" width="18" height="18" stroke="white" stroke-width="1" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg>'),
                        elo('span.icon-light-theme', '<svg viewBox="0 0 24 24" width="18" height="18" stroke="white" stroke-width="1" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><circle cx="12" cy="12" r="5"></circle><line x1="12" y1="1" x2="12" y2="3"></line><line x1="12" y1="21" x2="12" y2="23"></line><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line><line x1="1" y1="12" x2="3" y2="12"></line><line x1="21" y1="12" x2="23" y2="12"></line><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line></svg>')
                    ]),
                ]),
                elo('div.col-lg-7', () => [
                    elo('input.form-control.rounded-pill', null, {
                        placeholder: 'Search in contents, sections and pages...'
                    })
                ]),
                elo('div.col-lg-3', () => [
                    elo('a.btn.btn-outline-success.btn-sm', 'Sponsor this project'),
                ]),
            ]),

            // Article View
            elo('div.row', () => [
                // Summary sidebar containing the anchors of the current article
                elo('div.col-lg-2 > div.sidebar-summary.py-3.ps-3', () => [
                    elo('li.text-muted.text-uppercase > small', 'Summary'),
                    elo('li', 'Requirements'),
                    elo('li', 'Installation'),
                    elo('li', 'Database'),
                    elo('li', 'Configuration'),
                    elo('li', 'Building Content'),
                ]),
                elo('div.col-lg-10 > div.py-3.ps-3.pe-5#content-area')
            ])
        ])
    ])
}

export default {
    init() {

        // fetch('http://0.0.0.0:6520/backdoor').then(async (Response) => {
        //     let response = await Response
        //     response = await response.json()
        //     response.entries.forEach(function(item) {
        //         console.log(item)
        //     })
        // }).catch((err) => console.log(err))

        document.addEventListener('DOMContentLoaded', async () => {
            elo().browserTest.start()
            await elo().compile('main', wikipeepWrapper)
            elo().browserTest.stop()

            Meta.init()
            appSwitchTheme()


            let wikipeepFoot = document.querySelector('.wikipeep-foot')
            wikipeepFoot.style.position = "absolute"
            wikipeepFoot.style.bottom = "20px"
            wikipeepFoot.style.color = "#292929"
            wikipeepFoot.style.left = "0"
            wikipeepFoot.style.right = "0"
            wikipeepFoot.style.cursor = "pointer"
            wikipeepFoot.style.lineHeight = "11px"
            wikipeepFoot.style.fontSize = "14px"
            wikipeepFoot.style.border = "1px dashed blue"
            wikipeepFoot.style.backgroundColor = "rgba(255,255,255,.8)"
            wikipeepFoot.style.margin = "0 20px"
            wikipeepFoot.style.borderRadius = "7px"

        fetch('http://0.0.0.0:6520/api').then(async (Response) => {
            let response = await Response
            response = await response.json()
            let contentArea = document.querySelector('#content-area')
            contentArea.innerHTML = response.entries
            // response.entries.forEach(function(item) {
            //     console.log(item)
            // })
        }).catch((err) => console.log(err))
            contentArea.innerHTML = "Could not retrieve contents"
        })
    }
}