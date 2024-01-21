// translations.js

var translations = {
    en: {
        hospital_name: "Main Military Teaching Hospital of Tunis",
        services_text: "Medical Biology Laboratories Services - Results Server",
        filter_label: "Filter by Laboratory:",
        all_labs_option: "All Laboratories",
        publication_date_text: "Publication Date:",
        request_date_text: "Request Date:",
        document_number_text: "Document No:",
        logout_title: "Logout",
    },
    fr: {
        hospital_name: "Hôpital militaire principal d'instruction de Tunis",
        services_text: "Services des laboratoires de biologies médicales - Serveur de résultats",
        filter_label: "Filtrer par laboratoire:",
        all_labs_option: "Tous les laboratoires",
        publication_date_text: "Date de publication:",
        request_date_text: "Demande du:",
        document_number_text: "Document N°:",
        logout_title: "Déconnexion",
    },
    ar: {
        hospital_name: "اسم المستشفى باللغة العربية",
        services_text: "نص الخدمات باللغة العربية",
        filter_label: "تصفية حسب المختبر:",
        all_labs_option: "جميع المختبرات",
        publication_date_text: "تاريخ النشر:",
        request_date_text: "تاريخ الطلب:",
        document_number_text: "رقم الوثيقة:",
        logout_title: "تسجيل الخروج",
    },
};

function translate(key, language) {
    return translations[language][key] || key;
}
