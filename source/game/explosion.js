//爆発クラス
class Explosion {
    constructor(x,y,vx,vy){
        this.sn = 1;
        this.x = x;
        this.y = y;
        this.s = 1;
        this.r = 4;
        this.vx = vx;
        this.vy = vy;
        this.image = explosionImage;
    }

    update() {
        this.time++;
        this.s += 0.2;

        this.x += this.vx;
        this.y += this.vy;
    }

    draw() {
        drawSprite(this.sn, this.image, this.x, this.y, this.s);
    }
}

let explosion = [];