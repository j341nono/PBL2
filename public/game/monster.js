//敵クラス
class Monster {
    constructor(x, score) {
        this.x = (x / 2) << 8;
        this.y = (FIELD_H / 2 - 180) << 8;
        this.s = 20;
        this.r = 8;
        this.hp = 3;
        this.speed = 512;
        this.shot_speed = 0;
        this.vs = 0;
        this.vx = 0;
        this.vy = 0;
        this.degree = 0;
        this.score = score;
        this.anime = 2;
        this.time = 0;
        this.time2 = 0;
        this.image = slime1;
    }

    update() {
        this.time++;
    }

    draw() {

    }

    death() {
        explosion.push(new Explosion(this.x, this.y,     0,  1024) );
        explosion.push(new Explosion(this.x, this.y,     0, -1024) );
        explosion.push(new Explosion(this.x, this.y,  1024,     0) );
        explosion.push(new Explosion(this.x, this.y, -1024,     0) );
        explosion.push(new Explosion(this.x, this.y,   768,   768) );
        explosion.push(new Explosion(this.x, this.y,   768,  -768) );
        explosion.push(new Explosion(this.x, this.y,  -768,   768) );
        explosion.push(new Explosion(this.x, this.y,  -768,  -768) );
    }
}

//スライムその1
class MonsterA extends Monster{
    constructor(x,score){
        super(x, score);
        this.hp = 50;
    }
    
    update() {
        super.update();

        this.y += this.speed;

        if (checkHit(this.x, this.y, this.r, player.x, player.y, player.r) && player.hitCool == 0) {
            player.hitCool = 1;
            player.hp -= 25;
        }

        if(this.time == 30){
            this.shot_speed = Math.sqrt( (player.x - this.x)*(player.x - this.x) + (player.y - this.y)*(player.y - this.y)  )
            mons_bullet.push(new MonsBullet(this.x, this.y, (player.x - this.x) / this.shot_speed * 768, (player.y - this.y) / this.shot_speed * 768) );
        }
    }

    draw(){
        drawSprite(this.anime, this.image, this.x, this.y, this.s);
    }

    death() {
        super.death();
    }
}

//スライムその2
class MonsterB extends Monster {
    constructor(x, score) {
        super(x, score);
        this.hp = 100;
        this.image = slime2;
    }

    update() {
        super.update();

        this.y += this.speed;

        if (checkHit(this.x, this.y, this.r, player.x, player.y, player.r) && player.hitCool == 0) {
            player.hitCool = 1;
            player.hp -= 25;
        }

        if(this.time == 50){
            this.degree = Math.atan2(player.x - this.x,player.y - this.y) * 180 / Math.PI;
            mons_bullet.push(new MonsBullet(this.x, this.y,  768 * Math.sin((this.degree) * Math.PI / 180), 768 * Math.cos((this.degree) * Math.PI / 180)) );
            mons_bullet.push(new MonsBullet(this.x, this.y,  768 * Math.sin((this.degree + 15) * Math.PI / 180), 768 * Math.cos((this.degree + 15) * Math.PI / 180)) );
            mons_bullet.push(new MonsBullet(this.x, this.y,  768 * Math.sin((this.degree - 15) * Math.PI / 180), 768 * Math.cos((this.degree - 15) * Math.PI / 180)) );
        }
    }

    draw() {
        drawSprite(this.anime, this.image, this.x, this.y, this.s);
    }

    death() {
        super.death();
    }
}

//スライムその3
class MonsterC extends Monster {
    constructor(x, score) {
        super(x, score);
        this.hp = 200;
        this.image = slime3;
    }

    update() {
        super.update();

        this.y += this.speed;

        if (checkHit(this.x, this.y, this.r, player.x, player.y, player.r) && player.hitCool == 0) {
            player.hitCool = 1;
            player.hp -= 25;
        }
    }

    draw() {
        drawSprite(this.anime, this.image, this.x, this.y, this.s);
    }

    death() {
        mons_bullet.push(new MonsBullet(this.x, this.y,     0,  1024) );
        mons_bullet.push(new MonsBullet(this.x, this.y,     0, -1024) );
        mons_bullet.push(new MonsBullet(this.x, this.y,  1024,     0) );
        mons_bullet.push(new MonsBullet(this.x, this.y, -1024,     0) );
        mons_bullet.push(new MonsBullet(this.x, this.y,   768,   768) );
        mons_bullet.push(new MonsBullet(this.x, this.y,   768,  -768) );
        mons_bullet.push(new MonsBullet(this.x, this.y,  -768,   768) );
        mons_bullet.push(new MonsBullet(this.x, this.y,  -768,  -768) );
    }
}

//カニその1
class MonsterD extends Monster{
    constructor(x,score){
        super(x, score);
        if(x < 320){
            this.x = 0 << 8;
            this.y = x + 32 << 8;
            this.speed *= 1;
        }else{
            this.x = 320 << 8;
            this.y = (640 - x) << 8;
            this.speed *= -1;
        }
        this.s = 15;
        this.hp = 200;
        this.image = crab1;
    }
    
    update() {
        super.update();
        if(this.time <= 60){
            this.x += this.speed * 0.5;
        }else if(this.time == 120){
            this.shot_speed = Math.sqrt( (player.x - this.x)*(player.x - this.x) + (player.y - this.y)*(player.y - this.y)  )
            mons_bullet.push(new MonsBullet(this.x, this.y, (player.x - this.x) / this.shot_speed * 512, (player.y - this.y) / this.shot_speed * 512) );
        }else if(this.time >= 180){
            this.x -= this.speed * 0.5;
        }

        if (checkHit(this.x, this.y, this.r, player.x, player.y, player.r) && player.hitCool == 0) {
            player.hitCool = 1;
            player.hp -= 25;
        }
    }

    draw(){
        drawSprite(this.anime, this.image, this.x, this.y, this.s);
    }

    death() {
        super.death();
    }
}

//カニその2
class MonsterE extends Monster{
    constructor(x,score){
        super(x, score);
        if(x < 320){
            this.x = 0 << 8;
            this.y = x + 32 << 8;
            this.speed *= 1;
        }else{
            this.x = 320 << 8;
            this.y = (640 - x) << 8;
            this.speed *= -1;
        }
        this.hp = 700;
        this.s = 15;
        this.image = crab2;
    }
    
    update() {
        super.update();
        this.x += this.speed * 0.5;

        if (checkHit(this.x, this.y, this.r, player.x, player.y, player.r) && player.hitCool == 0) {
            player.hitCool = 1;
            player.hp -= 25;
        }
    }

    draw(){
        drawSprite(this.anime, this.image, this.x, this.y, this.s);
    }

    death() {
        super.death();
    }
}

//カニその3
class MonsterF extends Monster{
    constructor(x,score){
        super(x, score);
        if(x < 320){
            this.x = 0 << 8;
            this.y = x + 32 << 8;
        }else{
            this.x = 320 << 8;
            this.y = (640 - x) << 8;
        }
        this.hp = 300;
        this.s = 15;
        this.image = crab3;
    }
    
    update() {
        super.update();
        if(this.time <= 120 && this.time2 < 4){
            if( (player.x << 8) > this.x << 8){
                this.x += this.speed * 0.7;
            }else if( (player.x << 8) < this.x << 8){
                this.x -= this.speed * 0.7;
            }
        }else{
            if(this.time == 150){
                mons_bullet.push(new MonsBullet(this.x, this.y, 0, 1500) );
//                mons_bullet.push(new MonsBullet(this.x, this.y, 0, -1500) );
            }else if(this.time == 180){
                this.time = 0;
                this.time2++;
            }
            if(this.time2 >= 4){
                this.time = 0;
                this.x += this.speed * 0.7;
            }
        }

        if (checkHit(this.x, this.y, this.r, player.x, player.y, player.r) && player.hitCool == 0) {
            player.hitCool = 1;
            player.hp -= 25;
        }
    }

    draw(){
        drawSprite(this.anime, this.image, this.x, this.y, this.s);
    }

    death() {
        super.death();
    }
}

//妖精その1
class MonsterG extends Monster {
    constructor(x, score) {
        super(x, score);
        this.s = 15;
        this.hp = 150;
        this.image = fairy1;
    }

    update() {
        super.update();

        //if (this.time <= 30) {
        this.speed -= 4;
        this.y += this.speed;
        if (this.speed ==0) {
            this.degree = Math.atan2(player.x - this.x,player.y - this.y) * 180 / Math.PI;
            mons_bullet.push(new MonsBullet(this.x, this.y,  1024 * Math.sin((this.degree) * Math.PI / 180), 1024 * Math.cos((this.degree) * Math.PI / 180)) );
            mons_bullet.push(new MonsBullet(this.x, this.y,  1024 * Math.sin((this.degree + 15) * Math.PI / 180), 1024 * Math.cos((this.degree + 15) * Math.PI / 180)) );
            mons_bullet.push(new MonsBullet(this.x, this.y,  1024 * Math.sin((this.degree - 15) * Math.PI / 180), 1024 * Math.cos((this.degree - 15) * Math.PI / 180)) );
            //monster.push(new MonsterSnow((this.x * 2) >> 8, this.y >> 8, 0) );
            //monster.push(new MonsterSnow((this.x * 2) >> 8, this.y >> 8, 0) );
            //monster.push(new MonsterSnow((this.x * 2) >> 8, this.y >> 8, 0) );
        }
        //    this.s += 3;
        //}

        if (checkHit(this.x, this.y, this.r, player.x, player.y, player.r) && player.hitCool == 0) {
            player.hitCool = 1;
            player.hp -= 25;
        }
    }

    draw() {
        drawSprite(this.anime, this.image, this.x, this.y, this.s);
    }

    death() {
        super.death();
    }
}

//妖精その2
class MonsterH extends Monster {
    constructor(x, score) {
        super(x, score);
        this.s = 15;
        this.hp = 200;
        this.image = fairy2;
    }

    update() {
        super.update();

        //if (this.time <= 30) {
        this.speed -= 4;
        this.y += this.speed;
        if (this.speed ==0) {
            mons_bullet.push(new ChaseBullet(this.x, this.y, 0, 300) );
        }
        //    this.s += 3;
        //}

        if (checkHit(this.x, this.y, this.r, player.x, player.y, player.r) && player.hitCool == 0) {
            player.hitCool = 1;
            player.hp -= 25;
        }
    }

    draw() {
        drawSprite(this.anime, this.image, this.x, this.y, this.s);
    }

    death() {
        super.death();
    }
}

//妖精その3
class MonsterI extends Monster {
    constructor(x, score) {
        super(x, score);
        this.s = 15;
        this.hp = 200;
        this.image = fairy3;
    }

    update() {
        super.update();

        //if (this.time <= 30) {
        this.speed -= 4;
        this.y += this.speed;

        if (this.speed ==0) {
            mons_bullet.push(new DivisionBullet(this.x, this.y, 0, 300) );
        }
        //    this.s += 3;
        //}

        if (checkHit(this.x, this.y, this.r, player.x, player.y, player.r) && player.hitCool == 0) {
            player.hitCool = 1;
            player.hp -= 25;
        }
    }

    draw() {
        drawSprite(this.anime, this.image, this.x, this.y, this.s);
    }

    death() {
        super.death();
    }
}

//ツタンカーメンその1
class MonsterJ extends Monster {
    constructor(x, score) {
        super(x, score);
        this.y = (FIELD_H / 2 - 140) << 8;
        this.hp = 150;
        this.s = 103;
        this.image = tutankhamun1;
    }

    update() {
        super.update();

        if (this.time <= 30) {
            this.s -= 3;
        }else if (this.time >= 91) {
            this.s += 3;
        }

        if (this.time >= 60 && this.time <= 70 && this.time % 4 == 0) {
            this.shot_speed = Math.sqrt( (player.x - this.x)*(player.x - this.x) + (player.y - this.y)*(player.y - this.y)  )
            mons_bullet.push(new MonsBullet(this.x, this.y, (player.x - this.x) / this.shot_speed * 512, (player.y - this.y) / this.shot_speed * 512) );
        }

        if (this.time >= 120) {
            this.y += this.speed * 25;
            this.time = 0;
            this.time2 ++;
            this.x = (320 << 8) - this.x;
        }

        if (checkHit(this.x, this.y, this.r, player.x, player.y, player.r) && player.hitCool == 0) {
            player.hitCool = 1;
            player.hp -= 25;
        }
    }

    draw() {
        drawSprite(this.anime, this.image, this.x, this.y, this.s);
    }

    death() {
        super.death();
    }
}

//ツタンカーメンその2
class MonsterK extends Monster {
    constructor(x, score) {
        super(x, score);
        this.y = (FIELD_H / 2 - 140) << 8;
        this.hp = 150;
        this.s = 103;
        this.time2 = 0;
        this.image = tutankhamun2;
    }

    update() {
        super.update();

        if (this.time <= 30) {
            this.s -= 3;
        }else if (this.time >= 91) {
            this.s += 3;
        }

        if (this.time >= 60 && this.time <= 70 && this.time % 4 == 0) {
            this.shot_speed = Math.sqrt( (player.x - this.x)*(player.x - this.x) + (player.y - this.y)*(player.y - this.y)  )
            mons_bullet.push(new MonsBullet(this.x, this.y, (player.x - this.x) / this.shot_speed * 512, (player.y - this.y) / this.shot_speed * 512) );
        }

        if (this.time >= 120) {
            this.y = (320 << 8) - this.y;
            this.time = 0;
            this.time2++;
        }

        if (checkHit(this.x, this.y, this.r, player.x, player.y, player.r) && player.hitCool == 0) {
            player.hitCool = 1;
            player.hp -= 25;
        }
    }

    draw() {
        drawSprite(this.anime, this.image, this.x, this.y, this.s);
    }

    death() {
        super.death();
    }
}

//ツタンカーメンその3
class MonsterL extends Monster {
    constructor(x, score) {
        super(x, score);
        this.y = (FIELD_H / 2 - 140) << 8;
        this.hp = 200;
        this.s = 103;
        this.time2 = 0;
        this.image = tutankhamun3;
    }

    update() {
        super.update();

        if (this.time <= 30) {
            this.s -= 3;
        }else if (this.time >= 301) {
            this.s += 3;
        }

        if (this.time >= 60 && this.time <= 70 && this.time % 4 == 0) {
            this.shot_speed = Math.sqrt( (player.x - this.x)*(player.x - this.x) + (player.y - this.y)*(player.y - this.y)  )
            mons_bullet.push(new ReturnBullet(this.x, this.y, (player.x - this.x) / this.shot_speed * 512, (player.y - this.y) / this.shot_speed * 512) );
        }

        if (this.time >= 290 && this.time <= 300 && this.time % 4 == 0) {
            this.shot_speed = Math.sqrt( (player.x - this.x)*(player.x - this.x) + (player.y - this.y)*(player.y - this.y)  )
            mons_bullet.push(new ReturnBullet(this.x, this.y, (player.x - this.x) / this.shot_speed * 512, (player.y - this.y) / this.shot_speed * 512) );
        }

        if (this.time >= 330) {
            //this.y = (320 << 8) - this.y;
            //this.time = 0;
            this.time2 = 5;
        }

        if (checkHit(this.x, this.y, this.r, player.x, player.y, player.r) && player.hitCool == 0) {
            player.hitCool = 1;
            player.hp -= 25;
        }
    }

    draw() {
        drawSprite(this.anime, this.image, this.x, this.y, this.s);
    }

    death() {
        super.death();
    }
}

//スケルトンその1
class MonsterM extends Monster {
    constructor(x, score) {
        super(x, score);
        //this.y = (FIELD_H / 2 - 140) << 8;
        this.hp = 120;
        this.s = 12;
        this.speed = 600;
        this.image = skeleton1;
    }

    update() {
        super.update();

        this.y += this.speed;
        if(this.time <= 60){
            this.speed -= 10;
        }else if(this.time == 90){
            this.vs = Math.sqrt( (player.x - this.x)*(player.x - this.x) + (player.y - this.y)*(player.y - this.y)  );
            this.vx = (player.x - this.x);
            this.vy = (player.y - this.y);
        }else if(this.time >= 90){
            this.x += this.vx / this.vs * 512 * ((this.time - 90) / 10 + 1);
            this.y += this.vy / this.vs * 512 * ((this.time - 90) / 10 + 1);
        }

        if (checkHit(this.x, this.y, this.r, player.x, player.y, player.r) && player.hitCool == 0) {
            player.hitCool = 1;
            player.hp -= 25;
        }
    }

    draw() {
        drawSprite(this.anime, this.image, this.x, this.y, this.s);
    }

    death() {
        super.death();
    }
}

//スケルトンその2
class MonsterN extends Monster {
    constructor(x, score) {
        super(x, score);
        //this.y = (FIELD_H / 2 - 140) << 8;
        this.hp = 180;
        this.s = 12;
        this.speed = 600;
        this.image = skeleton2;
    }

    update() {
        super.update();

        this.y += this.speed;
        if(this.time <= 60){
            this.speed -= 10;
        }if(this.time == 90){
            this.degree = Math.atan2(player.x - this.x,player.y - this.y) * 180 / Math.PI;
            mons_bullet.push(new MonsBullet(this.x, this.y,  1024 * Math.sin((this.degree) * Math.PI / 180), 1024 * Math.cos((this.degree) * Math.PI / 180)) );
            mons_bullet.push(new MonsBullet(this.x, this.y,  1024 * Math.sin((this.degree + 15) * Math.PI / 180), 1024 * Math.cos((this.degree + 15) * Math.PI / 180)) );
            mons_bullet.push(new MonsBullet(this.x, this.y,  1024 * Math.sin((this.degree - 15) * Math.PI / 180), 1024 * Math.cos((this.degree - 15) * Math.PI / 180)) );
        }if(this.time == 150){
            this.degree = Math.atan2(player.x - this.x,player.y - this.y) * 180 / Math.PI;
            mons_bullet.push(new MonsBullet(this.x, this.y,  1024 * Math.sin((this.degree) * Math.PI / 180), 1024 * Math.cos((this.degree) * Math.PI / 180)) );
            mons_bullet.push(new MonsBullet(this.x, this.y,  1024 * Math.sin((this.degree + 15) * Math.PI / 180), 1024 * Math.cos((this.degree + 15) * Math.PI / 180)) );
            mons_bullet.push(new MonsBullet(this.x, this.y,  1024 * Math.sin((this.degree - 15) * Math.PI / 180), 1024 * Math.cos((this.degree - 15) * Math.PI / 180)) );
        }if(this.time == 210){
            this.degree = Math.atan2(player.x - this.x,player.y - this.y) * 180 / Math.PI;
            mons_bullet.push(new MonsBullet(this.x, this.y,  1024 * Math.sin((this.degree) * Math.PI / 180), 1024 * Math.cos((this.degree) * Math.PI / 180)) );
            mons_bullet.push(new MonsBullet(this.x, this.y,  1024 * Math.sin((this.degree + 15) * Math.PI / 180), 1024 * Math.cos((this.degree + 15) * Math.PI / 180)) );
            mons_bullet.push(new MonsBullet(this.x, this.y,  1024 * Math.sin((this.degree - 15) * Math.PI / 180), 1024 * Math.cos((this.degree - 15) * Math.PI / 180)) );
        }else if(this.time == 240){
            this.vs = Math.sqrt( (player.x - this.x)*(player.x - this.x) + (player.y - this.y)*(player.y - this.y)  );
            this.vx = (player.x - this.x);
            this.vy = (player.y - this.y);
        }else if(this.time >= 240){
            this.x += this.vx / this.vs * 768 * ((this.time - 240) / 10 + 1);
            this.y += this.vy / this.vs * 768 * ((this.time - 240) / 10 + 1);
        }

        if (checkHit(this.x, this.y, this.r, player.x, player.y, player.r) && player.hitCool == 0) {
            player.hitCool = 1;
            player.hp -= 25;
        }
    }

    draw() {
        drawSprite(this.anime, this.image, this.x, this.y, this.s);
    }

    death() {
        super.death();
    }
}

//スケルトンその3
class MonsterO extends Monster {
    constructor(x, score) {
        super(x, score);
        //this.y = (FIELD_H / 2 - 140) << 8;
        this.hp = 240;
        this.s = 12;
        this.speed = 600;
        this.image = skeleton3;
    }

    update() {
        super.update();

        this.y += this.speed;
        if(this.time <= 60){
            this.speed -= 10;
        }if(this.time == 90){
            if(rnd(0,1 == 1)){
                this.degree = -1 * rnd(60,80);
            }else{
                this.degree = rnd(60,80);
            }
            mons_bullet.push(new ReflectBullet(this.x, this.y,  1024 * Math.sin((this.degree) * Math.PI / 180), 1024 * Math.cos((this.degree) * Math.PI / 180)) );
        }else if(this.time == 180){
            this.vs = Math.sqrt( (player.x - this.x)*(player.x - this.x) + (player.y - this.y)*(player.y - this.y)  );
            this.vx = (player.x - this.x);
            this.vy = (player.y - this.y);
        }else if(this.time >= 180){
            this.x += this.vx / this.vs * 512 * ((this.time - 180) / 10 + 1);
            this.y += this.vy / this.vs * 512 * ((this.time - 180) / 10 + 1);
        }

        if (checkHit(this.x, this.y, this.r, player.x, player.y, player.r) && player.hitCool == 0) {
            player.hitCool = 1;
            player.hp -= 25;
        }
    }

    draw() {
        drawSprite(this.anime, this.image, this.x, this.y, this.s);
    }

    death() {
        super.death();
    }
}

//雪
class MonsterSnow extends Monster {
    constructor(x, y, score) {
        super(x, score);
        this.hp = 100;
        this.y = y << 8;
        this.vx = rnd(1,500) - rnd(1,500);
        this.image = snow;
    }

    update() {
        super.update();

        this.x += this.vx;
        this.y += this.speed * 0.2;

        if (checkHit(this.x, this.y, this.r, player.x, player.y, player.r) && player.hitCool == 0) {
            player.hitCool = 1;
            player.hp -= 25;
        }
    }

    draw() {
        drawSprite(this.anime, this.image, this.x, this.y, this.s);
    }

    death() {
    }
}

class Boss{
    constructor(x,score,hp){
        this.x = (x/2)<<8;
        this.y = (FIELD_H/2 - 180)<<8;
        this.s = 10;
        this.r = 25;
        this.hp = hp;
        this.maxHp = this.hp;
        this.speed = 1024;
        this.speedY = 1024;
        this.vSpeed = 0;
        this.shot_speed = 512;
        this.score = score;
        this.anime = 2;
        this.image = slimeBoss;
        this.time = 0;
        this.time2 = 0;
        this.degree = 0;
        this.bossTime = 0;
        this.flag = 0;
        this.attack = 0;
        this.muteki = 0;
    }

    update(){
        this.time++;        
        if(this.attack != 0){
            this.bossTime++;
        }
    }

    draw(){

    }

    death(){

    }
}

class Boss1 extends Boss{
    constructor(x,score,hp){
        super(x,score,hp);
    }

    update(){
        super.update();

        if(this.y < FIELD_H/4<<8){
            this.y += this.speed * 0.2;
            this.time = 0;
        }else{
            if(this.time <= 60){
                this.x += this.speed * 0.5;
            }else if(this.time > 60 && this.time <= 180 ){
                this.x -= this.speed * 0.5;
            }else if(this.time > 180 && this.time <= 240 ){
                this.x += this.speed * 0.5;
            }

            if(this.time <= 60){
                this.speed -= 10;
            }else if(this.time > 60 && this.time <= 120 ){
                this.speed += 10;
            }else if(this.time > 120 && this.time <= 180 ){
                this.speed -= 10;
            }else if(this.time > 180 && this.time <= 240 ){
                this.speed += 10;
            }

            if(this.time == 60 || this.time == 180){
                mons_bullet.push(new MonsBullet(this.x, this.y,     0,  1024) );
                mons_bullet.push(new MonsBullet(this.x, this.y,     0, -1024) );
                mons_bullet.push(new MonsBullet(this.x, this.y,  1024,     0) );
                mons_bullet.push(new MonsBullet(this.x, this.y, -1024,     0) );
                mons_bullet.push(new MonsBullet(this.x, this.y,   768,   768) );
                mons_bullet.push(new MonsBullet(this.x, this.y,   768,  -768) );
                mons_bullet.push(new MonsBullet(this.x, this.y,  -768,   768) );
                mons_bullet.push(new MonsBullet(this.x, this.y,  -768,  -768) );
            }

            if(this.time % 80 == 0 ){
                this.shot_speed = Math.sqrt( (player.x - this.x)*(player.x - this.x) + (player.y - this.y)*(player.y - this.y)  )
                mons_bullet.push(new MonsBullet(this.x, this.y, (player.x - this.x) / this.shot_speed * 512, (player.y - this.y) / this.shot_speed * 512) );
            }
        }
        
        if(this.time == 240 ){
            this.time = 0;
            monster.push(new MonsterD(32 *  0, 100));//カニその1
            monster.push(new MonsterD(32 * 19, 100));//カニその1
            this.time2++;
        }

        if(this.y < FIELD_H/4<<8){
            this.y += this.speed;
            this.time = 0;
        }

        if (checkHit(this.x, this.y, this.r, player.x, player.y, player.r) && player.hitCool == 0) {
            player.hitCool = 1;
            player.hp -= 25;
        }
    }

    draw(){
        drawSprite(this.anime, this.image, this.x, this.y, this.s);
    }

    death() {

    }
}

class Boss2 extends Boss{
    constructor(x,score,hp){
        super(x,score,hp);
        this.x = 0;
        this.y = FIELD_H/4 << 8;
        this.shot_speed2 = 0.3;
        this.image = crabBoss;
    }

    update(){
        super.update();

        if(this.x < FIELD_W/2<<8 && this.flag == 0){
            this.x += this.speed * 0.3;
            this.time = 0;
        }else{
            this.flag = 1;
            this.attack = 1;
        }

        if(this.attack==1){
            if(this.bossTime <= 180){
                this.x += this.speed * 0.3;
            }else if(this.bossTime > 180 && this.bossTime < 540){
                this.x -= this.speed * 0.3;
            }else if(this.bossTime >= 540 && this.x <= FIELD_W/2<<8){
                this.x += this.speed * 0.3;
            }if(this.bossTime >= 780){
                this.time = 0;
                this.bossTime = 0;    
                this.attack == 1;
            }

            if(this.bossTime == 240 ||this.bossTime == 320 || this.bossTime == 400 || this.bossTime == 480){ 
                mons_bullet.push(new ReturnBullet(this.x, this.y,     0 * this.shot_speed2,  1024 * this.shot_speed2) );
                mons_bullet.push(new ReturnBullet(this.x, this.y,     0 * this.shot_speed2, -1024 * this.shot_speed2) );
                mons_bullet.push(new ReturnBullet(this.x, this.y,  1024 * this.shot_speed2,     0 * this.shot_speed2) );
                mons_bullet.push(new ReturnBullet(this.x, this.y, -1024 * this.shot_speed2,     0 * this.shot_speed2) );
                mons_bullet.push(new ReturnBullet(this.x, this.y,   768 * this.shot_speed2,   768 * this.shot_speed2) );
                mons_bullet.push(new ReturnBullet(this.x, this.y,   768 * this.shot_speed2,  -768 * this.shot_speed2) );
                mons_bullet.push(new ReturnBullet(this.x, this.y,  -768 * this.shot_speed2,   768 * this.shot_speed2) );
                mons_bullet.push(new ReturnBullet(this.x, this.y,  -768 * this.shot_speed2,  -768 * this.shot_speed2) );
            }
            
            if(this.bossTime == 180){
                this.y = FIELD_H/4 * 3 << 8;
            }else if(this.bossTime == 540){
                this.y = FIELD_H/4 << 8; 
            }
        }

        if(this.time == 60 || this.time == 120 || this.time == 600 || this.time == 660){
            mons_bullet.push(new ChaseBullet(this.x, this.y,     0,  256) );
        }
            
        if (checkHit(this.x, this.y, this.r, player.x, player.y, player.r) && player.hitCool == 0) {
            player.hitCool = 1;
            player.hp -= 25;
        }
    }

    draw(){
        drawSprite(this.anime, this.image, this.x, this.y, this.s);
    }

    death() {

    }
}

class Boss3 extends Boss{
    constructor(x,score,hp){
        super(x,score,hp);
        this.s = 8;
        this.speed = 603;
        this.shot_speed2 = 0.3;
        this.image = fairyBoss;
    }

    update(){
        super.update();

        if(this.y < FIELD_H/4<<8){
            this.y += this.speed * 0.2;
            this.time = 0;
        }else if(this.flag == 0){
            this.flag = 1;
            this.time = 0;
        }

        if(this.flag == 1){
            if(this.time < 200){
                this.speed -= 6;
            }else{
                this.speed += 6;
                if(this.time == 398){
                    this.time = 0;
                }
            }

            console.log(this.speed);
            this.x += this.speed;

            if(this.time % 15 == 0){
                if(rnd(0,1 == 1)){
                    this.degree = -1 * rnd(0,80);
                }else{
                    this.degree = rnd(0,80);
                }
                if(this.attack >= rnd(1,100)){
                    mons_bullet.push(new ReflectBullet(this.x - 20000, this.y,  1024 * Math.sin((this.degree) * Math.PI / 180), 1024 * Math.cos((this.degree) * Math.PI / 180)) );
                }else{
                    mons_bullet.push(new MonsBullet(this.x - 20000, this.y,  1024 * Math.sin((this.degree) * Math.PI / 180), 1024 * Math.cos((this.degree) * Math.PI / 180)) );
                }
                if(rnd(0,1 == 1)){
                    this.degree = -1 * rnd(0,80);
                }else{
                    this.degree = rnd(0,80);
                }
                if(this.attack >= rnd(1,100)){
                    mons_bullet.push(new ReflectBullet(this.x + 20000, this.y,  1024 * Math.sin((this.degree) * Math.PI / 180), 1024 * Math.cos((this.degree) * Math.PI / 180)) );
                }else{
                    mons_bullet.push(new MonsBullet(this.x + 20000, this.y,  1024 * Math.sin((this.degree) * Math.PI / 180), 1024 * Math.cos((this.degree) * Math.PI / 180)) );
                }

                this.attack = (7200 - this.hp)/ this.maxHp * 30;
                //monster.push(new MonsterSnow((this.x * 2) >> 8, this.y >> 8, 0) );
                //monster.push(new MonsterSnow((this.x * 2) >> 8, this.y >> 8, 0) );
                //monster.push(new MonsterSnow((this.x * 2) >> 8, this.y >> 8, 0) );
                //monster.push(new MonsterSnow((this.x * 2) >> 8, this.y >> 8, 0) );
                //monster.push(new MonsterSnow((this.x * 2) >> 8, this.y >> 8, 0) );
            }
        }
    }

    draw(){
        drawSprite(this.anime, this.image, this.x, this.y, this.s);
    }

    death() {

    }
}


class Boss4 extends Boss{
    constructor(x,score,hp){
        super(x,score,hp);
        this.y = (FIELD_H / 2 - 100) << 8;
        this.s = 96;
        this.shot_speed2 = 0.3;
        this.image = tutankhamunBoss;
    }

    update(){
        super.update();

        if (this.time <= 30 && this.flag == 0 ){
            this.s -= 3;
        }else if(this.flag == 0){
            this.flag = 1;
            mons_bullet.push(new MonsBullet(this.x, this.y,     0,  1024) );
            mons_bullet.push(new MonsBullet(this.x, this.y,     0, -1024) );
            mons_bullet.push(new MonsBullet(this.x, this.y,  1024,     0) );
            mons_bullet.push(new MonsBullet(this.x, this.y, -1024,     0) );
            mons_bullet.push(new MonsBullet(this.x, this.y,   768,   768) );
            mons_bullet.push(new MonsBullet(this.x, this.y,   768,  -768) );
            mons_bullet.push(new MonsBullet(this.x, this.y,  -768,   768) );
            mons_bullet.push(new MonsBullet(this.x, this.y,  -768,  -768) );
            this.time = 0;
        }

        if(this.flag == 1 || this.flag == 3 && this.attack ==1){
            if(this.time <= 30){
                this.s += 4;
            }else if(this.time == 31){
                this.x = rnd(100,220) << 8;
                this.y = rnd(50,120) << 8;
            }else if(this.time <= 61){
                this.degree = Math.atan2(player.x - this.x,player.y - this.y) * 180 / Math.PI;
                this.s -= 4;
            }else if(this.time >= 62 && this.time <= 80 && this.time % 4 == 0){
                shot8(this.x, this.y, 1024, this.degree);
                if(this.flag == 3){
                    shot8(this.x, this.y, 1024, this.degree+22.5);
                }
                this.s = 9;
            }else if(this.time == 100){
                this.time = 0;
                if(this.hp > 2500 && this.hp <= 5500){
                    this.flag = 2;
                }
                if(this.flag == 3){
                    this.attack = rnd(1,3);
                }
            }
        }

        if(this.flag == 2 || this.flag == 3 && this.attack ==2){
            if(this.time <= 30){
                this.s += 4;
            }else if(this.time == 31){
                this.x = rnd(100,220) << 8;
                this.y = rnd(50,120) << 8;
            }else if(this.time <= 61){
                this.degree = Math.atan2(player.x - this.x,player.y - this.y) * 180 / Math.PI;
                this.s -= 4;
            }else if(this.time >= 62 && this.time <= 80 && this.time % 4 == 0){
                returnShot8(this.x, this.y, 512, this.degree);
                this.s = 9;
            }else if(this.time == 100){
                this.time = 0;
                if(this.hp <= 3500){
                    this.flag = 3;
                }
                if(this.flag == 3){
                    this.attack = rnd(1,3);
                }
            }
        }

        if(this.flag == 3 && this.attack ==3){
            if(this.time <= 30){
                this.s += 4;
            }else if(this.time == 31){
                this.x = rnd(100,220) << 8;
                this.y = rnd(50,120) << 8;
            }else if(this.time <= 61){
                this.degree = Math.atan2(player.x - this.x,player.y - this.y) * 180 / Math.PI;
                this.s -= 4;
            }else if(this.time >= 62 && this.time <= 170 && this.time % 11 == 0){
                returnShot8(this.x, this.y, 350, this.degree + this.time);
                this.s = 9;
            }else if(this.time == 175){
                this.time = 0;
                this.attack = rnd(1,3);
            }
        }
        //if(this.x < FIELD_W/2<<8 && this.flag == 0){
        //    this.x += this.speed * 0.3;
        //    this.time = 0;
        //}else{
        //    this.flag = 1;
        //}
            
        if (checkHit(this.x, this.y, this.r, player.x, player.y, player.r) && player.hitCool == 0) {
            player.hitCool = 1;
            player.hp -= 25;
        }
    }

    draw(){
        drawSprite(this.anime, this.image, this.x, this.y, this.s);
    }

    death() {

    }
}

class Boss5 extends Boss{
    constructor(x,score,hp){
        super(x,score,hp);
        //this.y = (FIELD_H / 2 - 100) << 8;
        //this.s = 96;
        this.shot_speed2 = 0.3;
        this.image = skeletonBoss;
    }

    update(){
        super.update();
    
        this.vs = Math.sqrt( (player.x - this.x)*(player.x - this.x) + (player.y - this.y)*(player.y - this.y)  );
        this.vx = (player.x - this.x);
        this.vy = (player.y - this.y);
        this.x += this.vx / this.vs * 256;
        this.y += this.vy / this.vs * 256;
        
        if(this.time % 120 == 0){
            this.degree = Math.atan2(player.x - this.x,player.y - this.y) * 180 / Math.PI;
            reflectShot8(this.x, this.y, 1024, this.degree);
        }

        if (checkHit(this.x, this.y, this.r, player.x, player.y, player.r) && player.hitCool == 0) {
            player.hitCool = 1;
            player.hp -= 25;
        }
    }

    draw(){
        drawSprite(this.anime, this.image, this.x, this.y, this.s);
    }

    death() {

    }
}

class Boss6 extends Boss{
    constructor(x,score,hp){
        super(x,score,hp);
        //this.y = (FIELD_H / 2 - 100) << 8;
        this.speed = 606;
        this.speedY = 300;
        this.s = 7;
        this.shot_speed2 = 0.3;
        this.image = lastBoss;
    }

    update(){
        super.update();
        this.time2++;

        if(this.y < FIELD_H/4<<8 && this.flag == 0){
            this.y += this.speed * 0.3;
            this.time = 0;
        }else if(this.flag == 0){
            this.flag = 1;
            this.time = 0;
        }

        if(this.flag == 1){
            if(this.time > 0 && this.time < 101 || this.time >= 201 && this.time < 301){
                this.speedY -= 6;
            }else if(this.time != 0){
                this.speedY += 6;
            }

            if(this.time < 201){
                this.speed -= 6;
            }else{
                this.speed += 6;
                if(this.time == 400){
                    this.time = 0;
                }
            }

            if( this.hp >= 7000 ){
                if(this.time % 120 == 0){
                    this.degree = Math.atan2(player.x - this.x,player.y - this.y) * 180 / Math.PI;
                    shot8(this.x, this.y, 1024, this.degree);
                }else if(this.time % 120 == 40){
                    this.degree = Math.atan2(player.x - this.x,player.y - this.y) * 180 / Math.PI;
                    returnShot8(this.x, this.y, 256, this.degree);
                }else if(this.time % 120 == 80){
                    this.degree = Math.atan2(player.x - this.x,player.y - this.y) * 180 / Math.PI;
                    reflectShot8(this.x, this.y, 512, this.degree);
                }
            }else if(this.hp >= 4000){
                if(this.time % 4 == 0 && this.time % 80 <= 40){
                    if(this.time % 80 == 0){
                        this.degree = Math.atan2(player.x - this.x,player.y - this.y) * 180 / Math.PI;
                        returnShot8(this.x, this.y, 256, this.degree);
                    }
                    mons_bullet.push(new MonsBullet(this.x, this.y,  350 * Math.sin((this.degree) * Math.PI / 180), 350 * Math.cos((this.degree) * Math.PI / 180)) );
                }if(this.time % 80 == 60){
                    this.degree = Math.atan2(player.x - this.x,player.y - this.y) * 180 / Math.PI;
                    mons_bullet.push(new DivisionBullet(this.x, this.y,  350 * Math.sin((this.degree) * Math.PI / 180), 350 * Math.cos((this.degree) * Math.PI / 180)) );
                }
            }else{
                if(this.time % 120 == 0){
                    this.degree = Math.atan2(player.x - this.x,player.y - this.y) * 180 / Math.PI;
                    shot8(this.x + 17000, this.y, 1024, this.degree);
                    returnShot8(this.x - 17000, this.y, 256, this.degree);
                }else if(this.time % 120 == 60){
                    this.degree = Math.atan2(player.x - this.x,player.y - this.y) * 180 / Math.PI;
                    returnShot8(this.x + 17000, this.y, 256, this.degree);
                    shot8(this.x - 17000, this.y, 1024, this.degree);
                }
                if(this.time % 200 == 0){
                    this.degree = Math.atan2(player.x - this.x,player.y - this.y) * 180 / Math.PI;
                    divisionShot8(this.x, this.y, 256, this.degree);
                    mons_bullet.push(new ChaseBullet(this.x, this.y,  350 * Math.sin((this.degree) * Math.PI / 180), 350 * Math.cos((this.degree) * Math.PI / 180)) );
                }
            }

            this.x += this.speed;
            this.y += this.speedY;
            console.log(this.speedY);
        }

        if (checkHit(this.x, this.y, this.r, player.x, player.y, player.r) && player.hitCool == 0) {
            player.hitCool = 1;
            player.hp -= 25;
        }
    }

    draw(){
        drawSprite(this.anime, this.image, this.x, this.y, this.s);
    }

    death() {

    }
}



//let monster = new Monster();
let monster = [];
let boss = [];
