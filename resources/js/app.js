const syncHeaderHeight = () => {
    const header = document.querySelector('header.navbar.fixed-top')
    if (!header) {
        return
    }

    const height = Math.ceil(header.getBoundingClientRect().height)
    document.documentElement.style.setProperty('--propsgh-header-height', `${height}px`)
}

const initHeaderHeightSync = () => {
    syncHeaderHeight()
    window.addEventListener('resize', syncHeaderHeight)
    window.addEventListener('load', syncHeaderHeight)
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initHeaderHeightSync)
} else {
    initHeaderHeightSync()
}
