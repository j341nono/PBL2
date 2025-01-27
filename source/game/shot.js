//弾クラス
class Bullet{
    constructor(x,y,vx,vy,image){
        this.sn = 0;
        this.x = x;
        this.y = y;
        this.s = 40;
        this.r = 4;
        this.vx = vx;
        this.vy = vy;
        this.image = image;
    }

    update(){
        this.x += this.vx;
        this.y += this.vy;
    }

    draw(){
        drawSprite(this.sn, this.image, this.x,this.y, this.s);
    }
}

//敵の弾クラス
class MonsBullet{
    constructor(x,y,vx,vy){
        this.sn = 0;
        this.x = x;
        this.y = y;
        this.s = 40;
        this.r = 4;
        this.vx = vx;
        this.vy = vy;
        this.time = 0;
        this.time2 = 0;
        this.time3 = 0;
        this.image = shot;
    }

    update(){
        this.time++;
        this.x += this.vx;
        this.y += this.vy;

        if (checkHit(this.x, this.y, this.r, player.x, player.y, player.r) && player.hitCool == 0) {
            player.hitCool = 1;
            player.hp -= 25;
        }
    }

    draw(){
        drawSprite(this.sn, this.image, this.x,this.y, this.s);
    }
}

class ChaseBullet extends MonsBullet{
    constructor(x,y,vx,vy){
        super(x,y,vx,vy);
        this.shot_speed = 0;
    }

    update(){
        this.time++;
        this.x += this.vx;
        this.y += this.vy;

        //this.shot_speed = Math.sqrt( (player.x - this.x)*(player.x - this.x) + (player.y - this.y)*(player.y - this.y)  )
        //this.vx = (player.x - this.x) / this.shot_speed * 256;
        this.vx = (player.x - this.x) / 32;

        if (checkHit(this.x, this.y, this.r, player.x, player.y, player.r) && player.hitCool == 0) {
            player.hitCool = 1;
            player.hp -= 25;
        }
    }

    draw(){
        drawSprite(this.sn, this.image, this.x,this.y, this.s);
    }
}

class ReturnBullet extends MonsBullet{
    constructor(x,y,vx,vy){
        super(x,y,vx,vy);
        this.shot_speed = 0;
        this.vx2 = vx;
        this.vy2 = vy;
        this.image = returnShot;
    }

    update(){
       this.time++;
       this.x += this.vx;
       this.y += this.vy;

       if (this.time <= 70) {
            this.vx += this.vx2 * 0.01;
            this.vy += this.vy2 * 0.01;
       }else{
            this.vx -= this.vx2 * 0.03;
            this.vy -= this.vy2 * 0.03;
       }

        if (checkHit(this.x, this.y, this.r, player.x, player.y, player.r) && player.hitCool == 0) {
            player.hitCool = 1;
            player.hp -= 25;
        }
    }

    draw(){
        drawSprite(this.sn, this.image, this.x,this.y, this.s);
    }
}

class DivisionBullet extends MonsBullet{
    constructor(x,y,vx,vy){
        super(x,y,vx,vy);
        this.shot_speed = 0;
        this.vx2 = vx;    
        this.vy2 = vy;
        this.time2 = 0;
        this.image = divisionShot;
    }

    update(){
        this.time++;
        this.x += this.vx;
        this.y += this.vy;

        if(this.time == 60){
            mons_bullet.push(new MonsBullet(this.x, this.y,     0,  1024) );
            mons_bullet.push(new MonsBullet(this.x, this.y,     0, -1024) );
            mons_bullet.push(new MonsBullet(this.x, this.y,  1024,     0) );
            mons_bullet.push(new MonsBullet(this.x, this.y, -1024,     0) );
            mons_bullet.push(new MonsBullet(this.x, this.y,   768,   768) );
            mons_bullet.push(new MonsBullet(this.x, this.y,   768,  -768) );
            mons_bullet.push(new MonsBullet(this.x, this.y,  -768,   768) );
            mons_bullet.push(new MonsBullet(this.x, this.y,  -768,  -768) );
            this.time2 = 1;
        }

        if (checkHit(this.x, this.y, this.r, player.x, player.y, player.r) && player.hitCool == 0) {
            player.hitCool = 1;
            player.hp -= 25;
        }
    }

    draw(){
        drawSprite(this.sn, this.image, this.x,this.y, this.s);
    }
}

class ReflectBullet extends MonsBullet{
    constructor(x,y,vx,vy){
        super(x,y,vx,vy);
        this.shot_speed = 0;
        this.vx2 = vx;    
        this.vy2 = vy;
        this.time2 = 0;
        this.image = reflectShot;
    }

    update(){
        this.time++;
        this.x += this.vx;
        this.y += this.vy;

        if( (this.x < 0 || this.x >> 8 > FIELD_W) && this.time3 <= 15 ){
            this.vx *= -1;
            this.time3++;
        }


        if (checkHit(this.x, this.y, this.r, player.x, player.y, player.r) && player.hitCool == 0) {
            player.hitCool = 1;
            player.hp -= 25;
        }
    }

    draw(){
        drawSprite(this.sn, this.image, this.x,this.y, this.s);
    }
}

let bullet=[];
let mons_bullet=[];
