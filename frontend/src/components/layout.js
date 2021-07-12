const layout = (getViewComponent, isFluid = true) => {
    let container = isFluid ? 'container-fluid' : 'container'
    return elo(`div.${container} > div.row`, getViewComponent())
}

export default layout