window.onload = function () {
    changeLanguage('ar');
};

function changeLanguage(language) {
    var headerText = document.getElementById('header-text');
    var showcaseText = document.getElementById('showcase-text');

    switch (language) {
        case 'ar':
            headerText.textContent = "المستشفى العسكري بتونس";
            showcaseText.textContent = "خدمات المخابر الطبية - النتائج";
            titreText.textContent = "اطلع على نتائجك"; 
            recuText.textContent = "رقم الاستلام"; 
            passwordText.textContent = "كلمة المرور"; 
            loginText.textContent = "رقم الهاتف"; 
            cnxText.textContent = "دخول";
            break;
        case 'fr':
            headerText.textContent = "Hôpital militaire principal d'instruction de Tunis";
            showcaseText.textContent = "Services des laboratoires de biologies médicales - Serveur de résultats";
            titreText.textContent = "Consultez vos résultats";
            recuText.textContent = "N° reçu";
            passwordText.textContent = "Mot de passe";
            loginText.textContent = "N° Telephone";
            cnxText.textContent = "Connexion";
            break;
        case 'en':
            headerText.textContent = "Military Hospital of Tunis";
            showcaseText.textContent = "Medical Biology Laboratories Services - Results Server";
            titreText.textContent = "Check your results";
            recuText.textContent = "File number";
            passwordText.textContent = "Password";
            loginText.textContent = "Phone number";
            cnxText.textContent = "Connect";
            break;
        default:
            headerText.textContent = "Military Hospital of Tunis";
            showcaseText.textContent = "Medical Biology Laboratories Services - Results Server";
            break;
    }
}
