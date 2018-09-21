document.addEventListener("DOMContentLoaded", function(event) {

    var typeSelect = document.getElementsByName("parameters[popup_type]")[0];
    var popupTypeIndex = typeSelect.selectedIndex;
    var selectedTypeValue = typeSelect[popupTypeIndex].value;
    var image = document.getElementsByName("parameters[popup_image]")[0].parentElement.parentElement;
    var videoFrom = document.getElementsByName("parameters[popup_video_from]")[0].parentElement.parentElement;
    var youtubeLink = document.getElementsByName("parameters[popup_youtube_link]")[0].parentElement.parentElement;
    var vimeoLink = document.getElementsByName("parameters[popup_vimeo_link]")[0].parentElement.parentElement;
    var iframeLink = document.getElementsByName("parameters[popup_iframe_link]")[0].parentElement.parentElement;

    var showTableRow = function($obj){
        $obj.style.display = 'table-row';
    }

    var hideTableRow = function($obj){
        $obj.style.display = 'none';
    }

    var show = function (parameter){

        if( parameter.type == "change" ){
            parameter = parameter.target.value;
        }

        if(parameter == 'banner'){
            showTableRow(image);
            hideTableRow(videoFrom);
            hideTableRow(vimeoLink);
            hideTableRow(youtubeLink);
            showTableRow(iframeLink);
        }else if(parameter == 'iframe'){
            showTableRow(iframeLink);
            hideTableRow(image);
            hideTableRow(videoFrom);
            hideTableRow(vimeoLink);
            hideTableRow(youtubeLink);
        }else if(parameter == 'video'){
            hideTableRow(image);
            showTableRow(videoFrom);
            showTableRow(vimeoLink);
            showTableRow(youtubeLink);
            hideTableRow(iframeLink);
        }else if(parameter == 'subscribe'){
            showTableRow(image);
            hideTableRow(videoFrom);
            hideTableRow(vimeoLink);
            hideTableRow(youtubeLink);
            hideTableRow(iframeLink);
        }

    }

    typeSelect.addEventListener("change", show);
    show(selectedTypeValue);

});



