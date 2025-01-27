//キャンバス
let can = document.getElementById("can");
let con = can.getContext("2d");
can.width = CANVAS_W;
can.height = CANVAS_H;

//フィールド
let vcan = document.createElement("canvas");
let vcon = vcan.getContext("2d");
vcan.width = FIELD_W;
vcan.height = FIELD_H;

//ステージ読み込み
let cnt = 0;
let stageCnt = 0;

let score = 0;
let bossKill = 0;

let switch_on = 0;

let item1 = document.getElementById("item1").value;
let item2 = document.getElementById("item2").value;
let item3 = document.getElementById("item3").value;
let stage_num = document.getElementById("stage_select").value;

//ゲーム開始
window.onload = function(){
    title();
}

function gameInit(){
    document.getElementById("title").innerHTML = "<input type=hidden value='一時停止' onClick='gameInit()'>";
    const audio = new Audio('Swords.mp3');
    audio.loop = true;
    audio.play();
    setInterval(gameLoop, GAME_SPEED);
}

function gameLoop(){
    //if(player.pause != 0 && key[80]) player.pause = 0, key[80] = false;

    //if(player.pause != 0) return;

    view.update();
    for (let i=0; i<monster.length; i++){
        monster[i].update();
        if( monster[i].x >> 8 < - 50 || monster[i].x >> 8 > FIELD_W + 50 || monster[i].y >> 8 < -100 || monster[i].y >> 8 > FIELD_H + 50 ) monster.splice(i,1), i=0;;
    }
    for (let i=0; i<boss.length; i++){
        boss[i].update();
        boss[i].muteki = 0;
    }
    for (let i=0; i<bullet.length; i++){
        bullet[i].update();
    }
    for (let i=0; i<mons_bullet.length; i++){
        mons_bullet[i].update();
        if( mons_bullet[i].x >> 8 < - 200 || mons_bullet[i].x >> 8 > FIELD_W + 200 || mons_bullet[i].y >> 8 < - 200 || mons_bullet[i].y >> 8 > FIELD_H + 200 ) mons_bullet.splice(i,1);
        
        if(mons_bullet[i].time2 != 0){
            mons_bullet.splice(i, 1);
        } 
    }
    for (let i=0; i<explosion.length; i++){
        explosion[i].update();
        if(explosion[i].time >= 10){
            explosion.splice(i, 1);
        }
    }
    if(player.hp > 0){
        player.update();
    }

    for (let i=0; i<monster.length; i++){
        for (let j=0; j<bullet.length; j++){
            if (checkHit(monster[i].x, monster[i].y, monster[i].r, bullet[j].x, bullet[j].y, bullet[j].r)) {
                monster[i].hp -= player.attack;
                bullet.splice(j, 1);
                j = 0;
                if(monster[i].hp <= 0){
                    if(stage.bossMode == 0){
                        score += monster[i].score;
                    }
                    monster[i].death();
                    monster.splice(i, 1);
                    i=0;
                    //console.log(score);
                }
            }
        }

        if(monster[i].time2 >= 5){
            monster.splice(i, 1);
            i=0;
        } 
    }
    
    for (let i=0; i<boss.length; i++){
        for (let j=0; j<bullet.length; j++){
            if (checkHit(boss[i].x, boss[i].y, boss[i].r, bullet[j].x, bullet[j].y, bullet[j].r) && boss[i].muteki == 0) {
                boss[i].hp -= player.attack;
                bullet.splice(j, 1);
                j = 0;
                boss[i].muteki = 1;
                if(boss[i].hp <= 0){
                    score += boss[i].score;
                    boss[i].death();
                    boss.splice(i, 1);
                    i=0;
                    //console.log(score);
                    bossKill = 1;
                }
            }
        }
    }

    vcon.fillStyle = "black";
    vcon.fillRect(0, 0, FIELD_W, FIELD_H);

    view.draw();
    for (let i=0; i<monster.length; i++){
        monster[i].draw();
    }
    for (let i=0; i<boss.length; i++){
        boss[i].draw();
    }
    for (let i=0; i<bullet.length; i++){
        bullet[i].draw();
    }
    for (let i=0; i<mons_bullet.length; i++){
        mons_bullet[i].draw();
    }
    for (let i=0; i<explosion.length; i++){
        explosion[i].draw();
    }
    player.draw();

    if( player.hp > 0){
        let sz = (SCREEN_W) * player.hp / player.maxHp;
        let sz2 = (SCREEN_W);

        vcon.fillStyle = "rgba(0,0,255,255)";
        vcon.fillRect(0, SCREEN_H - 10, sz, 100);
        vcon.strokeStyle = "rgba(0,255,255,255)";
        vcon.strokeRect(0, SCREEN_H - 10, sz2, 100);
    }

    if( boss.length != 0 ){
        let sz = (SCREEN_W) * boss[0].hp / boss[0].maxHp;
        let sz2 = (SCREEN_W);

        vcon.fillStyle = "rgba(0,0,255,255)";
        vcon.fillRect(0, 0, sz, 10);
        vcon.strokeStyle = "rgba(0,255,255,255)";
        vcon.strokeRect(0, 0, sz2, 10);
    }

    if(cnt == 20 && stageCnt < STAGE_LEN && stage.bossMode == 0){
        stageCnt++;
        //stageCnt += 30;
        stage.readMap(stageCnt);
        cnt = 0;
    }

    //document.getElementById("title").innerHTML = "<input type=button value='' onClick='gameInit()'>";
    console.log(stageCnt);

    vcon.fillStyle = "white";

    vcon.font = "15px 'serif'";

    s = "HP       : " + player.hp;
    x = 5;
    y = 30;
    vcon.fillText(s, x, y);

    s = "SCORE : " + score;
    x = 5;
    y = 50;
    vcon.fillText(s, x, y);

    if(player.hp <= 0 && bossKill == 0){
        s = "ゲームオーバー";
        x = 100;
        y = 160;
        vcon.fillText(s, x, y);
        if (switch_on == 0) document.getElementById("title2").innerHTML = "<input type=button value='ゲーム終了' onClick='gameFinish(0)'>";
        console.log(switch_on);
        switch_on = 1;
    }
    
    if(bossKill == 1){
        s = "ゲームクリア!!";
        x = 100;
        y = 160;
        vcon.fillText(s, x, y);
        if (switch_on == 0) document.getElementById("title2").innerHTML = "<input type=button value='ゲーム終了' onClick='gameFinish(1)'>";
        console.log(switch_on);
        switch_on = 1;
    }

    con.drawImage(vcan, 0, 0, CANVAS_W, CANVAS_H, 0, 0, CANVAS_W, CANVAS_H);

    cnt++;
}

function gameFinish(boolean){
    console.log("AAA");
    sendGameData(score,item1,item2,item3,stage_num,boolean);
}
