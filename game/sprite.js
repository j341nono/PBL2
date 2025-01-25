class Sprite{
    constructor(x, y, w, h){
        this.x = x;
        this.y = y;
        this.w = w;
        this.h = h;
    }
}

let sprite=[
    new Sprite(0,0,600,600),
    new Sprite(0,0,16,16),   
    new Sprite(0,0,600,600),
    new Sprite(0,0,800,800),
];

let hero_straight = new Image();
let hero_left = new Image();
let hero_right = new Image();
let stage1view = new Image();
let stage2view = new Image();
let stage3view = new Image();
let stage4view = new Image();
let stage5view = new Image();
let stage6view = new Image();
let explosionImage = new Image();
let shot = new Image();
let returnShot = new Image();
let divisionShot = new Image();
let reflectShot = new Image();
let playerShot = new Image();
let playerShot2 = new Image();
let slime1 = new Image();
let slime2 = new Image();
let slime3 = new Image();
let slimeBoss = new Image();
let crab1 = new Image();
let crab2 = new Image();
let crab3 = new Image();
let crabBoss = new Image();
let fairy1 = new Image();
let fairy2 = new Image();
let fairy3 = new Image();
let fairyBoss = new Image();
let tutankhamun1 = new Image();
let tutankhamun2 = new Image();
let tutankhamun3 = new Image();
let tutankhamunBoss = new Image();
let skeleton1 = new Image();
let skeleton2 = new Image();
let skeleton3 = new Image();
let skeletonBoss = new Image();
let lastBoss = new Image();
//let snow = new Image();

hero_straight.src = "hero_straight.PNG";
hero_left.src = "hero_left.PNG";
hero_right.src = "hero_right.PNG";
stage1view.src = "stage1view.PNG";
stage2view.src = "stage2view.PNG";
stage3view.src = "stage3view.PNG";
stage4view.src = "stage4view.PNG";
stage5view.src = "stage5view.PNG";
stage6view.src = "stage6view.PNG";
explosionImage.src = "explosionImage.png";
shot.src = "shot.png";
returnShot.src = "returnShot.png";
divisionShot.src = "divisionShot.png";
reflectShot.src = "reflectShot.png";
playerShot.src = "playerShot.png";
playerShot2.src = "playerShot2.png";
slime1.src = "slime1.PNG";
slime2.src = "slime2.PNG";
slime3.src = "slime3.PNG";
slimeBoss.src = "slimeBoss.PNG";
crab1.src = "crab1.PNG";
crab2.src = "crab2.PNG";
crab3.src = "crab3.PNG";
crabBoss.src = "crabBoss.PNG";
fairy1.src = "fairy1.PNG";
fairy2.src = "fairy2.PNG";
fairy3.src = "fairy3.PNG";
fairyBoss.src = "fairyBoss.PNG";
tutankhamun1.src = "tutankhamun1.PNG";
tutankhamun2.src = "tutankhamun2.PNG";
tutankhamun3.src = "tutankhamun3.PNG";
tutankhamunBoss.src = "tutankhamunBoss.PNG";
skeleton1.src = "skeleton1.PNG";
skeleton2.src = "skeleton2.PNG";
skeleton3.src = "skeleton3.PNG";
skeletonBoss.src = "skeletonBoss.PNG";
lastBoss.src = "lastBoss.PNG";
//snow.src = "snow.PNG";

function drawSprite(snum,name,x,y,s){
    let sx = sprite[snum].x;
    let sy = sprite[snum].y;
    let sw = sprite[snum].w;
    let sh = sprite[snum].h;

    let pw = sw / s;
    let ph = sh / s;
    let px = (x >> 8) - pw / 2;
    let py = (y >> 8) - ph / 2;

    if(px + pw / 2 < camera_x - 50 || px - pw / 2 >= camera_x + SCREEN_W + 50|| py + ph / 2 < camera_y - 50 || py - ph / 2 >= camera_y + SCREEN_H) return;

    vcon.drawImage(name,sx,sy,sw,sh,px,py,pw,ph);
}