<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Projet Vue</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
    <script src='main.js'></script>
</head>
<body>
    <div id="app">
        <form v-on:submit.prevent="ajouterEtudiant">
            <div v-for="x in colonne">
                <label v-bind:for="x.name">{{ x.label }} :</label>
                <input type="text" v-bind:name="x.name" v-model="x.value"  v-bind:pattern="x.pattern" required >
                <br><br>
                <div class="line-break"></div>
            </div>
            <button type="submit">Ajouter</button>
        </form>

        <div>
           <table>
                <tr>
                    <th v-for="titre in head">{{titre}}</th>
                </tr>
                <tr v-for="elev in eleve">
                    <td v-for="elem in elev">{{elem}}</td>
                    <td><button>Modifier</button></td>
                    <td><button>Supprimer</button></td>
                </tr>
           </table>
       </div>


        <div>
            <p>Liste des étudiants</p>
            <ul>
              <li v-for="etudiant in etudiants"> numEt: {{ etudiant.num }} , nom: {{ etudiant.nom }} , note_math: {{ etudiant.math }} , note_phys: {{ etudiant.phys }}</li>
            </ul>
        </div>

        <script src="vue.js"></script>
        <script>
          const app = new Vue({
                el:'#app',
                data: {
                    colonne: [
                        { name: 'numEt', label: "Numéro de l'étudiant", value: '', pattern: '^[0-9]+$' },
                        { name: 'nom', label:"Nom de l'étudiant", value: '' ,pattern: '^[a-z]+$'},
                        { name: 'note_math', label: 'Note en mathématique', value: '' ,pattern: '^[0-9]+[.0-9]?$'},
                        { name: 'note_phys', label: 'Note en physique', value: '',pattern: '^[0-9]+[.0-9]?$'},
                    ],
                
                    etudiants:[],
                    head : ["Nom de l'élève","Numero de l'élève ","Note de math",'Note de phys'],
                    eleve : [
                        {numEt : "4456" , nom : "Andry", note_math : 15 , note_phys : 15},
                        {numEt : "645645" , nom : "Ary", note_math : 15 , note_phys : 15},
                        {numEt : "456" , nom : "Leo", note_math : 15 , note_phys : 15},
                        {numEt : "456" , nom : "Pen", note_math : 15 , note_phys : 15},
                    ]
                },

                methods: {
                    ajouterEtudiant() {
                        let etudiant = {
                            num: this.colonne[0].value,
                            nom: this.colonne[1].value,
                            math: this.colonne[2].value,
                            phys: this.colonne[3].value
                        }
                        this.etudiants.push(etudiant)
                        this.colonne.forEach((x) => {
                            x.value = '';
                        });
                    }
                }
        })
        </script>
    </div>
</body>
</html>
