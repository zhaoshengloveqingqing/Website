<style>
    html,body {
        height: 100%;
    }
    #place_container {
        height: 100%;
    }
</style>
<div id="place_container"></div>
{js}
<script src="http://api.map.baidu.com/api?v=2.0&ak=7NO0hPZuKGe4tWebExBZ4GXc" type="text/javascript"></script>
<script src="http://api.map.baidu.com/getscript?v=2.0&ak=7NO0hPZuKGe4tWebExBZ4GXc&services=&t=20140918163145" type="text/javascript"></script>
<script type="text/javascript">
var map;
var localSearch;

function searchAddress(){
    localSearch.search($(window.parent.document).find('#field_search_name').val());
}

function refreshLocationOnMap(longitude, latitude){
    map.clearOverlays();
    var point = new BMap.Point(longitude, latitude);
    var mk = new BMap.Marker(point);
    map.centerAndZoom(point, 13);
    map.addOverlay(mk);
}

$(function(){
    map = new BMap.Map("place_container");
    var point = new BMap.Point(116.404, 39.915);
    map.centerAndZoom(point, 15);
    localSearch = new BMap.LocalSearch(map);
    map.setDefaultCursor("crosshair");
    map.enableScrollWheelZoom();
    localSearch.setSearchCompleteCallback(function (searchResult) {
　　　　var poi = searchResult.getPoi(0);
　　　　map.centerAndZoom(poi.point, 13);
　　});

    map.addEventListener("click", function(e){
        console.log($(window.parent.document).find('#field_latitude'));
        $(window.parent.document).find('#field_latitude').val(e.point.lat);
        $(window.parent.document).find('#field_longitude').val(e.point.lng);
        var myGeo = new BMap.Geocoder();
        myGeo.getLocation(new BMap.Point(e.point.lng, e.point.lat), function(result){
            if(result){
                $(window.parent.document).find('#field_address').val(result.addressComponents['province']+result.addressComponents['city']+result.addressComponents['street']+result.addressComponents['streetNumber']);
            }
        });
        refreshLocationOnMap(e.point.lng, e.point.lat);
    });
})
</script>