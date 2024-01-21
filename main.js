function filterPDFs() {
    let categoryFilter = document.getElementById('categoryFilter');
    let selectedCategory = categoryFilter.value;

    let pdfGroups = document.querySelectorAll('.pdf-group');
    pdfGroups.forEach(function(pdfGroup) {
        let pdfItems = pdfGroup.querySelectorAll('.pdf-item');
        let hasVisibleItems = false;

        pdfItems.forEach(function(pdfItem) {
            let itemCategory = pdfItem.getAttribute('data-category');

            if (selectedCategory === 'all' || selectedCategory === itemCategory) {
                pdfItem.style.display = 'block';
                hasVisibleItems = true;
            } else {
                pdfItem.style.display = 'none';
            }
        });

        let datePublicationSection = pdfGroup.querySelector('.pdf-group-title');

        // Hide date publication section if there are no visible pdf items
        if (hasVisibleItems) {
            datePublicationSection.style.display = 'block';
        } else {
            datePublicationSection.style.display = 'none';
        }
    });
}

function logout() {
    document.cookie = 'user_found=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
    window.location.href = 'login.php?logout=true';
}
window.onload = function () {
    changeLanguage('ar');
};
function changeLanguage(language) {
    let headerText = document.getElementById('header-text');
    let showcaseText = document.getElementById('showcase-text');
    let demandeText = document.getElementsByClassName('demande-text');
    let docText = document.getElementsByClassName('doc-text');
    let pdftext = document.getElementsByClassName('pdf-group-text');
    let titleText = document.getElementById('title-text');
    let filterAll  = document.getElementById('filter-all-text');
    
    switch (language) {
        case 'ar':
            document.documentElement.lang = 'ar';
            //document.documentElement.dir = 'rtl';
            titleText.textContent = "النتائج";
            headerText.textContent = "المستشفى العسكري بتونس";
            showcaseText.textContent = "خدمات المخابر الطبية - النتائج";
            filterAll.textContent = "جميع المخابر"
            for (let i = 0; i < pdftext.length; i++) {
                pdftext[i].textContent = "تاريخ النشر: " 
            }
            for (let i = 0; i < docText.length; i++) {
                docText[i].textContent = "رقم الوثيقة : "
            }
            for (let i = 0; i < demandeText.length; i++) {
                demandeText[i].textContent = "تاريخ الطلب: "
            }   
            break;
        case 'fr':
            document.documentElement.lang = 'fr';
            document.documentElement.dir = 'ltr';
            filterAll.textContent = "Tous les laboratoires";
            titleText.textContent = "Serveur de resultats | Syslab";
            headerText.textContent = "Hôpital militaire principal d'instruction de Tunis";
            showcaseText.textContent = "Services des laboratoires de biologies médicales - Serveur de résultats";
            for (let i = 0; i < pdftext.length; i++) {
                pdftext[i].textContent = "Date de publication: " 
            }
            for (let i = 0; i < docText.length; i++) {
                docText[i].textContent = "Document N°: "
            }
            for (let i = 0; i < demandeText.length; i++) {
                demandeText[i].textContent = "Demande du: "
            }             
            break;
        case 'en':
            document.documentElement.lang = 'en';
            document.documentElement.dir = 'ltr';
            filterAll.textContent = "All laboratories";
            titleText.textContent = "Results server | Syslab";
            headerText.textContent = "Military Hospital of Tunis";
            showcaseText.textContent = "Medical Biology Laboratories Services - Results Server";
            for (let i = 0; i < pdftext.length; i++) {
                pdftext[i].textContent = "Date of publication: "
            }
            for (let i = 0; i < demandeText.length; i++) {
                demandeText[i].textContent = "Request of: "
            }
            for (let i = 0; i < docText.length; i++) {
                docText[i].textContent = "Document N°: "
            }
            break;
        default:
            headerText.textContent = "Military Hospital of Tunis";
            showcaseText.textContent = "Medical Biology Laboratories Services - Results Server";
            break;
    }
}
