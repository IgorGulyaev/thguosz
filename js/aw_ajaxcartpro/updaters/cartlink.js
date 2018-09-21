var AW_AjaxCartProUpdaterObject = new AW_AjaxCartProUpdater('cartLink', ['.top-link-cart']);
Object.extend(AW_AjaxCartProUpdaterObject, {
    updateOnUpdateRequest: true,
    updateOnActionRequest: false,
    beforeUpdate: function(html){
        /*$('top-link-cart-affix').replace(html);*/
        return null;
    },
    afterUpdate: function(html, selectors){
        /*$('top-link-cart-affix').replace(html);*/
        return null;
    }
});
AW_AjaxCartPro.registerUpdater(AW_AjaxCartProUpdaterObject);
delete AW_AjaxCartProUpdaterObject;