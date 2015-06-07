<span class='selector-wrapper'>
<span class='selector'>
  <ul>
<?php
        $menu = $this->get('edit_menu');
        foreach($menu as $item) {
?>
    <li>
        <input id="<?=$item['id']?>" type='checkbox'>
        <label for="<?=$item['id']?>"><i class="fa fa-<?=$item['icon']?>"></i></label>
    </li>
<?php
        }
?>
  </ul>
  <button><i class="fa fa-navicon"></i></button>
</span>
</span>

<script>
var ctx_menu_angleStart = -360;

// jquery rotate animation
function ctx_menu_rotate(li,d) {
    jQuery({d:ctx_menu_angleStart}).animate({d:d}, {
        step: function(now) {
            jQuery(li)
               .css({ transform: 'rotate('+now+'deg)' })
               .find('label')
                  .css({ transform: 'rotate('+(-now)+'deg)' });
        }, duration: 0
    });
}

// show / hide the options
function ctx_menu_toggleOptions(s) {
    jQuery(s).toggleClass('open');
    var li = jQuery(s).find('li');
    var deg = jQuery(s).hasClass('half') ? 180/(li.length-1) : 360/li.length;
    for(var i=0; i<li.length; i++) {
        var d = jQuery(s).hasClass('half') ? (i*deg)-90 : i*deg;
        jQuery(s).hasClass('open') ? ctx_menu_rotate(li[i],d) : ctx_menu_rotate(li[i],ctx_menu_angleStart);
    }
}

function ctx_menu_click(fn) {
    jQuery('.selector li').click(function() {
        var action = jQuery(this).find('input').attr('id');
        fn(action);
    });
}

jQuery('.selector button').click(function(e) {
    ctx_menu_toggleOptions(jQuery(this).parent());
});
</script>
