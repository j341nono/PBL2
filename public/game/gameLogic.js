function checkHit(x1, y1, r1, x2, y2, r2) {
    let a = (x2 - x1) >> 8;
    let b = (y2 - y1) >> 8;
    let r = r1 + r2;
    return r * r > a * a + b * b;
}

function shot8(x,y,speed,degree) {
    for(i = 0; i< 8; i++){
        mons_bullet.push(new MonsBullet(x, y, speed * Math.sin((degree + i * 45) * Math.PI / 180), speed * Math.cos((degree + i * 45) * Math.PI / 180)) );
    }
}

function returnShot8(x,y,speed,degree) {
    for(i = 0; i< 8; i++){
        mons_bullet.push(new ReturnBullet(x, y, speed * Math.sin((degree + i * 45) * Math.PI / 180), speed * Math.cos((degree + i * 45) * Math.PI / 180)) );
    }
}

function reflectShot8(x,y,speed,degree) {
    for(i = 0; i< 8; i++){
        mons_bullet.push(new ReflectBullet(x, y, speed * Math.sin((degree + i * 45) * Math.PI / 180), speed * Math.cos((degree + i * 45) * Math.PI / 180)) );
    }
}

function divisionShot8(x,y,speed,degree) {
    for(i = 0; i< 8; i++){
        mons_bullet.push(new DivisionBullet(x, y, speed * Math.sin((degree + i * 45) * Math.PI / 180), speed * Math.cos((degree + i * 45) * Math.PI / 180)) );
    }
}