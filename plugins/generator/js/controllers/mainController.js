app.controller("mainController", function($scope, $http){

    $scope.results = [];
    $scope.hotspots = [];

    $scope.hotspotChoices = {  
                            lat:"0", 
                            lng:"0", 
                            url:"http://www.fjordsite.dk", 
                            urlTarget:["lightBox", "_blank", "_parent"], 
                            hotspotClass:"hotspotoverride", 
                            hotspotIcon:['textures/hotspotIconsBlue/large_LT.png','textures/hotspotIconsBlueFlower/large_LT.png','textures/hotspotIconsGreen/large_LT.png','textures/hotspotIconsGreenBobbles/large_LT.png','textures/hotspotIconsGreenFlower/large_LT.png','textures/hotspotIconsGreenSquares1/large_LT.png','textures/hotspotIconsGreenSquares2/large_LT.png','textures/hotspotIconsOrange/large_LT.png','textures/hotspotIconsOrangeBobbles/large_LT.png','textures/hotspotIconsOrangeFlower/large_LT.png','textures/hotspotIconsBlue/medium_LT.png','textures/hotspotIconsBlueFlower/medium_LT.png','textures/hotspotIconsGreen/medium_LT.png','textures/hotspotIconsGreenBobbles/medium_LT.png','textures/hotspotIconsGreenFlower/medium_LT.png','textures/hotspotIconsGreenSquares1/medium_LT.png','textures/hotspotIconsGreenSquares2/medium_LT.png','textures/hotspotIconsOrange/medium_LT.png','textures/hotspotIconsOrangeBobbles/medium_LT.png','textures/hotspotIconsOrangeFlower/medium_LT.png','textures/hotspotIconsBlue/micro_LT.png','textures/hotspotIconsBlueFlower/micro_LT.png','textures/hotspotIconsGreen/micro_LT.png','textures/hotspotIconsGreenBobbles/micro_LT.png','textures/hotspotIconsGreenFlower/micro_LT.png','textures/hotspotIconsGreenSquares1/micro_LT.png','textures/hotspotIconsGreenSquares2/micro_LT.png','textures/hotspotIconsOrange/micro_LT.png','textures/hotspotIconsOrangeBobbles/micro_LT.png','textures/hotspotIconsOrangeFlower/micro_LT.png','textures/hotspotIconsBlue/nano_LT.png','textures/hotspotIconsBlueFlower/nano_LT.png','textures/hotspotIconsGreen/nano_LT.png','textures/hotspotIconsGreenBobbles/nano_LT.png','textures/hotspotIconsGreenFlower/nano_LT.png','textures/hotspotIconsGreenSquares2/nano_LT.png','textures/hotspotIconsOrange/nano_LT.png','textures/hotspotIconsOrangeBobbles/nano_LT.png','textures/hotspotIconsOrangeFlower/nano_LT.png','textures/hotspotIconsBlue/small_LT.png','textures/hotspotIconsBlueFlower/small_LT.png','textures/hotspotIconsGreen/small_LT.png','textures/hotspotIconsGreenBobbles/small_LT.png','textures/hotspotIconsGreenFlower/small_LT.png','textures/hotspotIconsGreenSquares1/small_LT.png','textures/hotspotIconsGreenSquares2/small_LT.png','textures/hotspotIconsOrange/small_LT.png','textures/hotspotIconsOrangeBobbles/small_LT.png','textures/hotspotIconsOrangeFlower/small_LT.png'], 
                            hotspotAlign:[
                                            {"value":'LT',"text":"Left-Top"},
                                             {"value":'MT',"text":"Middle-Top"},
                                             {"value":'RT',"text":"Right-Top"},
                                             {"value":'LM',"text":"Left-Middle"},
                                             {"value":'MM',"text":"Middle-Middle"},
                                             {"value":'RM',"text":"Right-Middle"},
                                             {"value":'LB',"text":"Left-Bottom"},
                                             {"value":'MB',"text":"Middle-Bottom"}, 
                                             {"value":'RB',"text":"Right-Bottom"}
                                        ], 
                            clickExternal:"",
                            content:"",
                            headtxt:""
                        };

    $scope.hotspot = {  
                            lat:"0", 
                            lng:"0", 
                            url:"", 
                            urlTarget:"_blank", 
                            hotspotClass:"hotspotoverride", 
                            hotspotIcon:"", 
                            hotspotAlign:"LT", 
                            clickExternal:"",
                            headtxt:"",
                            content:""
                        };

    var top= '<!doctype html>\n<html lang="en">\n\t<head>\n\t<title>HTML5 globe - Interactive 3D globe</title>\n\t<meta charset="utf-8">\n\t<meta name="viewport" content="width=device-width, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">\n\t<link rel="stylesheet" href="css/colorbox.css">\n\t<link rel="stylesheet" href="css/earthviewer_styles.min.css">\n\t<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>\n\t<script src="js/globe.min.js"></script>\n</head>\n<body>\n\t<h1>HTML5 Globe</h1>\n\t<div id="globeGl_" class="globeGl"></div>'

    var globestart = '\t<script>\n\t\t$("div#globeGl_").globe({\n'

    var bottom = '\t\t});\n\t</script>\n</body>\n</html>'


    $scope.init = function() {
        var mainOptions = g.globe('getOptions')
        angular.forEach(mainOptions, function(value, index){
            value.label = index
            $scope.results.push(value);
        });
        
        updateHotspotsArray()
        
    }

    $scope.onValChange = function(){
        reInitGlobe()
    }

    $scope.addHotSpot = function(){

        //add div element to hotspotcontainer
        var newHotspot = $('<div/>', {
            class: 'hotspot hidden',
            'data-lat': $scope.hotspot.lat,
            'data-long': $scope.hotspot.lng,
            'data-url': $scope.hotspot.url,
            'data-urltarget': $scope.hotspot.urlTarget,
            'data-hotspotclass': $scope.hotspot.hotspotClass,
            'data-hotspoticon': $scope.hotspot.hotspotIcon,
            'data-hotspotalign': $scope.hotspot.hotspotAlign,
            'data-clickexternal': $scope.hotspot.clickExternal,
            'data-headtxt': $scope.hotspot.headtxt,
            'text': $scope.hotspot.content

        }).appendTo($('body'));

        //update hotspots array
        updateHotspotsArray()

        // update globe
        reInitGlobe()
    }
    $scope.populateCoords = function(){
        var coords = g.globe('getCoords');
        $scope.hotspot.lat = coords.lat
        $scope.hotspot.lng = coords.lon

    }

    $scope.changeIcon = function(e){
        $scope.hotspot.hotspotIcon = e.currentTarget.dataset.path
        //close modal
        $('#myModal').modal('hide')
    }

    reInitGlobe = function(){
        //refresh globe
        var currRotation = g.globe('getRotation')

        g.globe('reInit',currRotation)
    }

    updateHotspotsArray = function(){
        var hotspotOutputContainer = $("#hotspot_output")
        hotspotOutputContainer.val('')

        var hotspots
        hotspots = $(".hotspot")
        $scope.hotspots = []
        var htmlContent = '';
        angular.forEach(hotspots, function(value, index){

            $scope.hotspots.push(value);

            htmlContent += '\n\t' + $(value)[0].outerHTML +'\n'
        });

        //generate options
        var settings = ''
        var quote = ''
         angular.forEach($scope.results, function(value, index){
            if(typeof(value.val) == 'string'){
                quote = '"'
            }else{
                quote = ''
            }

            settings += '\t\t\t' + value.label+':{val:' + quote + value.val + quote + '},\n'

        });

        //generate output 
        hotspotOutputContainer.val(top + htmlContent + globestart + settings + bottom )
    }



});