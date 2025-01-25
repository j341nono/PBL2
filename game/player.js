//自機クラス
class Player{
    constructor(){
        this.x = (FIELD_W/2)<<8;
        this.y = (FIELD_H/2)<<8;
        this.s = 20;
        this.r = 8;
        this.hp = document.getElementById("HP").value;//体力
        this.maxHp = this.hp;
        this.attack = document.getElementById("attack").value;//攻撃力
        this.speed = 1024;//移動スピード
        this.reload = 0;
        this.pause = 0;
        this.anime = 0;//キャラ画像
        this.hitCool = 0;
        this.image = hero_straight;
    }

    update() {
        //移動しない時は前を向く
        this.image = hero_straight;

        if (this.hitCool != 0) {
            this.hitCool++;
            if (this.hitCool >= 60) this.hitCool = 0;
        }


        if(key[87]){
            this.hp+= 25;
        }else if(key[69]){
            this.hp+= 50;
        }else if(key[82]){
            this.hp+= 75;
        }

        if(this.hp > this.maxHp){
            this.hp = this.maxHp;
        }

        //主人公のショット
        if(key[32] && this.reload == 0){
            bullet.push(new Bullet(this.x,this.y, 0, -3500, playerShot));
            if( document.getElementById("behind").value == 1 ) bullet.push(new Bullet(this.x,this.y, 0,  3500, playerShot2));
            if( document.getElementById("diagonal").value == 1 ) bullet.push(new Bullet(this.x,this.y, -1000, -2000, playerShot));
            if( document.getElementById("diagonal").value == 1 ) bullet.push(new Bullet(this.x,this.y,  1000, -2000, playerShot));
            this.reload++;
        }

        //ショットの発射間隔を調整
        if(this.reload >= 2) this.reload = 0;
        if(this.reload != 0) this.reload++;

        if(key[80] && this.pause == 0){
            this.pause = 1;
            key[80] = false;
        }

        //主人公の移動
        if(key[37] && this.x > this.speed) this.x -= this.speed, this.image = hero_left;
        if(key[38] && this.y > this.speed) this.y -= this.speed;
        if(key[39] && this.x < (FIELD_W<<8) - this.speed) this.x += this.speed, this.image = hero_right;
        if(key[40] && this.y < (FIELD_H<<8) - this.speed) this.y += this.speed;
    }

    draw() {
        if (this.hitCool % 2 == 0) {
            drawSprite(this.anime, this.image, this.x, this.y, this.s);
        }
    }
}

let player = new Player();
