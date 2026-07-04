// const adminSidebar = document.getElementById('admin-sidebar');
// const adminSidebarOverlay = document.getElementById('admin-sidebar-overlay');
// const adminSidebarOpen = document.getElementById('admin-sidebar-open');
// const adminSidebarClose = document.getElementById('admin-sidebar-close');
//
// function openAdminSidebar() {
//     adminSidebar.classList.remove('-translate-x-full');
//     adminSidebarOverlay.classList.remove('hidden');
// }
//
// function closeAdminSidebar() {
//     adminSidebar.classList.add('-translate-x-full');
//     adminSidebarOverlay.classList.add('hidden');
// }
//
// adminSidebarOpen?.addEventListener('click', openAdminSidebar);
// adminSidebarClose?.addEventListener('click', closeAdminSidebar);
// adminSidebarOverlay?.addEventListener('click', closeAdminSidebar);
// document.addEventListener('keydown', function (event) {
//     if (event.key === 'Escape') {
//         closeAdminSidebar();
//     }
// });
document.getElementById('mobile-menu-btn')?.addEventListener('click', function() {
    document.getElementById('mobile-menu').classList.toggle('hidden');
});
