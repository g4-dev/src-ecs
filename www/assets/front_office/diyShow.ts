require('./scss/diyShow.scss');
require('./ts/partials/layout.ts');

let difficultyBlock = document.getElementById("difficultyBlock");
if(difficultyBlock !== null){
    let difficulty = difficultyBlock.getAttribute("data-difficulty");
    let difficultyLvl = document.getElementsByClassName("listDifficulty") as HTMLCollectionOf<HTMLElement>;

    /* Liste différente couleurs d'intensité à revoir */
    let niv1 = "rgb(70, 210, 70)";
    let niv2 = "rgb(40, 164, 40)";
    let niv3 = "rgb(25, 103, 25)";
    let niv4 = "rgb(20, 82, 20)";
    let intensity = [niv1, niv2, niv3, niv4];

    /* Gestion de la barre de difficulté en fonction du niveau insérer dans l'attribut "data-difficulty" de la vue
     diy/show */
    if (difficulty !== null) {
        let diff = parseInt(difficulty);
        switch (diff) {
            case 1:
                for (let i = 0; i < diff; i++) {
                    difficultyLvl[i].style.backgroundColor = intensity[i];
                }
                break;
            case 2:
                for (let i = 0; i < diff; i++) {
                    difficultyLvl[i].style.backgroundColor = intensity[i];
                }
                break;
            case 3:
                for (let i = 0; i < diff; i++) {
                    difficultyLvl[i].style.backgroundColor = intensity[i];
                }
                break;
            case 4:
                for (let i = 0; i < diff; i++) {
                    difficultyLvl[i].style.backgroundColor = intensity[i];
                }
                break;
            default:
                difficultyLvl[0].style.backgroundColor = "red";
        }
    }
}
