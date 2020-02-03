require('./scss/recetteDIY.scss');
require('./ts/partials/layout.ts');

let difficultyBlock = document.getElementById("difficultyBlock");
if(difficultyBlock !== null){
    let difficulty = difficultyBlock.getAttribute("data-difficulty");
    let niveau = document.getElementsByClassName("listDifficulty") as HTMLCollectionOf<HTMLElement>;

    let niv1 = "rgb(70, 210, 70)";
    let niv2 = "rgb(40, 164, 40)";
    let niv3 = "rgb(25, 103, 25)";
    let niv4 = "rgb(20, 82, 20)";
    let intensity = [niv1, niv2, niv3, niv4];

    if (difficulty !== null) {
        let diff = parseInt(difficulty);
        switch (diff) {
            case 1:
                for (let i = 0; i < diff; i++) {
                    niveau[i].style.backgroundColor = intensity[i];
                }
                break;
            case 2:
                for (let i = 0; i < diff; i++) {
                    niveau[i].style.backgroundColor = intensity[i];
                }
                break;
            case 3:
                for (let i = 0; i < diff; i++) {
                    niveau[i].style.backgroundColor = intensity[i];
                }
                break;
            case 4:
                for (let i = 0; i < diff; i++) {
                    niveau[i].style.backgroundColor = intensity[i];
                }
                break;
            default:
                niveau[0].style.backgroundColor = "red";
        }
    }
}
