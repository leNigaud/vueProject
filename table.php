
    <div id="ell">
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
    </div>
    <script src="vue.js"></script>
    <script type="text/javascript">
        var vm = new Vue({
            el : "#ell",
            data : {
                head : ["Nom de l'élève","Numero de l'élève ","Note de math",'Note de phys'],
                eleve : [
                    {numEt : "4456" , nom : "Andry", note_math : 15 , note_phys : 15},
                    {numEt : "645645" , nom : "Ary", note_math : 15 , note_phys : 15},
                    {numEt : "456" , nom : "Leo", note_math : 15 , note_phys : 15},
                    {numEt : "456" , nom : "Pen", note_math : 15 , note_phys : 15},
                ]
            }
        })
    </script>
