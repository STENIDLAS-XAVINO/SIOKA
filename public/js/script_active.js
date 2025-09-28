// document.addEventListener('DOMContentLoaded', function() {
//         // Récupère l'URL de la page actuelle (par exemple, "https://votre-site.com/articles")
//         const currentUrl = window.location.href;

//         // Sélectionne tous les liens de navigation
//         const navLinks = document.querySelectorAll('.nav-link');

//         // Parcours chaque lien
//         navLinks.forEach(link => {
//             // Vérifie si l'URL du lien est présente dans l'URL actuelle de la page
//             if (currentUrl.includes(link.href)) {
//                 // Si oui, retire d'abord la classe "active" des autres liens...
//                 navLinks.forEach(item => item.classList.remove('active'));
//                 // ...puis ajoute la classe "active" à ce lien
//                 link.classList.add('active');
//             }
//         });
//     });