//ステージクラス
class Stage{
    constructor(stage){
        this.arrMap = [];

        this.bossMode = 0;

        let arr = stage.split('\n');//\n毎に分ける

       
        for(let i = 0; i < arr.length; i++){
            const arr2 = [...arr[i]];
            this.arrMap.push(arr2);
        }
        
    }

    readMap(readNum){
        for(let i = 0; i < 20; i++){
            let readi = this.arrMap[STAGE_LEN - readNum][i];
            if(readi == 'A' || readi == 'a'){
                monster.push(new MonsterA(32 * i + 16, 100));//スライムその1
            }else if (readi == 'B' || readi == 'b') {
                monster.push(new MonsterB(32 * i + 16, 150));//スライムその2
            }else if (readi == 'C' || readi == 'c') {
                monster.push(new MonsterC(32 * i + 16, 300));//スライムその3
            }else if (readi == 'D' || readi == 'd') {
                monster.push(new MonsterD(32 * i, 200));//カニその1
            }else if (readi == 'E' || readi == 'e') {
                monster.push(new MonsterE(32 * i, 500));//カニその2
            }else if (readi == 'F' || readi == 'f') {
                monster.push(new MonsterF(32 * i, 400));//カニその3
            }else if (readi == 'G' || readi == 'g') {
                monster.push(new MonsterG(32 * i, 200));//妖精その1
            }else if (readi == 'H' || readi == 'h') {
                monster.push(new MonsterH(32 * i, 250));//妖精その2
            }else if (readi == 'I' || readi == 'i') {
                monster.push(new MonsterI(32 * i, 300));//妖精その3
            }else if (readi == 'J' || readi == 'j') {
                monster.push(new MonsterJ(32 * i + 16, 300));//ツタンカーメンその1
            }else if (readi == 'K' || readi == 'k') {
                monster.push(new MonsterK(32 * i + 16, 400));//ツタンカーメンその2
            }else if (readi == 'L' || readi == 'l') {
                monster.push(new MonsterL(32 * i + 16, 450));//ツタンカーメンその3
            }else if (readi == 'M' || readi == 'm') {
                monster.push(new MonsterM(32 * i + 16, 200));//スケルトンその1
            }else if (readi == 'N' || readi == 'n') {
                monster.push(new MonsterN(32 * i + 16, 300));//スケルトンその2
            }else if (readi == 'O' || readi == 'o') {
                monster.push(new MonsterO(32 * i + 16, 500));//スケルトンその3
            }
        }

        if(STAGE_LEN - readNum == 0 && this.bossMode == 0){
            this.bossMode = 1;
            if(document.getElementById("stage_select").value == 1){
                boss.push(new Boss1(32 * 10, 100, 5000));
            }else if(document.getElementById("stage_select").value == 2){
                boss.push(new Boss2(32 * 10, 100, 5700));
            }else if(document.getElementById("stage_select").value == 3){
                boss.push(new Boss3(32 * 10, 100, 7200));
            }else if(document.getElementById("stage_select").value == 4){
                boss.push(new Boss4(32 * 10, 100, 8000));
            }else if(document.getElementById("stage_select").value == 5){
                boss.push(new Boss5(32 * 10, 100, 9000));
            }else if(document.getElementById("stage_select").value == 6){
                boss.push(new Boss6(32 * 10, 100, 10000));
            }
        }
    }
}

let stage;

if(document.getElementById("stage_select").value == 1){
    stage = new Stage(mapField1);
}else if(document.getElementById("stage_select").value == 2){
    stage = new Stage(mapField2);
}else if(document.getElementById("stage_select").value == 3){
    stage = new Stage(mapField3);
}else if(document.getElementById("stage_select").value == 4){
    stage = new Stage(mapField4);
}else if(document.getElementById("stage_select").value == 5){
    stage = new Stage(mapField5);
}else if(document.getElementById("stage_select").value == 6){
    stage = new Stage(mapField6);
}

console.log(document.getElementById("stage_select").value);