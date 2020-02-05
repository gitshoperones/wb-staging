
$.fn.clicktoggle = function(a,b,elem){
    return this.each(function() {
        var clicked = false;
        $(this).bind("click",function() {
            if (clicked) {
                clicked = false;
                return b.apply(this,arguments);
            }
            clicked = true;
            return a.apply(this,arguments);
        });
    });
};
