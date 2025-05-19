// Configuration de l'API
const API_URL = 'http://localhost:8000/api';
const API_KEY = '123';

// Éléments du DOM
const btnGetRecruiters = document.getElementById('btn-get-recruiters');
const btnGetRecruiter = document.getElementById('btn-get-recruiter');
const btnDeleteRecruiter = document.getElementById('deleteRecruiter');
const formAddRecruiter = document.getElementById('add-recruiter');
const inputRecruiterId = document.getElementById('input-recruteur');
const inputDeleteRecruiterId = document.getElementById('recruiterId');
const allRecruitersSection = document.getElementById('all-recruiters');
const recruiterByIdSection = document.getElementById('recruiter-by-id');

// Fonction pour charger la clé API de façon sécurisée (à exécuter au démarrage)
async function loadApiKey() {
    try {
        // Option 1: Récupérer la clé API depuis un endpoint sécurisé
        const response = await fetch('/get-api-key', {
            credentials: 'same-origin' // Important pour la sécurité - envoie les cookies
        });
        
        if (!response.ok) {
            throw new Error('Impossible de récupérer la clé API');
        }
        
        const data = await response.json();
        API_KEY = data.apiKey;
        
        console.log('Clé API chargée avec succès');
    } catch (error) {
        console.error('Erreur lors du chargement de la clé API:', error);
    }
}

// Fonction pour créer les en-têtes avec authentification
function getHeaders() {
    return {
        'Content-Type': 'application/json',
        'Authorization': `Bearer ${API_KEY}`
    };
}

// Fonction pour afficher un message d'erreur
function showError(message, container) {
    container.innerHTML = `
        <div style="color: var(--accent-color); padding: 10px; border: 1px solid var(--accent-color); border-radius: 4px; margin-top: 10px;">
            <strong>Erreur:</strong> ${message}
        </div>
    `;
}

// Fonction pour récupérer tous les recruteurs
async function getAllRecruiters() {
    try {
        allRecruitersSection.innerHTML = '<p>Chargement en cours...</p>';
        
        const response = await fetch(`${API_URL}/recruiters`, {
            headers: getHeaders()
        });
        
        if (!response.ok) {
            throw new Error(`Erreur HTTP: ${response.status}`);
        }
        
        const recruiters = await response.json();
        
        if (recruiters.length === 0) {
            allRecruitersSection.innerHTML = '<p>Aucun recruteur trouvé.</p>';
            return;
        }
        
        let html = '';
        recruiters.forEach(recruiter => {
            html += `
                <div class="recruiter-card">
                    <h3>${recruiter.firstName} ${recruiter.lastName}</h3>
                    <p><strong>ID:</strong> ${recruiter.id}</p>
                    <p><strong>Entreprise:</strong> ${recruiter.company}</p>
                    <p><strong>Email:</strong> ${recruiter.email}</p>
                    <p><strong>Statut:</strong> ${recruiter.status}</p>
                    <p>
                        <a href="${recruiter.linkedinProfile}" target="_blank" style="color: var(--primary-color);">
                            Profil LinkedIn
                        </a>
                    </p>
                </div>
            `;
        });
        
        allRecruitersSection.innerHTML = html;
    } catch (error) {
        showError(error.message, allRecruitersSection);
    }
}

// Fonction pour récupérer un recruteur par ID
async function getRecruiterById(id) {
    try {
        if (!id) {
            throw new Error("L'ID du recruteur est requis");
        }
        
        recruiterByIdSection.innerHTML = '<p>Chargement en cours...</p>';
        
        const response = await fetch(`${API_URL}/recruiters/${id}`, {
            headers: getHeaders()
        });
        
        if (!response.ok) {
            if (response.status === 404) {
                throw new Error(`Recruteur avec l'ID ${id} non trouvé.`);
            }
            throw new Error(`Erreur HTTP: ${response.status}`);
        }
        
        const recruiter = await response.json();
        
        recruiterByIdSection.innerHTML = `
            <div class="recruiter-card">
                <h3>${recruiter.firstName} ${recruiter.lastName}</h3>
                <p><strong>ID:</strong> ${recruiter.id}</p>
                <p><strong>Entreprise:</strong> ${recruiter.company}</p>
                <p><strong>Email:</strong> ${recruiter.email}</p>
                <p><strong>Téléphone:</strong> ${recruiter.phone || 'Non spécifié'}</p>
                <p><strong>Statut:</strong> ${recruiter.status}</p>
                <p><strong>Notes:</strong> ${recruiter.notes || 'Aucune note'}</p>
                <p>
                    <a href="${recruiter.linkedinProfile}" target="_blank" style="color: var(--primary-color);">
                        Profil LinkedIn
                    </a>
                </p>
            </div>
        `;
    } catch (error) {
        showError(error.message, recruiterByIdSection);
    }
}

// Fonction pour ajouter un recruteur
async function addRecruiter(event) {
    event.preventDefault();
    
    try {
        const formData = new FormData(formAddRecruiter);
        const recruiterData = {
            firstName: formData.get('firstName'),
            lastName: formData.get('lastName'),
            company: formData.get('company'),
            linkedinProfile: formData.get('linkedinProfile'),
            email: formData.get('email'),
            phone: formData.get('phone') || null,
            status: formData.get('status'),
            notes: formData.get('notes') || null
        };
        
        const response = await fetch(`${API_URL}/recruiters`, {
            method: 'POST',
            headers: getHeaders(),
            body: JSON.stringify(recruiterData)
        });
        
        if (!response.ok) {
            throw new Error(`Erreur HTTP: ${response.status}`);
        }
        
        const newRecruiter = await response.json();
        
        // Réinitialiser le formulaire
        formAddRecruiter.reset();
        
        // Afficher un message de succès
        alert(`Recruteur ${newRecruiter.firstName} ${newRecruiter.lastName} ajouté avec succès !`);
        
        // Actualiser la liste des recruteurs
        getAllRecruiters();
    } catch (error) {
        alert(`Erreur lors de l'ajout du recruteur: ${error.message}`);
    }
}

// Fonction pour supprimer un recruteur
async function deleteRecruiter() {
    const id = inputDeleteRecruiterId.value.trim();
    
    if (!id) {
        alert("Veuillez entrer l'ID du recruteur à supprimer.");
        return;
    }
    
    try {
        if (!confirm(`Êtes-vous sûr de vouloir supprimer le recruteur avec l'ID ${id} ?`)) {
            return;
        }
        
        const response = await fetch(`${API_URL}/recruiters/${id}`, {
            method: 'DELETE',
            headers: getHeaders()
        });
        
        if (!response.ok) {
            if (response.status === 404) {
                throw new Error(`Recruteur avec l'ID ${id} non trouvé.`);
            }
            throw new Error(`Erreur HTTP: ${response.status}`);
        }
        
        // Réinitialiser le champ
        inputDeleteRecruiterId.value = '';
        
        // Afficher un message de succès
        alert(`Recruteur supprimé avec succès !`);
        
        // Actualiser la liste des recruteurs
        getAllRecruiters();
    } catch (error) {
        alert(`Erreur lors de la suppression du recruteur: ${error.message}`);
    }
}

// Événements
btnGetRecruiters.addEventListener('click', getAllRecruiters);
btnGetRecruiter.addEventListener('click', () => getRecruiterById(inputRecruiterId.value.trim()));
btnDeleteRecruiter.addEventListener('click', deleteRecruiter);
formAddRecruiter.addEventListener('submit', addRecruiter);

// Charger les recruteurs au chargement de la page
document.addEventListener('DOMContentLoaded', () => {
    // Uncomment the line below if you want to load recruiters on page load
    // getAllRecruiters();
});