<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon petit front</title>
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2c3e50;
            --accent-color: #e74c3c;
            --light-color: #ecf0f1;
            --dark-color: #34495e;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: var(--light-color);
            color: var(--dark-color);
        }
        
        h1 {
            text-align: center;
            color: var(--secondary-color);
            margin-bottom: 30px;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }
        
        .card h2 {
            color: var(--primary-color);
            margin-top: 0;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }
        
        button {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        button:hover {
            background-color: #2980b9;
        }
        
        button.danger {
            background-color: var(--accent-color);
        }
        
        button.danger:hover {
            background-color: #c0392b;
        }
        
        input, select, textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }
        
        textarea {
            min-height: 100px;
            resize: vertical;
        }
        
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        .recruiter-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }
        
        .recruiter-card {
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 15px;
            background-color: white;
        }
        
        .flex-row {
            display: flex;
            gap: 10px;
            align-items: center;
        }
        
        .flex-row input {
            flex: 1;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Gestionnaire de Recruteurs</h1>

        <div class="card">
            <h2>Liste des recruteurs</h2>
            <button id="btn-get-recruiters" class="primary" >Obtenir tous les recruteurs</button>
            <div id="all-recruiters" class="recruiter-list">
                <!-- Les recruteurs seront affichés ici -->
            </div>
        </div>

        <div class="card">
            <h2>Rechercher un recruteur</h2>
            <div class="flex-row">
                <input type="text" id="input-recruteur" placeholder="Entrez l'ID du recruteur">
                <button id="btn-get-recruiter" >Rechercher</button>
            </div>
            <div id="recruiter-by-id">
                <!-- Le recruteur recherché sera affiché ici -->
            </div>
        </div>

        <div class="card">
            <h2>Ajouter un recruteur</h2>
            <form id="add-recruiter">
                <div class="form-group">
                    <label for="firstName">Prénom:</label>
                    <input type="text" id="firstName" name="firstName" required>
                </div>

                <div class="form-group">
                    <label for="lastName">Nom:</label>
                    <input type="text" id="lastName" name="lastName" required>
                </div>

                <div class="form-group">
                    <label for="company">Entreprise:</label>
                    <input type="text" id="company" name="company" required>
                </div>

                <div class="form-group">
                    <label for="linkedinProfile">Profil LinkedIn:</label>
                    <input type="url" id="linkedinProfile" name="linkedinProfile" required>
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="phone">Téléphone:</label>
                    <input type="tel" id="phone" name="phone">
                </div>

                <div class="form-group">
                    <label for="status">Statut:</label>
                    <select id="status" name="status" required>
                        <option value="Nouveau">Nouveau</option>
                        <option value="En discussion">En discussion</option>
                        <option value="En cours de process">En cours de process</option>
                        <option value="Terminé">Terminé</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="notes">Notes:</label>
                    <textarea id="notes" name="notes"></textarea>
                </div>

                <button type="submit">Ajouter le recruteur</button>
            </form>
        </div>

        <div class="card">
            <h2>Supprimer un recruteur</h2>
            <div class="flex-row">
                <label for="recruiterId">ID du recruteur:</label>
                <input type="text" id="recruiterId" name="recruiterId" required>
                <button type="button" id="deleteRecruiter" class="danger">Supprimer</button>
            </div>
        </div>
    </div>

    <script src="./recruteur.js"></script>
</body>
</html>