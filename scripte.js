document.addEventListener('DOMContentLoaded', function() {
    // Gestion du clic sur le bouton "Free Tour"
    document.getElementById('freeTourBtn').addEventListener('click', function() {
        // Rediriger l'utilisateur vers le free tour (à implémenter)
        window.location.href = 'login.html';
    });
 

    // Gestion du clic sur le bouton "S'inscrire / Se connecter"
    document.getElementById('inscriptionBtn').addEventListener('click', function() {
        // Rediriger l'utilisateur vers la page d'inscription (à implémenter)
        window.location.href = 'login.html';
    });
   function redirectToSignup() {
    // Redirection vers la page d'inscription
    window.location.href = "login.html";
}
});
