jQuery(document).ready(function ($) {

    var $rootNavElement = $('.nav-bar'),
        $mainPartNavElement = $('#nav'),
        $helpLinkNavElement = $('#page-help-link'),
        $supportLinkNavElement = $('.link-ecomitize-support'),
        $systemNavElement = $('.System'),
        menuItemsCopiedArray = [],
        resizeCounter = 0;

    var moreTemplate =  '<li onmouseover="Element.addClassName(this,\'over\')" onmouseout="Element.removeClassName(this,\'over\')" class="more-root parent level0">'+
        '<a href="#" onclick="return false" class=""><span>More</span></a>'+
        '<ul id="moreUl"></ul>'+
        '</li>';

    var getChildsSize = function(childOne,childTwo,childThree,childFour){
        return childOne.width() + childTwo.width() + childThree.width() + childFour.width();
    };

    var getRootSize = function(rootNavElement){
        return rootNavElement.width();
    };

    var needToMinimize = function(rootSize, childSize, delta=0){
        return (rootSize - delta) < childSize;
    };

    var needToMaximize = function(rootSize, childSize, delta=20){
        return (rootSize - childSize ) > delta;
    };

    var createMenuItem = function(rootElement){
        if( !$('.more-root').length ) $mainPartNavElement.append(moreTemplate);
    };

    var removeMenuItem = function(){
        $('.more-root').remove();
    };

    var copyMenu = function(itmesArray){
        if(menuItemsCopiedArray.length == 0){
            itmesArray.each(function(key,value){
                menuItemsCopiedArray[key] = $(value);
            });
        }
    };

    var getIndex = function(itemsLength, counter){
        var delta = itemsLength-counter;
        return delta>0?delta:itemsLength;
    };

    var navResize = function(){
        var rootSize = getRootSize($rootNavElement);
        var childsSize = getChildsSize($mainPartNavElement,$helpLinkNavElement,$supportLinkNavElement,$systemNavElement);
        var $mainPartChildsNavElement = $mainPartNavElement.children();
        var lastFromMoreItem = $('#moreUl').children();

        copyMenu($mainPartNavElement.first().children());

        if(needToMinimize(rootSize, childsSize,100)){
            resizeCounter++;
            createMenuItem();
            var needleIndex = getIndex(menuItemsCopiedArray.length, resizeCounter);
            $('#moreUl').append(menuItemsCopiedArray[needleIndex]);
        }

        if(needToMaximize(rootSize, childsSize,200) ){
            resizeCounter--;
            if( lastFromMoreItem.length > 0){
                lastFromMoreItem.last().remove().last().insertBefore( ".more-root" );
                if(lastFromMoreItem.length == 1) removeMenuItem();
            }
        }

    };

    navResize();
    $(window).resize(navResize);

});