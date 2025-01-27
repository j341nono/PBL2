//背景クラス
class View{
    constructor(){
        this.x = (FIELD_W / 2) << 8;
        this.y = (FIELD_H / 2) << 8;
        this.s = 2.5;
        this.anime = 3;
        if(document.getElementById("stage_select").value == 1){
            this.image = stage1view;
        }else if(document.getElementById("stage_select").value == 2){
            this.image = stage2view;
        }else if(document.getElementById("stage_select").value == 3){
              this.image = stage3view;
        }else if(document.getElementById("stage_select").value == 4){
            this.image = stage4view;
        }else if(document.getElementById("stage_select").value == 5){
            this.image = stage5view;
        }else if(document.getElementById("stage_select").value == 6){
            this.image = stage6view;
        }
    }
    
    update() {
    }

    draw(){
        drawSprite(this.anime, this.image, this.x, this.y, this.s);
    }
}

let view = new View();