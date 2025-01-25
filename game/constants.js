//ゲームスピード
const GAME_SPEED = 1000 / 30;

//画面サイズ
const SCREEN_W = 320;
const SCREEN_H = 320;

//キャンバスサイズ
const CANVAS_W = SCREEN_W * 1;
const CANVAS_H = SCREEN_H * 1;

//フィールドサイズ
const FIELD_W = SCREEN_W * 1;
const FIELD_H = SCREEN_H * 1;

//カメラの座標
let camera_x = 0;
let camera_y = 0;

//ステージの長さ
let STAGE_LEN = 150;

//キーボードの状態
let key=[];

document.onkeydown = function(e){
    key[e.keyCode] = true;
}

document.onkeyup = function(e){
    key[e.keyCode] = false;
}
