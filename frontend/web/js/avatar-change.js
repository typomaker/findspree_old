/**
 * Created by albert on 05.03.15.
 */
(function(){
    var el,action,handler,jCrop;
    el={
        $container:$('#avatar-change-container'),
        $loader:$('#avatar-change-loader'),
        $cropper:$('#avatar-change-cropper'),
        $img:$('#avatar-change-img'),
        $input:$('#avatarform-img'),
        button:{
            $confirm:$('#avatar-change-confirm'),
            $cancel:$('#avatar-change-cancel')
        },
        coordinate:{
            $x:$('#avatarform-x'),
            $y:$('#avatarform-y'),
            $x2:$('#avatarform-x2'),
            $y2:$('#avatarform-y2'),
            $w:$('#avatarform-w'),
            $h:$('#avatarform-h'),
            $oW:$('#avatarform-ow'),
            $oH:$('#avatarform-oh')
        }
    };

    handler={
        memCoordinates:function(c){
            el.coordinate.$x.val(c.x);
            el.coordinate.$y.val(c.y);
            el.coordinate.$x2.val(c.x2);
            el.coordinate.$y2.val(c.y2);
            el.coordinate.$w.val(c.w);
            el.coordinate.$h.val(c.h);
            el.coordinate.$oH.val(el.$img.height());
            el.coordinate.$oW.val(el.$img.width());
            action.cropEnd();
        }
    };
    jCrop = {
        _api:null,
        destroy:function(){
            if(jCrop._api){
                jCrop._api.destroy();
            }
        },
        init:function(){
            this.destroy();

            el.$img.outerWidth();
            el.$img.outerHeight();
            console.log(el.$img.outerHeight(),el.$img.outerWidth());
            var halfHeight = el.$img.outerHeight()/2;
            var halfWight = el.$img.outerWidth()/2;
            var leftX = halfWight-120;
            var leftY = halfHeight-120;
            var rightX = halfWight+120;
            var rightY = halfHeight+120;

            this._api = $.Jcrop(el.$img.selector,{
                minSize: [ 30, 30 ],
                //maxSize: [ 300, 300 ],
                aspectRatio:1,
                onChange: handler.memCoordinates,
                onSelect: handler.memCoordinates
            });
            this._api.animateTo([rightX,rightY,leftX,leftY]);
        }
    };
    action={
        loader:function(){
            jCrop.destroy();
            el.$img.attr('src','').attr('style','');
            el.$loader.show();
            el.$cropper.hide();
        },
        cropEnd:function(){
            el.button.$confirm.fadeIn(300);
            el.button.$cancel.fadeIn(300);
        },
        cropper:function(){
            var input = el.$input[0];
            if (input.files && input.files[0]) {
                el.$loader.hide();
                el.$cropper.show();
                el.button.$confirm.hide();
                el.button.$cancel.show();
                if (input.files[0].type.match('image.*')) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        el.$img.attr('src',e.target.result);
                        jCrop.init();
                    };
                    reader.readAsDataURL(input.files[0]);
                } else console.log('is not image mime type');
            } else console.log('not isset files data or files API not supordet');

        }
    };
    el.$input.on('change',action.cropper);
    el.button.$cancel.on('click',action.loader);
    action.loader();
})();