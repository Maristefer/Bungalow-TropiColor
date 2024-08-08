

document.addEventListener('DOMContentLoaded', function() 
{
    const menuBurger = document.querySelector('.menu-burger');
    const menu = document.querySelector('.menu');
    const sousMenus = document.querySelectorAll('.scrolling-menu .under-menu');

    // Pour ouvrir et fermer le menu burger
    menuBurger.addEventListener('click', function() 
    {
        console.log('Menu burger clicked');
        menu.classList.toggle('active');
    });
    
     // Pour afficher/masquer le sous-menu
    document.querySelectorAll('.scrolling-menu').forEach(function(menuItem) 
    {
        menuItem.addEventListener('click', function(event) 
        {
            event.preventDefault(); // Empêche le rechargement de la page
            const sousMenu = menuItem.querySelector('.under-menu');
            sousMenu.classList.toggle('active');
            console.log('Sub-menu toggled');
        });
        
    });
});
/*Toggle de classe : Si vous avez plusieurs sous-menus, vous devrez peut-être adapter le code pour gérer 
plusieurs sous-menus simultanément, en fonction du contexte de votre projet.
Gestion des clics extérieurs : Pour améliorer l'expérience utilisateur, 
vous pouvez ajouter un événement qui ferme le menu ou le sous-menu si l'utilisateur clique en dehors de ces éléments.*/
/*Ce code vérifie si le clic est en dehors du menu ou du sous-menu, et ferme ces éléments si nécessaire.*/
/*document.addEventListener('click', function(event) {
    if (!menu.contains(event.target) && !menuBurger.contains(event.target)) {
        menu.classList.remove('active');
    }
    if (!menuDeroul.contains(event.target) && !sousMenu.contains(event.target)) {
        sousMenu.classList.remove('active');
    }
});*/