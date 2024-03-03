document.addEventListener('DOMContentLoaded', () => {

    const actionMenuToggles = document.querySelectorAll('.action-menu-toggle');
    const actionMenus = document.querySelectorAll('.action-menu');

    actionMenuToggles.forEach((actionMenuToggle, index) => {
        actionMenuToggle.addEventListener("click", () => {
            if(actionMenus[index].classList.contains('flex')) {
                actionMenus[index].classList.remove('flex')
                actionMenus[index].classList.add('hidden')
            } else {
                actionMenus[index].classList.add('flex')
                actionMenus[index].classList.remove('hidden')
            }
        })
    })
})